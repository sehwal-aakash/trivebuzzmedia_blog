<x-layout>
    <x-slot:title>
        Admin: Edit User - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Users
            </a>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mt-4">Edit User: {{ $user->name }}</h1>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 p-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-form.label for="name" value="Name" />
                            <x-form.input type="text" name="name" id="name" :value="old('name', $user->name)" required />
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="username" value="Username" />
                            <x-form.input type="text" name="username" id="username" :value="old('username', $user->username)" required />
                            @error('username')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <x-form.label for="email" value="Email Address" />
                        <x-form.input type="email" name="email" id="email" :value="old('email', $user->email)" required />
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.label for="role" value="Role" />
                        <x-form.select name="role" id="role" required>
                            @foreach(App\Enums\UserRole::cases() as $role)
                                <option value="{{ $role->value }}" {{ old('role', $user->role->value) === $role->value ? 'selected' : '' }}>
                                    {{ $role->label() }}
                                </option>
                            @endforeach
                        </x-form.select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-800">

                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 rounded-2xl border border-zinc-100 dark:border-zinc-800">
                        <p class="text-[11px] font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400 mb-6 italic">Leave password fields blank if you don't want to change the password.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-form.label for="password" value="New Password" />
                                <x-form.input type="password" name="password" id="password" />
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-form.label for="password_confirmation" value="Confirm New Password" />
                                <x-form.input type="password" name="password_confirmation" id="password_confirmation" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <x-form.button size="lg">
                            Update User
                        </x-form.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
