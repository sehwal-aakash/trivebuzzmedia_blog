@php
    $appName = config('app.name') && config('app.name') !== 'Laravel' ? config('app.name') : 'TriveBuzz Media';
    $appUrl = config('app.url') && !str_contains(config('app.url'), 'localhost') ? config('app.url') : 'https://trivebuzzmedia.co.uk';
@endphp

<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="$appUrl">
{{ $appName }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ $appName }}. {{ __('All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
