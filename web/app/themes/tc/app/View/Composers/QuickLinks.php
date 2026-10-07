<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class QuickLinks extends Composer
{
    protected static $views = [
        'components.quick-links',
    ];

    /**
     * Classes per kleurkeuze van een gekleurd blok (Trivium Settings > Snelle links).
     */
    protected array $colorClasses = [
        'yellow' => ['block' => 'bg-triv-yellow', 'title' => 'text-gray-900', 'text' => 'text-gray-900'],
        'lightblue' => ['block' => 'bg-triv-lightblue', 'title' => 'text-white', 'text' => 'text-white/80'],
        'pink' => ['block' => 'bg-triv-pink', 'title' => 'text-white', 'text' => 'text-white/80'],
        'green' => ['block' => 'bg-triv-green', 'title' => 'text-white', 'text' => 'text-white/80'],
        'blue' => ['block' => 'bg-triv-blue', 'title' => 'text-white', 'text' => 'text-white/80'],
    ];

    public function with()
    {
        $field = fn (string $name) => function_exists('get_field') ? get_field($name, 'option') : null;

        return [
            'title' => (string) $field('snelle_links_titel'),
            'highlight' => (string) $field('snelle_links_highlight'),
            'ctas' => array_map(fn ($cta) => [
                'title' => $cta['titel'],
                'text' => $cta['tekst'],
                'url' => $cta['pagina'] ?: '#',
                'classes' => $this->colorClasses[$cta['kleur']] ?? $this->colorClasses['yellow'],
            ], $field('snelle_links_blokken') ?: []),
            'links' => array_map(fn ($link) => [
                'title' => $link['titel'],
                'text' => $link['tekst'],
                'url' => $link['pagina'] ?: '#',
            ], $field('snelle_links_links') ?: []),
        ];
    }
}
