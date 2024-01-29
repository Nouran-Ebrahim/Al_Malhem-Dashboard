@component('mail::message')
<p>{{ $message }}</p>

@if ($email)
<p>email {{ $email }}</p>
<p>phone {{ $phone }}</p>
Al Melham
@else
<p>phone {{ $phone }}</p>
Al Melham
@endif
@endcomponent
