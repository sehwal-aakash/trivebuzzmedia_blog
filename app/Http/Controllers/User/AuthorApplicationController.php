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

    public function create(): View
    {
        return view('user.applications.create');
    }

    public function store(SubmitAuthorApplicationRequest $request): RedirectResponse
    {
        $this->applicationService->submitApplication(auth()->user(), $request->validated());

        return redirect()->route('dashboard')->with('success', 'Your application has been submitted and is pending review.');
    }
}
