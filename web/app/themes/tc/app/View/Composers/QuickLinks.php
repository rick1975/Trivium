<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Vite;
use Roots\Acorn\View\Composer;

class QuickLinks extends Composer
{
    protected static $views = [
        'components.quick-links',
    ];

    /**
     * Standaardfoto per fotoblok (Trivium Settings > Snelle links), zolang er geen eigen foto gekozen is.
     */
    protected array $fallbackImages = [
        'meisje-lacht-aan-tafel.avif', // TEST: foto bij "Zit je in groep 8?" (zie livegang-checklist in claude.md)
        'jongen-met-krullen-laptop.avif', // TEST: foto bij "Open dag 18 april" (zie livegang-checklist in claude.md)
    ];

    public function with()
    {
        $field = fn (string $name) => function_exists('get_field') ? get_field($name, 'option') : null;
        $blocks = $field('snelle_links_blokken') ?: [];

        return [
            'title' => (string) $field('snelle_links_titel'),
            'highlight' => (string) $field('snelle_links_highlight'),
            'ctas' => array_map(fn ($cta, $i) => [
                'title' => $cta['titel'],
                // Pijl zit al in de kaart: een getypte "→" vooraan weglaten
                'text' => preg_replace('/^[→\s]+/u', '', (string) $cta['tekst']),
                'url' => $cta['pagina'] ?: '#',
                'image' => (! empty($cta['afbeelding']) ? wp_get_attachment_image_url($cta['afbeelding'], 'large') : null)
                    ?: Vite::asset('resources/images/'.$this->fallbackImages[$i % count($this->fallbackImages)]),
            ], $blocks, array_keys($blocks)),
            'links' => array_map(fn ($link) => [
                'title' => $link['titel'],
                'text' => $link['tekst'],
                'url' => $link['pagina'] ?: '#',
            ], $field('snelle_links_links') ?: []),
        ];
    }
}
