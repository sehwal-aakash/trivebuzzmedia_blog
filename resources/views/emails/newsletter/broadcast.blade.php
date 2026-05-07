<x-mail::message>
# {{ $subjectStr }}

{!! $content !!}

<x-mail::button :url="config('app.url')">
Read More Stories
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Team

<x-mail::subcopy>
You are receiving this because you subscribed to our newsletter at {{ config('app.url') }}. 
If you wish to stop receiving these emails, you can [unsubscribe here]({{ route('newsletter.unsubscribe', ['token' => 'placeholder']) }}).
</x-mail::subcopy>
</x-mail::message>
