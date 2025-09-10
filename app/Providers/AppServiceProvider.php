<?php

namespace App\Providers;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure language switch
        $languageSwitch = LanguageSwitch::make()
            ->locales(['en', 'cs'])
            ->labels([
                'en' => 'English',
                'cs' => 'Čeština',
            ])
            ->flags([
                'en' => 'https://flagcdn.com/w20/gb.png',
                'cs' => 'https://flagcdn.com/w20/cz.png',
            ])
            ->displayLocale('en')
            ->visible(insidePanels: true, outsidePanels: false)
            ->renderHook('panels::global-search.after');

        // Store the configured instance in the container
        $this->app->instance(LanguageSwitch::class, $languageSwitch);
    }
}
