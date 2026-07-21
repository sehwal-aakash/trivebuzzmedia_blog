<?php

namespace App\Http\Controllers\User;

use App\Domains\User\Services\AuthorApplicationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SubmitAuthorApplicationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthorApplicationController extends Controller
{
    public function __construct(
        protected AuthorApplicationService $applicationService
    ) {}

    public function create(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->isAuthor() || $user->isAdmin()) {
            return redirect()->route('dashboard')->with('info', 'You are already an approved author or administrator.');
        }

        if ($user->application && $user->application->status->value === 'pending') {
            return redirect()->route('dashboard')->with('info', 'You already have an application under review.');
        }

        return view('user.applications.create');
    }

    public function store(SubmitAuthorApplicationRequest $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user->isAuthor() || $user->isAdmin()) {
            return redirect()->route('dashboard')->with('info', 'You are already an approved author or administrator.');
        }

        if ($user->application && $user->application->status->value === 'pending') {
            return redirect()->route('dashboard')->with('info', 'You already have an application under review.');
        }

        $this->applicationService->submitApplication($user, $request->validated());

        return redirect()->route('dashboard')->with('success', 'Your application has been submitted and is pending review.');
    }
}
