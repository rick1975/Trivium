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

/**
 * Reacties en pingbacks volledig uitschakelen: geen ondersteuning per berichttype,
 * altijd gesloten, geen menu/widget/adminbalk-item en geen reactie-API.
 */
add_action('init', function () {
    foreach (get_post_types() as $postType) {
        if (post_type_supports($postType, 'comments')) {
            remove_post_type_support($postType, 'comments');
            remove_post_type_support($postType, 'trackbacks');
        }
    }
}, 100);

add_filter('comments_open', '__return_false', 20);
add_filter('pings_open', '__return_false', 20);
add_filter('comments_array', '__return_empty_array', 10);

add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
});

add_action('admin_init', function () {
    global $pagenow;

    if (in_array($pagenow, ['edit-comments.php', 'options-discussion.php'], true)) {
        wp_safe_redirect(admin_url());
        exit;
    }

    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
});

add_action('admin_bar_menu', function ($adminBar) {
    $adminBar->remove_node('comments');
}, 100);

add_filter('rest_endpoints', function ($endpoints) {
    unset($endpoints['/wp/v2/comments'], $endpoints['/wp/v2/comments/(?P<id>[\d]+)']);

    return $endpoints;
});

add_filter('xmlrpc_methods', function ($methods) {
    unset($methods['pingback.ping'], $methods['pingback.extensions.getPingbacks']);

    return $methods;
});

add_filter('wp_headers', function ($headers) {
    unset($headers['X-Pingback']);

    return $headers;
});
