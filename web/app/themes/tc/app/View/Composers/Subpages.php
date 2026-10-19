<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Subpages extends Composer
{
    protected static $views = [
        'components.subpages',
    ];

    /**
     * Pillen naar de onderliggende pagina's op een rubriekpagina (Leerlingen & ouders, Ons onderwijs, ...): de
     * onderdelen van dat hoofdpunt in het hoofdmenu, in dezelfde volgorde, zodat het overzicht altijd gelijk loopt
     * met het menu (items met de klasse "alleen-sitemap" tellen hier wel mee, net als in de sitemap). Alleen op een
     * pagina zonder eigen tussenkoppen: een korte intro mag, een uitgewerkte pagina als Groep 8 houdt zijn eigen inhoud.
     */
    public function with()
    {
        $id = get_queried_object_id();

        return [
            'items' => $this->hasOwnContent($id) ? [] : $this->items($id),
        ];
    }

    protected function items(int $id): array
    {
        foreach (app('navigation.primary') as $item) {
            if ((int) ($item->objectId ?? 0) !== $id || $item->object !== 'page') {
                continue;
            }

            return array_values(array_map(function ($child) {
                $page = $child->object === 'page' ? (int) $child->objectId : 0;

                return [
                    'title' => html_entity_decode(wp_strip_all_tags($child->label), ENT_QUOTES),
                    'url' => $child->url,
                    'extern' => ! $page,
                ];
            }, $item->children ?: []));
        }

        return [];
    }

    protected function hasOwnContent(int $id): bool
    {
        return has_block('core/heading', $id);
    }
}
