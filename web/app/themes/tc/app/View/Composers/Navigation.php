<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Navigation extends Composer
{
    /**
     * Alle views die het hoofdmenu tonen.
     *
     * @var array
     */
    protected static $views = [
        'sections.header',
        'components.sitemap',
    ];

    /**
     * Menu-items met de CSS-klasse "alleen-sitemap" (Weergave > Menu's, veld CSS-klassen) staan alleen in de
     * sitemap onder de footer, niet in het menu in de header (bv. de brochure onder Groep 8).
     */
    public function with()
    {
        $navigation = app('navigation.primary');

        if ($this->view->name() !== 'components.sitemap') {
            $navigation = $this->withoutSitemapOnly($navigation);
        }

        return [
            'navigation' => $navigation,
        ];
    }

    protected function withoutSitemapOnly(array $items): array
    {
        $items = array_filter($items, fn ($item) => ! in_array('alleen-sitemap', explode(' ', (string) $item->classes), true));

        // Kopieën: de items zijn gedeeld met de sitemap (singleton navigation.primary)
        return array_values(array_map(function ($item) {
            $item = clone $item;

            if (! empty($item->children)) {
                $item->children = $this->withoutSitemapOnly($item->children);
            }

            return $item;
        }, $items));
    }
}
