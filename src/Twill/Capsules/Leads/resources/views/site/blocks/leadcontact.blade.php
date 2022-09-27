@php
$locale = LaravelLocalization::getCurrentLocale();
$message = $block->translatedInput('success_message');
$email = $block->input('email');
@endphp

<contact-form locale="{{ $locale }}" message="{{ $message }}" admin_email="{{ $email }}">
</contact-form>
