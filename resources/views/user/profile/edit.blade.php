<x-layout>
    <x-slot:title>
        Account Settings - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <h1 class="text-4xl font-black text-surface-900 dark:text-white uppercase tracking-tight">Account Settings</h1>
            <p class="text-surface-500 dark:text-surface-400 mt-2">Manage your personal information and security settings.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-surface-900 shadow-xl sm:rounded-2xl border border-surface-200 dark:border-surface-800 p-8">
            <form action="{{ route('account.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <x-form.label for="name" value="Full Name" />
                            <x-form.input type="text" name="name" id="name" :value="old('name', $user->name)" required />
                            @error('name')
                                <p class="mt-2 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="username" value="Username" />
                            <x-form.input type="text" name="username" id="username" :value="old('username', $user->username)" required />
                            @error('username')
                                <p class="mt-2 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <x-form.label for="email" value="Email Address" />
                        <x-form.input type="email" name="email" id="email" :value="old('email', $user->email)" required />
                        @error('email')
                            <p class="mt-2 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-8 border-t border-surface-100 dark:border-surface-800">
                        <h3 class="text-sm font-black uppercase tracking-widest text-surface-900 dark:text-white mb-6">Security Update</h3>
                        <p class="text-xs text-surface-500 dark:text-surface-400 mb-6 italic">Leave blank if you don't wish to change your password.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <x-form.label for="password" value="New Password" />
                                <x-form.input type="password" name="password" id="password" />
                                @error('password')
                                    <p class="mt-2 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-form.label for="password_confirmation" value="Confirm New Password" />
                                <x-form.input type="password" name="password_confirmation" id="password_confirmation" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-8">
                        <x-form.button size="lg">
                            Save Changes
                        </x-form.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
