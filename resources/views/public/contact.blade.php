<x-layout :seoTags="$seoTags ?? []">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-4xl font-extrabold text-zinc-900 dark:text-white mb-8">Contact Us</h1>
        <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800">
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-form.label for="name" value="Your Name" />
                    <x-form.input id="name" type="text" placeholder="John Doe" required />
                </div>
                <div>
                    <x-form.label for="email" value="Email Address" />
                    <x-form.input id="email" type="email" placeholder="john@example.com" required />
                </div>
                <div>
                    <x-form.label for="message" value="How can we help?" />
                    <x-form.textarea id="message" rows="5" placeholder="Tell us more about your inquiry..." required />
                </div>
                <div>
                    <x-form.button class="w-full" size="lg">
                        Send Message
                    </x-form.button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
