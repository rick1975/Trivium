<?php

namespace App\Providers;

use Log1x\Navi\Navi;
use Roots\Acorn\Sage\SageServiceProvider;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        /**
         * Het hoofdmenu wordt door header, footer en sitemap gebruikt;
         * als singleton bouwt Navi het maar één keer per request op.
         */
        $this->app->singleton('navigation.primary', function () {
            if (! has_nav_menu('primary_navigation')) {
                return [];
            }

            return (new Navi)
                ->build('primary_navigation')
                ->toArray();
        });

        /**
         * Contactgegevens uit Trivium Settings, gedeeld door footer en zoekpaneel.
         */
        $this->app->singleton('trivium.contact', function () {
            $telefoon = function_exists('get_field') ? (string) get_field('telefoonnummer', 'option') : '';

            return (object) [
                'adres' => function_exists('get_field') ? (string) get_field('adres', 'option') : '',
                'email' => function_exists('get_field') ? (string) get_field('email', 'option') : '',
                'telefoon' => $telefoon,
                'telefoonLink' => preg_replace('/[^0-9+]/', '', $telefoon),
            ];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
