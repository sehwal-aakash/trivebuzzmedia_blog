@props(['url'])
@php
    $appName = config('app.name') && config('app.name') !== 'Laravel' ? config('app.name') : 'TriveBuzz Media';
    $appUrl = config('app.url') && !str_contains(config('app.url'), 'localhost') ? config('app.url') : 'https://trivebuzzmedia.co.uk';
    $targetUrl = $url && !str_contains($url, 'localhost') ? $url : $appUrl;
@endphp
<tr>
<td class="header" style="padding: 32px 0 20px 0; text-align: center;">
<a href="{{ $targetUrl }}" style="display: inline-block; text-decoration: none;">
    <img src="{{ asset('trivebuzzmedia-logo.png') }}" class="logo" alt="{{ $appName }}" style="height: 44px; width: auto; max-height: 48px; object-fit: contain; vertical-align: middle;">
</a>
</td>
</tr>
