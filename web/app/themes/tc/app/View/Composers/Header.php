<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Navi;

class Header extends Composer
{
    protected static $views = [
        'sections.header',
    ];

    public function with()
    {
        return [
            'navigation' => $this->navigation(),
        ];
    }

    public function navigation()
    {
        if (!has_nav_menu('primary_navigation')) {
            return [];
        }

        return (new Navi())
            ->build('primary_navigation')
            ->toArray();
    }
}
