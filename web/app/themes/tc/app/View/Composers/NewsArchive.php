<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Nieuwsoverzicht (berichtenpagina /nieuws/, view home): alle berichten als kaarten in een raster (geen groot
 * bericht zoals op de voorpagina). Zolang er nog geen berichten zijn, de voorbeeldberichten van de voorpagina.
 */
class NewsArchive extends Composer
{
    protected static $views = [
        'home',
    ];

    public function with()
    {
        global $wp_query;

        $posts = $wp_query->posts;
        $items = $posts
            ? array_map([News::class, 'item'], $posts, array_keys($posts))
            : News::placeholders();

        return [
            'title' => get_the_title(get_option('page_for_posts')) ?: __('Nieuws', 'sage'),
            'intro' => trim(get_post_field('post_content', get_option('page_for_posts'))),
            'tiles' => $items,
            'pagination' => paginate_links([
                'type' => 'array',
                'prev_text' => __('Vorige', 'sage'),
                'next_text' => __('Volgende', 'sage'),
            ]) ?: [],
        ];
    }
}
