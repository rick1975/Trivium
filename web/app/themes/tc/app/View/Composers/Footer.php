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
     * Titel, tekst en foto uit Trivium Settings > Footer, met de sitenaam en standaardfoto als terugval.
     */
    public function with()
    {
        $field = fn (string $name) => function_exists('get_field') ? get_field($name, 'option') : null;
        $imageId = $field('footer_afbeelding');

        return [
            'footer' => (object) [
                'title' => $field('footer_titel') ?: get_bloginfo('name', 'display'),
                'text' => (string) $field('footer_tekst'),
                'image' => ($imageId ? wp_get_attachment_image_url($imageId, 'full') : null)
                    ?: Vite::asset('resources/images/trivium-aula-trappen.avif'),
            ],
        ];
    }
}
