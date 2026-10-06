<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Contact extends Composer
{
    protected static $views = [
        'sections.footer',
        'components.search-panel',
        'components.nav-drawer',
    ];

    public function with()
    {
        return [
            'contact' => app('trivium.contact'),
        ];
    }
}
