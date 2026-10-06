<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Footer extends Composer
{
    protected static $views = [
        'sections.footer',
    ];

    public function with()
    {
        return [
            'navigation' => app('navigation.primary'),
        ];
    }
}
