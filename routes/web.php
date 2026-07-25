<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthorApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailLogController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Author\AIController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\Front\NewsletterController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\PostController as FrontPostController;
use App\Http\Controllers\Front\SEOController;
use App\Http\Controllers\Interaction\BookmarkController;
use App\Http\Controllers\Interaction\CommentController;
use App\Http\Controllers\User\AuthorApplicationController as UserApplicationController;
use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [FrontPostController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [FrontPostController::class, 'show'])->name('posts.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Dynamic Pages
Route::get('/category/{category:slug}', [PageController::class, 'category'])->name('category.show');
Route::get('/tag/{tag:slug}', [PageController::class, 'tag'])->name('tag.show');
Route::get('/@{user:username}', [PageController::class, 'profile'])->name('profile');

// Fix for Jetstream conflict/crash
Route::get('/user/profile', function () {
    $user = auth()->user();
    if (! $user->username) {
        $user->update(['username' => str()->slug($user->name).'-'.$user->id]);
    }

    return redirect()->route('profile', ['user' => $user->username]);
})->middleware('auth');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Auth Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Email Verification (Fortify handles these, but kept here for reference if needed)
    /*
    Route::get('verify-email', VerifyEmailController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, 'store'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    */

    // Verified Routes
    Route::middleware('verified')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // User Application Routes
        Route::get('/apply', [UserApplicationController::class, 'create'])->name('apply.create');
        Route::post('/apply', [UserApplicationController::class, 'store'])->name('apply.store');

        // Library (Bookmarks)
        Route::get('/library', [LibraryController::class, 'index'])->name('library');
        Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle'])->name('posts.bookmark');

        // Account / Profile Settings
        Route::get('/account', [ProfileController::class, 'edit'])->name('account.edit');
        Route::put('/account', [ProfileController::class, 'update'])->name('account.update');

        // Author Routes
        Route::middleware(['role:approved_author,admin,editor,super_admin'])->prefix('author')->name('author.')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\Author\DashboardController::class, 'index'])->name('dashboard');
            Route::resource('posts', AuthorPostController::class);

            // AI Routes
            Route::prefix('ai')->name('ai.')->group(function () {
                Route::post('/outline', [AIController::class, 'generateOutline'])->name('outline');
                Route::post('/titles', [AIController::class, 'generateTitles'])->name('titles');
                Route::post('/summary', [AIController::class, 'generateSummary'])->name('summary');
                Route::post('/keywords', [AIController::class, 'suggestKeywords'])->name('keywords');
            });
        });

        // Admin Routes
        Route::middleware(['role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('posts', AdminPostController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('tags', TagController::class);
            Route::resource('users', UserController::class);

            // Comment Management
            Route::get('/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
            Route::post('/comments/{comment}/approve', [App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
            Route::post('/comments/{comment}/reject', [App\Http\Controllers\Admin\CommentController::class, 'reject'])->name('comments.reject');
            Route::delete('/comments/{comment}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');

            // Newsletter Management
            Route::get('/newsletters', [App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('newsletters.index');
            Route::get('/newsletters/create', [App\Http\Controllers\Admin\NewsletterController::class, 'create'])->name('newsletters.create');
            Route::post('/newsletters/broadcast', [App\Http\Controllers\Admin\NewsletterController::class, 'store'])->name('newsletters.broadcast');
            Route::delete('/newsletters/{newsletter}', [App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('newsletters.destroy');

            // Activity Logs
            Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

            // Email Tracking Logs (Super Admin Only)
            Route::middleware(['role:super_admin'])->group(function () {
                Route::get('/email-logs', [EmailLogController::class, 'index'])->name('email-logs.index');
                Route::delete('/email-logs/{emailLog}', [EmailLogController::class, 'destroy'])->name('email-logs.destroy');
                Route::delete('/email-logs-purge', [EmailLogController::class, 'purge'])->name('email-logs.purge');
            });

            Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
            Route::get('/applications/{author_application}', [AdminApplicationController::class, 'show'])->name('applications.show');
            Route::post('/applications/{author_application}/approve', [AdminApplicationController::class, 'approve'])->name('applications.approve');
            Route::post('/applications/{author_application}/reject', [AdminApplicationController::class, 'reject'])->name('applications.reject');
        });
    });
});

// SEO Routes
Route::get('/sitemap.xml', [SEOController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SEOController::class, 'robots'])->name('robots');
