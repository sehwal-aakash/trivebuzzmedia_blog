<x-mail::message>
# {{ $subjectStr }}

{!! $content !!}

<x-mail::button :url="config('app.url')">
Read More Stories
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Team

<x-mail::subcopy>
You are receiving this update from {{ config('app.name') }} ({{ config('app.url') }}).
@if(!empty($unsubscribeToken))
If you wish to stop receiving these emails, you can [unsubscribe here]({{ route('newsletter.unsubscribe', ['token' => $unsubscribeToken]) }}).
@endif
</x-mail::subcopy>
</x-mail::message>
