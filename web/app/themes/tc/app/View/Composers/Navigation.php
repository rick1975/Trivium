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

    public function with()
    {
        return [
            'navigation' => app('navigation.primary'),
        ];
    }
}
