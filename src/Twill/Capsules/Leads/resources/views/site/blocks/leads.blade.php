@php
$locale = LaravelLocalization::getCurrentLocale();
$title = $block->translatedInput('title');
$description = $block->translatedInput('description');
$privacy = $block->translatedInput('privacy_description');
@endphp

<newsletter-form locale="{{ $locale }}" title="{{ $title }}" description="{{ $description }}"
    privacy="{{ $privacy }}">
</newsletter-form>
