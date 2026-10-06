<?php

/**
 * Theme helpers.
 */

namespace App;

/**
 * Permalink van een gepubliceerde pagina op basis van de slug.
 *
 * Alle pagina's worden één keer per request opgehaald (get_pages is gecachet),
 * zodat meerdere links op een pagina geen extra queries kosten. Bestaat de
 * pagina (nog) niet, dan komt de fallback terug.
 */
function page_url(string $slug, string $fallback = '#'): string
{
    static $pages = null;

    if ($pages === null) {
        $pages = [];

        foreach (get_pages(['post_status' => 'publish']) as $page) {
            $pages[$page->post_name] ??= $page->ID;
        }
    }

    return isset($pages[$slug]) ? get_permalink($pages[$slug]) : $fallback;
}
