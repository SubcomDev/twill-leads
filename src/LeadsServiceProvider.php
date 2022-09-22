<?php

namespace Leads;

use A17\Twill\TwillPackageServiceProvider;

class LeadsServiceProvider extends TwillPackageServiceProvider
{
    /*
    *
    */
    public function boot(): void {
        $this->loadRoutesFrom(__DIR__. '/Twill/Capsules/Leads/routes/web.php');
        parent::boot();
    }


    /*
    *
    */
    public function register(){

        $this->publishes([
            __DIR__ . '/Twill/Capsules/Leads/resources/views/admin/leads/leads.blade.php' => base_path('resources/views/admin/leads/leads.blade.php'),
            __DIR__ . '/Twill/Capsules/Leads/resources/js/components/NewsletterForm.vue' => base_path('resources/js/components/NewsletterForm.vue'),
            __DIR__ . '/Twill/Capsules/Leads/resources/views/admin/blocks' => base_path('resources/views/admin/blocks'),
            __DIR__ . '/Twill/Capsules/Leads/resources/views/site/blocks' => base_path('resources/views/site/blocks'),
        ],'twill-leads-views');

        $this->publishes([
            __DIR__ . '/Twill/Capsules/leads/resources/views/site/' => base_path('resources/views/site'),
        ],'twill-leads-views-site');

        $this->publishes([
            __DIR__ . '/Twill/Capsules/leads/lang/en/success.php' => base_path('lang/en/success.php'),
            __DIR__ . '/Twill/Capsules/leads/lang/it/success.php' => base_path('lang/it/success.php'),
        ],'twill-success-lang');

        $this->publishes([
            __DIR__ . '/Twill/Capsules/leads/resources/lang/en/success.php' => base_path('resources/lang/en/success.php'),
            __DIR__ . '/Twill/Capsules/leads/resources/lang/it/success.php' => base_path('resources/lang/it/success.php'),
        ],'twill-resources-success-lang');

        $this->publishes([
            __DIR__ . '/Twill/Capsules/Leads/Exports/LeadExport.php' => app_path('/Exports/LeadExport.php'),

        ] ,'twill-lead-export');

        $this->publishes([
            __DIR__ . '/Twill/Capsules/Leads/Http/Controllers/Admin/LeadController.php' => base_path('app/Http/Controllers/Admin/LeadController.php'),
            __DIR__ . '/Twill/Capsules/Leads/Http/Controllers/Api/LeadController.php' => base_path('app/Http/Controllers/Api/LeadController.php'),

            __DIR__ . '/Twill/Capsules/Leads/Repositories/LeadRepository.php' => base_path('app/Repositories/LeadRepository.php'),

        ] ,'twill-lead-controller');

        $this->publishes([
            __DIR__. '/Twill/Capsules/Leads/Models' => base_path('app/Models'),
        ],'twill-leads-models' );

        $this->publishes([
            __DIR__. '/Twill/Capsules/Leads/database/migrations' => database_path('/migrations'),
        ],'twill-leads-database' );

        $this->publishes([
            __DIR__. '/Twill/Capsules/Leads/public/assets/admin/leads' => public_path('/assets/admin/leads'),
        ],'twill-leads-public-assets-admin-leads' );
    }
}