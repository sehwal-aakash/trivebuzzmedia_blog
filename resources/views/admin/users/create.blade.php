<x-admin-layout title="Add New User">

    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline flex items-center gap-1.5">
                &larr; Back to Users
            </a>
        </div>

        <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden p-6 md:p-8">
            <div class="mb-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Add Platform User</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Create a new user account with specific role permissions</p>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-form.label for="name" value="Full Name" />
                        <x-form.input type="text" name="name" id="name" :value="old('name')" required placeholder="e.g. John Doe" />
                        @error('name')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.label for="username" value="Username" />
                        <x-form.input type="text" name="username" id="username" :value="old('username')" required placeholder="e.g. johndoe" />
                        @error('username')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-form.label for="email" value="Email Address" />
                    <x-form.input type="email" name="email" id="email" :value="old('email')" required placeholder="john@example.com" />
                    @error('email')
                        <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-form.label for="role" value="Role Permission" />
                    <x-form.select name="role" id="role" required>
                        <option value="" disabled {{ old('role') === null ? 'selected' : '' }}>Select a role</option>
                        @foreach(App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value }}" {{ old('role') === $role->value ? 'selected' : '' }}>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </x-form.select>
                    @error('role')
                        <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <div>
                        <x-form.label for="password" value="Password" />
                        <x-form.input type="password" name="password" id="password" required />
                        @error('password')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-form.label for="password_confirmation" value="Confirm Password" />
                        <x-form.input type="password" name="password_confirmation" id="password_confirmation" required />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 text-xs font-bold text-slate-500 hover:text-slate-700">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-md shadow-blue-500/20">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>

