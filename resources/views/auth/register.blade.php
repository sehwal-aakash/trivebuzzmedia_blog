<x-layout>
    <x-slot:title>
        Register - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="min-h-[calc(100vh-16rem)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-surface-50 dark:bg-surface-950">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-surface-900 shadow-2xl overflow-hidden sm:rounded-[2rem] border border-surface-100 dark:border-surface-800">
            <h2 class="text-3xl font-black text-surface-900 dark:text-white mb-2 text-center uppercase tracking-tighter">Create Account</h2>
            <p class="text-center text-surface-500 dark:text-surface-400 text-sm mb-10 font-medium tracking-tight">Join our community of world-class storytellers.</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-form.label for="name" value="Full Name" />
                    <x-form.input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-form.label for="email" value="Email Address" />
                    <x-form.input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-form.label for="password" value="Password" />
                    <x-form.input id="password" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-form.label for="password_confirmation" value="Confirm Password" />
                    <x-form.input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div>
                    <x-form.button class="w-full" size="lg">
                        Create Account
                    </x-form.button>
                </div>
            </form>

            <div class="mt-8 text-center text-xs font-bold uppercase tracking-widest text-surface-400">
                Already registered? 
                <a href="{{ route('login') }}" class="text-brand hover:underline">Sign In</a>
            </div>
        </div>
    </div>
</x-layout>
