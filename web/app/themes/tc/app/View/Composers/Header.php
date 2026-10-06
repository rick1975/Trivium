<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Header extends Composer
{
    protected static $views = [
        'sections.header',
    ];

    public function with()
    {
        return [
            'isFront' => is_front_page(),
        ];
    }
}
