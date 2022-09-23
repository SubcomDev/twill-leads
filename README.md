This a package build with laravel and twill to add menu modul.

## Support us


## Installation

### Project setup
# twill-leads

To install twill-leads package and all dependecies run the command below and follow the instructions:

```php
composer require subcom/twill-leads
```


### Config setup

1. Run command:
```bash
php artisan vendor:publish --provider="Leads\LeadsServiceProvider" --tag="twill-leads-views"
php artisan vendor:publish --provider="Leads\LeadsServiceProvider" --tag="twill-leads-views-site"
php artisan vendor:publish --provider="Leads\LeadsServiceProvider" --tag="twill-success-lang"
php artisan vendor:publish --provider="Leads\LeadsServiceProvider" --tag="twill-resources-success-lang"
php artisan vendor:publish --provider="Leads\LeadsServiceProvider" --tag="twill-leads-public-assets-admin-leads"
php artisan vendor:publish --provider="Leads\LeadsServiceProvider" --tag="twill-leads-database"
```

2. Run command:
```bash
php artisan migrate
```

3. Add this to resources/js/app.js
```php
app.component('NewsletterForm', defineAsyncComponent(() =>
    import('./components/NewsletterForm.vue')
));

// app.component('ContactForm', defineAsyncComponent(() =>
//     import('./components/ContactForm.vue')
// ));
```

4. Add this to config/twill.php in blocks
5. ```php
    'leads' => [

        'title' => 'Leads',
        'icon' => 'quote',
        'component' => 'a17-block-leads',
        'path' => base_path('vendor/subcom/twill-leads/src/Twill/Capsules/Leads/resources/views/admin/blocks'),
        'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
    ],

    'contactform' => [

    'title' => 'ContactForm',
    'icon' => 'quote',
    'component' => 'a17-block-contactform',
    'path' => base_path('vendor/subcom/twill-leads/src/Twill/Capsules/Leads/resources/views/admin/blocks'),
    'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
    ],
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://subcom.it) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [subcom](https://github.com/SubcomDev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
