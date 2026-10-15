<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_action('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (! Vite::isRunningHot()) {
        $dependencies = json_decode(Vite::content('editor.deps.json')) ?: [];

        foreach ($dependencies as $dependency) {
            if (! wp_script_is($dependency)) {
                wp_enqueue_script($dependency);
            }
        }
    }
    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Alleen de eigen kleuren (triv-*, wit, zwart) in het kleurenpalet. De gegenereerde theme.json bevat alle ±300
 * Tailwind-kleuren; WordPress zet daar op elke pagina ±110 kB aan CSS-variabelen en .has-…-classes voor in de HTML.
 * De Tailwind-classes in het thema zelf (text-gray-800 enz.) staan in app.css en hebben dit palet niet nodig.
 *
 * @return \WP_Theme_JSON_Data
 */
add_filter('wp_theme_json_data_theme', function ($themeJson) {
    $data = $themeJson->get_data();
    $palette = $data['settings']['color']['palette']['theme'] ?? $data['settings']['color']['palette'] ?? null;

    if (! is_array($palette)) {
        return $themeJson;
    }

    $palette = array_values(array_filter($palette, fn ($color) => in_array($color['slug'], ['white', 'black'], true)
        || str_starts_with($color['slug'], 'triv-')));

    return $themeJson->update_with([
        'version' => $data['version'],
        'settings' => ['color' => ['palette' => $palette]],
    ]);
});

/**
 * Disable on-demand block asset loading.
 *
 * @link https://core.trac.wordpress.org/ticket/61965
 */
add_filter('should_load_separate_core_block_assets', '__return_false');

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Eigen blokstijlen voor de pagina-inhoud (opmaak in css/app.css, de PM-trap wordt klikbaar via js/steps.js).
 * In de editor te kiezen onder Blok > Stijlen.
 *
 * @return void
 */
add_action('init', function () {
    $styles = [
        'core/list' => [
            'kenmerken' => 'Kenmerken (labels)',
            'trap' => 'Stappen (trap)',
        ],
        'core/columns' => [
            'kaarten' => 'Kaarten',
        ],
        'core/group' => [
            'sectie' => 'Gekleurd vlak (schermbreed)',
            'uitgelicht' => 'Uitgelicht',
            'afsluiter' => 'Afsluiter met knop',
        ],
    ];

    foreach ($styles as $block => $variants) {
        foreach ($variants as $name => $label) {
            register_block_style($block, ['name' => $name, 'label' => $label]);
        }
    }
});

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});

/**
 * Custom Login Page Styling
 */
add_action('login_enqueue_scripts', function () {
    try {
        wp_enqueue_style('tc-login', Vite::asset('resources/css/login.css'), [], null);
    } catch (\Throwable $e) {
        // Geen build aanwezig: standaard WordPress-login tonen.
    }
});

/**
 * Custom Login Logo URL
 */
add_filter('login_headerurl', function () {
    return home_url();
});

/**
 * Custom Login Logo Title
 */
add_filter('login_headertext', function () {
    return get_bloginfo('name');
});

