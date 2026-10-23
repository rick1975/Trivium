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

/**
 * Pagina met fotoheader in de stijl "half" (components/page-hero.blade.php): body-class has-hero-half, zodat de
 * kenmerken-labels vanaf desktop niet ook nog in de inhoud staan (ze staan dan in de header, zie css/app.css).
 * Stijl "achter de inhoud" (components/page-backdrop.blade.php): body-class has-hero-achtergrond, voor het witte vlak.
 * Zonder uitgelichte afbeelding (gewone paginakop): body-class has-paginakop, voor de crème header.
 */
add_filter('body_class', function ($classes) {
    $style = is_page() && has_post_thumbnail() && function_exists('get_field') ? get_field('foto_stijl') : null;

    if ($style === 'half' || $style === 'half-links') {
        $classes[] = 'has-hero-half';
    }

    if ($style === 'half-links') {
        $classes[] = 'has-hero-links';
    }

    if ($style === 'achtergrond') {
        $classes[] = 'has-hero-achtergrond';
    }

    if ($style === 'kader') {
        $classes[] = 'has-hero-kader';
    }

    // Ook het nieuwsoverzicht (berichtenpagina): crème header die doorloopt in het crème vlak eronder
    if ((is_page() && ! is_front_page() && ! has_post_thumbnail()) || is_home()) {
        $classes[] = 'has-paginakop';
    }

    // Hoofdrubriek (bovenste voorouder, of de pagina zelf): rubriek-{slug}, voor de rubriekskleur (zie css/app.css)
    if (is_page() && ! is_front_page()) {
        $ancestors = get_post_ancestors(get_queried_object_id());
        $top = $ancestors ? end($ancestors) : get_queried_object_id();
        $classes[] = 'rubriek-' . get_post_field('post_name', $top);
        $classes[] = 'pagina-' . get_post_field('post_name', get_queried_object_id()); // voor een afwijkende kleur per pagina
    }

    return $classes;
});

/**
 * Gebruikersnamen niet publiek: de REST-route /wp/v2/users en de auteurspagina's (/?author=1, /author/…) verraden
 * anders de inlognaam van de beheerder. Ingelogd blijft alles werken (de blokeditor gebruikt de users-route).
 */
add_filter('rest_endpoints', function ($endpoints) {
    if (! is_user_logged_in()) {
        unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }

    return $endpoints;
});

add_action('template_redirect', function () {
    if ((is_author() || isset($_GET['author'])) && ! is_user_logged_in()) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}, 1); // vóór redirect_canonical (prio 10), die /?author=1 anders eerst naar /author/<inlognaam>/ stuurt

/**
 * Het categorie-archief Nieuws (/category/nieuws/) valt samen met het nieuwsoverzicht op de berichtenpagina (/nieuws/):
 * daarheen doorsturen, zodat er één adres is (en "category" niet in de url staat).
 */
add_action('template_redirect', function () {
    if (is_category('nieuws') && ($page = get_option('page_for_posts'))) {
        wp_safe_redirect(get_permalink($page), 301);
        exit;
    }
});

/**
 * TranslatePress herkent uploads alleen aan "wp-content/uploads"; in Bedrock staan ze in /app/uploads/. Zonder dit
 * krijgen links naar PDF's e.d. op vertaalde pagina's een taal ervoor (/en/app/uploads/…pdf/) en geven ze een 404.
 */
add_filter('trp_url_is_file', function ($isFile, $url) {
    return $isFile || str_starts_with((string) $url, wp_get_upload_dir()['baseurl'].'/');
}, 10, 2);
