<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageHero extends Composer
{
    protected static $views = [
        'components.page-hero',
    ];

    /**
     * Fotoheader van een gewone pagina: uitgelichte afbeelding, titel en de bovenliggende pagina (als label boven
     * de titel). Het focuspunt (ACF "Fotoheader") bepaalt de horizontale uitsnede; verticaal ligt het iets boven
     * het midden, waar gezichten meestal zitten. Stijl: 'breed' (standaard) of 'half' (vanaf desktop foto rechts).
     */
    public function with()
    {
        $id = get_queried_object_id();
        $parent = wp_get_post_parent_id($id);
        $focus = function_exists('get_field') ? get_field('foto_focus', $id) : null;

        return [
            'image' => get_post_thumbnail_id($id),
            'title' => get_the_title($id),
            'parent' => $parent ? ['title' => get_the_title($parent), 'url' => get_permalink($parent)] : null,
            'layout' => (function_exists('get_field') ? get_field('foto_stijl', $id) : null) ?: 'breed',
            'position' => match ($focus) {
                'links' => '35% 40%',
                'rechts' => '65% 40%',
                default => '50% 40%',
            },
        ];
    }
}
