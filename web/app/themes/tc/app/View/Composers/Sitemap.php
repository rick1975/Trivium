<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Sitemap extends Composer
{
    protected static $views = [
        'components.sitemap',
    ];

    public function with()
    {
        return [
            'navigation' => app('navigation.primary'),
        ];
    }
}
