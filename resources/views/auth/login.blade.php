<x-layout>
    <x-slot:title>
        Log in - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="min-h-[calc(100vh-16rem)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-surface-50 dark:bg-surface-950">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-surface-900 shadow-2xl overflow-hidden sm:rounded-[2rem] border border-surface-100 dark:border-surface-800">
            <h2 class="text-3xl font-black text-surface-900 dark:text-white mb-2 text-center uppercase tracking-tighter">Welcome Back</h2>
            <p class="text-center text-surface-500 dark:text-surface-400 text-sm mb-10 font-medium tracking-tight">Access your storyteller dashboard.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-form.label for="email" value="Email Address" />
                    <x-form.input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-form.label for="password" value="Password" />
                    <x-form.input id="password" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded-lg border-surface-200 dark:border-surface-800 dark:bg-surface-950 text-brand focus:ring-brand/20" name="remember">
                        <span class="ms-2 text-xs font-black uppercase tracking-widest text-surface-500 group-hover:text-surface-900 dark:group-hover:text-surface-100 transition-colors">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs font-black uppercase tracking-widest text-surface-400 hover:text-brand transition-colors" href="{{ route('password.request') }}">
                            Forgot?
                        </a>
                    @endif
                </div>

                <div>
                    <x-form.button class="w-full" size="lg">
                        Sign In
                    </x-form.button>
                </div>
            </form>
            
            <div class="mt-8 text-center text-xs font-bold uppercase tracking-widest text-surface-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-brand hover:underline">Register now</a>
            </div>
        </div>
    </div>
</x-layout>
