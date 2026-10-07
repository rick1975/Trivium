<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class LerenMetLef extends Composer
{
    protected static $views = [
        'components.leren-met-lef',
    ];

    public function with()
    {
        return [
            'onderwerpen' => function_exists('get_field') ? (get_field('leren_met_lef', 'option') ?: []) : [],
        ];
    }
}
