<x-mail::message>
# {{ $subjectStr }}

{!! $content !!}

<x-mail::button :url="config('app.url')" color="primary">
Explore Latest Stories on {{ config('app.name') }}
</x-mail::button>

Warm regards,<br>
**The {{ config('app.name', 'TriveBuzz Media') }} Editorial Team**

<x-mail::subcopy>
You are receiving this official update because you are subscribed to **{{ config('app.name') }}** ([{{ config('app.url') }}]({{ config('app.url') }})).
@if(!empty($unsubscribeToken))
If you no longer wish to receive these email updates, you can [unsubscribe from newsletter]({{ route('newsletter.unsubscribe', ['token' => $unsubscribeToken]) }}) at any time.
@endif
</x-mail::subcopy>
</x-mail::message>
