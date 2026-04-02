<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Log1x\Navi\Navi;

class Footer extends Composer
{
    protected static $views = [
        'sections.footer',
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
