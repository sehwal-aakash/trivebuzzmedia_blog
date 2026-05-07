<x-layout>
    <x-slot:title>
        Admin: Edit Tag - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('admin.tags.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Tags
            </a>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mt-4">Edit Tag: {{ $tag->name }}</h1>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 p-8">
            <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <x-form.label for="name" value="Name" />
                        <x-form.input type="text" name="name" id="name" :value="old('name', $tag->name)" required />
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-4">
                        <x-form.button size="lg">
                            Update Tag
                        </x-form.button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
