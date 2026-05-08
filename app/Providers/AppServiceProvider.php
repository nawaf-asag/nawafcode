<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share localized display name with all views
        View::composer('*', function ($view) {
            $locale   = app()->getLocale();
            $settings = $view->getData()['settings'] ?? [];
            $hero     = is_array($settings) ? ($settings['hero_name'] ?? null) : ($settings['hero_name'] ?? null);

            $displayName = $locale === 'en'
                ? __('site.brand_name')
                : ($hero ?: __('site.brand_name'));

            $view->with('displayName', $displayName);
        });
    }
}
