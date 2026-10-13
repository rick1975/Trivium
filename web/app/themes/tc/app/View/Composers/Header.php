<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Header extends Composer
{
    protected static $views = [
        'sections.header',
    ];

    /**
     * overPhoto: de header ligt transparant over een foto, met wit logo en witte iconen. Op de voorpagina (hero) en op
     * pagina's met fotoheaderstijl "achter de inhoud" (components/page-backdrop).
     */
    public function with()
    {
        $backdrop = is_page() && has_post_thumbnail() && function_exists('get_field') && get_field('foto_stijl') === 'achtergrond';

        return [
            'isFront' => is_front_page(),
            'overPhoto' => is_front_page() || $backdrop,
        ];
    }
}
