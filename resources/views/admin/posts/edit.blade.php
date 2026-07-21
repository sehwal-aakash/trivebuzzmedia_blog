<x-admin-layout title="Edit Post">

    <div class="max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.posts.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline flex items-center gap-1.5">
                &larr; Back to all posts
            </a>
        </div>

        <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden p-6 md:p-10">
            <div class="mb-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider">Edit Story (Admin Mode)</h2>
                <p class="text-xs font-medium text-slate-400 mt-1">Author: <span class="font-extrabold text-[#3c83f6]">{{ $post->author->name }}</span></p>
            </div>

            <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-form.label for="title" value="Post Title" />
                    <x-form.input
                        type="text"
                        name="title"
                        id="title"
                        :value="old('title', $post->title)"
                        required
                        placeholder="Enter post title"
                    />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-form.label for="category_id" value="Category" />
                        <x-form.select
                            name="category_id"
                            id="category_id"
                            required
                        >
                            <option value="">Select a category</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-form.label for="status" value="Publication Status" />
                        <x-form.select
                            name="status"
                            id="status"
                            required
                        >
                            @foreach(\App\Enums\PostStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', $post->status->value) == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </x-form.select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-form.label for="excerpt" value="Short Excerpt" />
                    <x-form.textarea
                        name="excerpt"
                        id="excerpt"
                        rows="3"
                        placeholder="Brief summary of the post"
                    >{{ old('excerpt', $post->excerpt) }}</x-form.textarea>
                    <x-input-error :messages="$errors->get('excerpt')" class="mt-2" />
                </div>

                <div>
                    <x-form.label for="content" value="Story Content" />
                    <x-form.textarea
                        name="content"
                        id="content"
                        rows="12"
                        required
                        placeholder="Write your post content here..."
                    >{{ old('content', $post->content) }}</x-form.textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('admin.posts.index') }}" class="px-4 py-2.5 text-xs font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white rounded-xl text-xs font-black uppercase tracking-wider transition-all shadow-md shadow-blue-500/20">
                        Save Post Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>

