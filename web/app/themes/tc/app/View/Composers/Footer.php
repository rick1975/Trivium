<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Vite;
use Roots\Acorn\View\Composer;

class Footer extends Composer
{
    protected static $views = [
        'sections.footer',
    ];

    /**
     * Titel, tekst en foto's uit Trivium Settings > Footer, met de sitenaam en de standaardfoto's (aula en fruitkrat) als terugval.
     * Het sitemap-label valt alleen terug op de standaardzin als het veld nog nooit is opgeslagen; leeg = geen label.
     */
    public function with()
    {
        $field = fn (string $name) => function_exists('get_field') ? get_field($name, 'option') : null;

        $slides = array_values(array_filter(array_map(
            fn ($id) => ($url = wp_get_attachment_image_url($id, 'full')) ? (object) ['image' => $url] : null,
            $field('footer_fotos') ?: []
        )));

        return [
            'footer' => (object) [
                'title' => $field('footer_titel') ?: get_bloginfo('name', 'display'),
                'text' => (string) $field('footer_tekst'),
                'slides' => $slides ?: [
                    (object) [
                        'image' => Vite::asset('resources/images/aula-zittrap-daklicht-leerlingen.avif'),
                    ],
                    (object) [
                        'image' => Vite::asset('resources/images/leerlingen-bij-de-fruitkrat.avif'),
                        'position' => '30% 50%', // krat staat links in de foto: zo blijft hij uit het verloop
                    ],
                ],
                'sitemapLabel' => (string) ($field('footer_sitemap_label') ?? 'Gratis lunch en fruit, elke dag'),
            ],
        ];
    }
}
