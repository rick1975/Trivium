<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\page_url;

class Menu extends Composer
{
    protected static $views = [
        'components.nav-drawer',
        'components.search-panel',
        '404',
    ];

    /**
     * Uit Trivium Settings > Menu en zoeken: de twee knoppen onderin het uitklapmenu en de populaire pagina's
     * in het zoekpaneel. Een lege knop valt terug op de standaardknop. De populaire pagina's vallen alleen terug
     * op de standaardlijst zolang het veld nog nooit is opgeslagen; een lege lijst = geen populaire pagina's.
     */
    public function with()
    {
        $field = fn (string $name) => function_exists('get_field') ? get_field($name, 'option') : null;

        $button = fn (string $name, string $title, string $slug) => (object) (($link = $field($name)) && ! empty($link['url'])
            ? ['title' => $link['title'] ?: $title, 'url' => $link['url'], 'target' => $link['target'] ?: null]
            : ['title' => $title, 'url' => page_url($slug), 'target' => null]);

        // ACF geeft voor een lege én een nooit opgeslagen lijst false: het verschil zit in de optie zelf
        $popularSaved = get_option('options_populaire_paginas') !== false;

        return [
            'menuButtons' => [
                $button('menu_knop_1', 'Contact', 'contact'),
                $button('menu_knop_2', 'Open dagen', 'open-dagen'),
            ],
            'popularPages' => $popularSaved
                // Een externe link (bv. Magister) gaat voor de pagina en opent in een nieuw tabblad
                ? array_map(fn ($row) => (object) [
                    'title' => $row['titel'],
                    'url' => ($row['externe_link'] ?? '') ?: ($row['pagina'] ?: '#'),
                    'extern' => ! empty($row['externe_link']),
                ], $field('populaire_paginas') ?: [])
                : static::defaultPopularPages(),
        ];
    }

    /**
     * Standaardlijst; bestaat een pagina (nog) niet, dan zoekt de link op de titel.
     */
    protected static function defaultPopularPages(): array
    {
        $pages = [
            ['Aanmelden', 'aanmelden'],
            ['Open dag', 'open-dagen'],
            ['Rooster', 'lestijden-roostervrije-dagen'],
            ['Contact', 'contact'],
            ['Vakanties', 'lestijden-roostervrije-dagen'],
        ];

        return array_map(fn ($page) => (object) [
            'title' => $page[0],
            'url' => page_url($page[1], home_url('/?s=' . rawurlencode($page[0]))),
        ], $pages);
    }
}
