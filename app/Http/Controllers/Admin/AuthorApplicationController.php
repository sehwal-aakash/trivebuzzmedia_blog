<?php

namespace App\Http\Controllers\Admin;

use App\Domains\User\Services\AuthorApplicationService;
use App\Http\Controllers\Controller;
use App\Models\AuthorApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthorApplicationController extends Controller
{
    public function __construct(
        protected AuthorApplicationService $applicationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $applications = AuthorApplication::with('user')->latest()->paginate(15);

        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthorApplication $authorApplication): View
    {
        return view('admin.applications.show', compact('authorApplication'));
    }

    /**
     * Approve the application.
     */
    public function approve(AuthorApplication $authorApplication): RedirectResponse
    {
        $this->applicationService->approveApplication($authorApplication);

        return redirect()->route('admin.applications.index')->with('success', 'Application approved successfully.');
    }

    /**
     * Reject the application.
     */
    public function reject(AuthorApplication $authorApplication): RedirectResponse
    {
        $this->applicationService->rejectApplication($authorApplication);

        return redirect()->route('admin.applications.index')->with('success', 'Application rejected.');
    }
}
