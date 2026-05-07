<x-layout>
    <x-slot:title>
        Admin: Edit Post - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <a href="{{ route('admin.posts.index') }}" class="text-xs font-black uppercase tracking-widest text-surface-500 hover:text-brand transition-colors">
                &larr; Back to all posts
            </a>
            <h1 class="text-4xl font-black text-surface-900 dark:text-white mt-4 uppercase tracking-tighter">Edit Post (Admin)</h1>
            <p class="text-sm font-bold text-surface-500 mt-2 italic">Author: <span class="text-brand">{{ $post->author->name }}</span></p>
        </div>

        <div class="bg-white dark:bg-surface-900 shadow-2xl sm:rounded-[2rem] border border-surface-100 dark:border-surface-800 p-8 md:p-12">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="space-y-8">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                        <x-form.label for="status" value="Status" />
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
                        rows="15"
                        required
                        placeholder="Write your post content here..."
                    >{{ old('content', $post->content) }}</x-form.textarea>
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-8 pt-10 border-t border-surface-100 dark:border-surface-800">
                    <a href="{{ route('admin.posts.index') }}" class="text-xs font-black uppercase tracking-widest text-surface-400 hover:text-surface-600 transition-colors">
                        Discard Changes
                    </a>
                    <x-form.button size="lg">
                        Save Changes
                    </x-form.button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
