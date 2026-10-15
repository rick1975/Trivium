<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Nieuwsoverzicht (berichtenpagina /nieuws/, view home): op de eerste pagina het nieuwste bericht groot met de drie
 * volgende in een lijst ernaast (zoals op de voorpagina), de rest als kaarten in een raster. Zolang er nog geen
 * berichten zijn, de voorbeeldberichten van de voorpagina.
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
        $first = ! is_paged();

        return [
            'title' => get_the_title(get_option('page_for_posts')) ?: __('Nieuws', 'sage'),
            'intro' => trim(get_post_field('post_content', get_option('page_for_posts'))),
            'featured' => $first ? array_slice($items, 0, 4) : [],
            'tiles' => $first ? array_slice($items, 4) : $items,
            'pagination' => paginate_links([
                'type' => 'array',
                'prev_text' => __('Vorige', 'sage'),
                'next_text' => __('Volgende', 'sage'),
            ]) ?: [],
        ];
    }
}
