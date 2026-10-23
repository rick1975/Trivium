<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class QuickLinks extends Composer
{
    protected static $views = [
        'components.quick-links',
    ];

    public function with()
    {
        $field = fn (string $name) => function_exists('get_field') ? get_field($name, 'option') : null;
        $blocks = $field('snelle_links_blokken') ?: [];

        return [
            'title' => (string) $field('snelle_links_titel'),
            'highlight' => (string) $field('snelle_links_highlight'),
            'ctas' => array_map(fn ($cta) => [
                'title' => $cta['titel'],
                // Pijl zit al in de kaart: een getypte "→" vooraan weglaten
                'text' => preg_replace('/^[→\s]+/u', '', (string) $cta['tekst']),
                // Een externe link (bv. aanmeldformulier) gaat voor de pagina en opent in een nieuw tabblad
                'url' => ($cta['externe_link'] ?? '') ?: ($cta['pagina'] ?: '#'),
                'extern' => ! empty($cta['externe_link']),
                // Zonder eigen foto (Trivium Settings > Snelle links) toont de kaart een navy vlak
                'image' => ! empty($cta['afbeelding']) ? wp_get_attachment_image_url($cta['afbeelding'], 'large') : null,
            ], $blocks),
            'links' => array_map(function ($link) {
                // Een bestand (bv. de schoolgids-PDF) gaat voor de pagina en opent in een nieuw tabblad
                $file = ! empty($link['bestand']) ? wp_get_attachment_url($link['bestand']) : null;
                $anchor = ltrim((string) ($link['anker'] ?? ''), '#');

                return [
                    'title' => $link['titel'],
                    'text' => $link['tekst'],
                    'url' => $file ?: (($link['pagina'] ?: '#').($anchor !== '' ? '#'.$anchor : '')),
                    'file' => (bool) $file,
                ];
            }, $field('snelle_links_links') ?: []),
        ];
    }
}
