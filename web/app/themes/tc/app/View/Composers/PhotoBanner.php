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
            'photoBanners' => array_values(array_filter([
                // Bovenste banner: valt terug op de Level UP-tekst zolang de velden nog nooit zijn opgeslagen
                $this->photoBanner('fotobanner_boven', 'twee-meisjes-aan-het-bouwen.avif', [
                    'uitlijning' => 'rechts',
                    'accent' => 'geel',
                    'titel' => 'Ontdek waar jij',
                    'highlight' => 'goed in bent',
                    'tekst' => 'Vier dagen per week kies je zelf wat je na de lessen gaat doen. Bij Level UP kun je boksen, breakdancen, koken, muziek maken, streetart maken of zelfs je eigen bedrijfje starten. Zo ontdek je wat je leuk vindt en waar je talent ligt.',
                ]),
                $this->photoBanner('fotobanner', 'Jongen-achter-microfoon.avif'),
            ])),
        ];
    }

    /**
     * Fotobanner uit Trivium Settings > Fotobanner (veldnamen {$prefix}_*); null (= niet tonen) zonder titel.
     * $defaults geldt alleen voor velden die nog nooit zijn opgeslagen (null); een leeg opgeslagen titel verbergt de banner.
     */
    protected function photoBanner(string $prefix, string $fallbackImage, array $defaults = []): ?array
    {
        if (! function_exists('get_field')) {
            return null;
        }

        $field = fn (string $name) => get_field("{$prefix}_{$name}", 'option') ?? ($defaults[$name] ?? null);

        if (! ($title = $field('titel'))) {
            return null;
        }

        $link = $field('link') ?: [];
        $imageId = $field('afbeelding');

        return [
            'image' => ($imageId ? wp_get_attachment_image_url($imageId, 'full') : null)
                ?: Vite::asset("resources/images/{$fallbackImage}"),
            'title' => $title,
            'highlight' => $field('highlight') ?: null,
            'align' => $field('uitlijning') === 'rechts' ? 'right' : 'left',
            'accent' => $field('accent') ?: 'roze',
            'text' => (string) $field('tekst'),
            'href' => $link['url'] ?? null,
            'linkText' => ($link['title'] ?? '') ?: 'Lees meer',
            'target' => $link['target'] ?? '',
        ];
    }
}
