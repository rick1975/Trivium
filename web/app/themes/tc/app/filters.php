<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Voeg "… Lees verder" toe aan de samenvatting.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Lees verder', 'sage'));
});

/**
 * Change excerpt length to 18 words
 */
add_filter('excerpt_length', function () {
    return 18;
});

/**
 * Remove archive title prefixes (Category:, Tag:)
 */
add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    }
    return $title;
});
