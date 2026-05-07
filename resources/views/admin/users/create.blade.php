<x-layout>
    <x-slot:title>
        Admin: Add User - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Users
            </a>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mt-4">Add New User</h1>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 p-8">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-form.label for="name" value="Name" />
                            <x-form.input type="text" name="name" id="name" :value="old('name')" required />
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="username" value="Username" />
                            <x-form.input type="text" name="username" id="username" :value="old('username')" required />
                            @error('username')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <x-form.label for="email" value="Email Address" />
                        <x-form.input type="email" name="email" id="email" :value="old('email')" required />
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.label for="role" value="Role" />
                        <x-form.select name="role" id="role" required>
                            <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>Select a role</option>
                            @foreach(App\Enums\UserRole::cases() as $role)
                                <option value="{{ $role->value }}" {{ old('role') === $role->value ? 'selected' : '' }}>
                                    {{ $role->label() }}
                                </option>
                            @endforeach
                        </x-form.select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-zinc-200 dark:border-zinc-800">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-form.label for="password" value="Password" />
                            <x-form.input type="password" name="password" id="password" required />
                            @error('password')
                                <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.label for="password_confirmation" value="Confirm Password" />
                            <x-form.input type="password" name="password_confirmation" id="password_confirmation" required />
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <x-form.button size="lg" variant="primary">
                            Create User
                        </x-form.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
