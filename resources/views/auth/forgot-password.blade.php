<x-layout>
    <x-slot:title>
        Forgot Password - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="min-h-[calc(100vh-16rem)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-zinc-950">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-zinc-900 shadow-md overflow-hidden sm:rounded-lg border border-zinc-200 dark:border-zinc-800">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 text-center">Forgot Password</h2>

            <div class="mb-4 text-sm text-zinc-600 dark:text-zinc-400">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email</label>
                    <input id="email" class="block mt-1 w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-zinc-900 dark:text-white" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-form.button class="w-full" size="lg">
                        Email Password Reset Link
                    </x-form.button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
