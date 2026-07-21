<x-admin-layout title="Add New Category">

    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline flex items-center gap-1.5">
                &larr; Back to Categories
            </a>
        </div>

        <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden p-6 md:p-8">
            <div class="mb-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Create Category</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Add a new high-level content domain</p>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <x-form.label for="name" value="Category Name" />
                    <x-form.input type="text" name="name" id="name" :value="old('name')" required placeholder="e.g. Technology, Finance, Health" />
                    @error('name')
                        <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-form.label for="description" value="Description (Optional)" />
                    <x-form.textarea name="description" id="description" rows="4" placeholder="Brief summary of what this category covers">{{ old('description') }}</x-form.textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 text-xs font-bold text-slate-500 hover:text-slate-700">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 bg-[#16a249] hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-md shadow-emerald-600/20">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>

