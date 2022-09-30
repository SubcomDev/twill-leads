@php
$locale = LaravelLocalization::getCurrentLocale();
$label = $block->translatedInput('labelButton');
$message = $block->translatedInput('success_message');
$email = $block->input('email');
$privacy = $block->translatedInput('privacy_description');
@endphp

<contact-form locale="{{ $locale }}" message="{{ $message }}" admin_email="{{ $email }}"
    label="{{ $label }}" privacy="{!! $block->translatedInput('privacy_description') !!}">
</contact-form>
