@php
$email = $block->input('email');
$message = $block->input('message');
@endphp

<contact-form message="{{$message}}" email="{{ $email }}">
</contact-form>
