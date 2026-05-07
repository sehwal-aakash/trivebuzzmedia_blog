<x-layout>
    <x-slot:title>
        Verify Email - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="min-h-[calc(100vh-16rem)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-zinc-950">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-zinc-900 shadow-md overflow-hidden sm:rounded-lg border border-zinc-200 dark:border-zinc-800">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 text-center">Verify Your Email</h2>

            <div class="mb-4 text-sm text-zinc-600 dark:text-zinc-400">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-form.button>
                            Resend Verification Email
                        </x-form.button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="text-xs font-black uppercase tracking-widest text-surface-500 hover:text-surface-900 dark:hover:text-white transition-colors underline decoration-2 underline-offset-4">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
