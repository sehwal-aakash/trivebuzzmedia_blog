<x-admin-layout title="Users Management">

    <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">User Directory</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Manage member roles, permissions and account access</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-blue-500/20 inline-flex items-center gap-1.5 self-start md:self-auto">
                + Add New User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">User Details</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Joined Date</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0f1729] to-[#3c83f6] text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-extrabold text-[#0f1729] dark:text-slate-100">{{ $user->name }}</div>
                                        <div class="text-xs font-medium text-slate-400 mt-0.5">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg {{ $user->role->value === 'super_admin' ? 'bg-purple-50 text-purple-600 dark:bg-purple-950/50' : ($user->role->value === 'approved_author' ? 'bg-emerald-50 text-[#16a249] dark:bg-emerald-950/50' : 'bg-blue-50 text-[#3c83f6] dark:bg-blue-950/50') }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-[#3c83f6] hover:text-white text-[#0f1729] dark:text-slate-200 text-xs font-bold rounded-lg transition-all inline-block">Edit</a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-bold rounded-lg transition-all">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
            {{ $users->links() }}
        </div>
    </div>

</x-admin-layout>

