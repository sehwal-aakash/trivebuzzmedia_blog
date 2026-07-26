@php
    $appName = config('app.name') && config('app.name') !== 'Laravel' ? config('app.name') : 'TriveBuzz Media';
    $appUrl = config('app.url') && !str_contains(config('app.url'), 'localhost') ? config('app.url') : 'https://trivebuzzmedia.co.uk';
@endphp

<x-mail::message>
# {{ $subjectStr }}

{!! $content !!}

<x-mail::button :url="$appUrl" color="primary">
Explore Latest Stories on {{ $appName }}
</x-mail::button>

Warm regards,<br>
**The {{ $appName }} Editorial Team**

<x-mail::subcopy>
You are receiving this official update because you are subscribed to **{{ $appName }}** ([{{ $appUrl }}]({{ $appUrl }})).
@if(!empty($unsubscribeToken))
If you no longer wish to receive these email updates, you can [unsubscribe from newsletter]({{ route('newsletter.unsubscribe', ['token' => $unsubscribeToken]) }}) at any time.
@endif
</x-mail::subcopy>
</x-mail::message>
