@component('mail::message')

Thank You For Your Message

<h1>Name</h1>{{ $data['name'] }}

<h1>Message</h1>{{ $data['message'] }}

@endcomponent
