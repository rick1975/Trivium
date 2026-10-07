<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Vite;
use Roots\Acorn\View\Composer;

class PhotoBanner extends Composer
{
    protected static $views = [
        'front-page',
    ];

    public function with()
    {
        return [
            'photoBanner' => $this->photoBanner(),
        ];
    }

    /**
     * Fotobanner uit Trivium Settings > Fotobanner; null (= niet tonen) zonder titel.
     */
    protected function photoBanner(): ?array
    {
        if (! function_exists('get_field') || ! ($title = get_field('fotobanner_titel', 'option'))) {
            return null;
        }

        $link = get_field('fotobanner_link', 'option') ?: [];
        $imageId = get_field('fotobanner_afbeelding', 'option');

        return [
            'image' => ($imageId ? wp_get_attachment_image_url($imageId, 'full') : null)
                ?: Vite::asset('resources/images/Jongen-achter-microfoon.avif'),
            'title' => $title,
            'highlight' => get_field('fotobanner_highlight', 'option') ?: null,
            'text' => (string) get_field('fotobanner_tekst', 'option'),
            'href' => $link['url'] ?? null,
            'linkText' => ($link['title'] ?? '') ?: 'Lees meer',
            'target' => $link['target'] ?? '',
        ];
    }
}
