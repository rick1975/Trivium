<?php

/**
 * ACF-optiepagina "Trivium Settings" met een subpagina per onderdeel, en de bijbehorende velden.
 *
 * Alle subpagina's bewaren in dezelfde 'option'-opslag, dus uitlezen gaat overal met
 * get_field('<naam>', 'option'). De veldsleutels zijn gelijk gebleven sinds de opsplitsing,
 * zodat bestaande inhoud behouden blijft.
 */

namespace App;

/**
 * Subpagina's onder "Trivium Settings": slug => titel.
 */
const OPTION_PAGES = [
    'trivium-contact' => 'Contactgegevens',
    'trivium-leren-met-lef' => 'Leren met lef',
    'trivium-snelle-links' => 'Snelle links',
    'trivium-fotobanner' => 'Fotobanner',
    'trivium-footer' => 'Footer',
];

/**
 * Registreer de optiepagina en de subpagina's.
 *
 * @return void
 */
add_action('acf/init', function () {
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'Trivium Settings',
        'menu_title' => 'Trivium Settings',
        'menu_slug' => 'trivium-settings',
        'capability' => 'edit_theme_options',
        'redirect' => true,
        'icon_url' => 'dashicons-admin-generic',
        'position' => 80,
    ]);

    foreach (OPTION_PAGES as $slug => $title) {
        acf_add_options_sub_page([
            'page_title' => $title,
            'menu_title' => $title,
            'menu_slug' => $slug,
            'parent_slug' => 'trivium-settings',
            'capability' => 'edit_theme_options',
        ]);
    }
});

/**
 * Registreer de velden per subpagina.
 *
 * @return void
 */
add_action('acf/init', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    $location = fn (string $slug) => [[['param' => 'options_page', 'operator' => '==', 'value' => $slug]]];

    $pageLink = fn (string $key, string $label = 'Pagina') => [
        'key' => $key,
        'label' => $label,
        'name' => 'pagina',
        'type' => 'page_link',
        'post_type' => ['page'],
        'allow_archives' => 0,
        'required' => 1,
    ];

    acf_add_local_field_group([
        'key' => 'group_trivium_contact',
        'title' => 'Contactgegevens',
        'fields' => [
            [
                'key' => 'field_trivium_adres',
                'label' => 'Adres',
                'name' => 'adres',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'key' => 'field_trivium_email',
                'label' => 'E-mailadres',
                'name' => 'email',
                'type' => 'email',
            ],
            [
                'key' => 'field_trivium_telefoonnummer',
                'label' => 'Telefoonnummer',
                'name' => 'telefoonnummer',
                'type' => 'text',
            ],
            [
                'key' => 'field_trivium_telefoon_bereikbaar',
                'label' => 'Telefonisch bereikbaar',
                'name' => 'telefoon_bereikbaar',
                'type' => 'text',
                'instructions' => 'Komt onder het telefoonnummer in de footer, bijvoorbeeld "bereikbaar van 08.00 - 16.30u".',
            ],
        ],
        'location' => $location('trivium-contact'),
    ]);

    acf_add_local_field_group([
        'key' => 'group_trivium_leren_met_lef',
        'title' => 'Leren met lef',
        'fields' => [
            [
                'key' => 'field_trivium_leren_met_lef',
                'label' => 'Kaarten',
                'name' => 'leren_met_lef',
                'type' => 'repeater',
                'instructions' => 'Maximaal 6 kaarten.',
                'min' => 0,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Kaart toevoegen',
                'sub_fields' => [
                    [
                        'key' => 'field_trivium_leren_met_lef_titel',
                        'label' => 'Titel',
                        'name' => 'titel',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_trivium_leren_met_lef_content',
                        'label' => 'Content',
                        'name' => 'content',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                ],
            ],
        ],
        'location' => $location('trivium-leren-met-lef'),
    ]);

    acf_add_local_field_group([
        'key' => 'group_trivium_snelle_links',
        'title' => 'Snelle links',
        'fields' => [
            [
                'key' => 'field_trivium_snelle_links_titel',
                'label' => 'Titel',
                'name' => 'snelle_links_titel',
                'type' => 'text',
                'wrapper' => ['width' => 50],
            ],
            [
                'key' => 'field_trivium_snelle_links_highlight',
                'label' => 'Roze tweede regel',
                'name' => 'snelle_links_highlight',
                'type' => 'text',
                'wrapper' => ['width' => 50],
            ],
            [
                'key' => 'field_trivium_snelle_links_blokken',
                'label' => 'Gekleurde blokken',
                'name' => 'snelle_links_blokken',
                'type' => 'repeater',
                'instructions' => 'Opvallende blokken naast de titel, bijvoorbeeld voor groep 8 of de open dag. Maximaal 2.',
                'max' => 2,
                'layout' => 'block',
                'button_label' => 'Blok toevoegen',
                'sub_fields' => [
                    [
                        'key' => 'field_trivium_snelle_links_blok_titel',
                        'label' => 'Titel',
                        'name' => 'titel',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'key' => 'field_trivium_snelle_links_blok_tekst',
                        'label' => 'Linktekst',
                        'name' => 'tekst',
                        'type' => 'text',
                        'wrapper' => ['width' => 50],
                    ],
                    $pageLink('field_trivium_snelle_links_blok_pagina'),
                    [
                        'key' => 'field_trivium_snelle_links_blok_kleur',
                        'label' => 'Kleur',
                        'name' => 'kleur',
                        'type' => 'select',
                        'choices' => [
                            'yellow' => 'Geel',
                            'lightblue' => 'Lichtblauw',
                            'pink' => 'Roze',
                            'green' => 'Groen',
                            'blue' => 'Blauw',
                        ],
                        'default_value' => 'yellow',
                    ],
                ],
            ],
            [
                'key' => 'field_trivium_snelle_links_links',
                'label' => 'Links',
                'name' => 'snelle_links_links',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Link toevoegen',
                'sub_fields' => [
                    [
                        'key' => 'field_trivium_snelle_links_link_titel',
                        'label' => 'Titel',
                        'name' => 'titel',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_trivium_snelle_links_link_tekst',
                        'label' => 'Omschrijving',
                        'name' => 'tekst',
                        'type' => 'text',
                    ],
                    $pageLink('field_trivium_snelle_links_link_pagina'),
                ],
            ],
        ],
        'location' => $location('trivium-snelle-links'),
    ]);

    // Twee fotobanners onder elkaar op de voorpagina, elk in een eigen tabblad. De onderste houdt de
    // oorspronkelijke veldnamen (fotobanner_*), de bovenste krijgt fotobanner_boven_*.
    $bannerFields = fn (string $prefix, string $defaultNote) => [
        [
            'key' => "field_trivium_{$prefix}_afbeelding",
            'label' => 'Foto',
            'name' => "{$prefix}_afbeelding",
            'type' => 'image',
            'instructions' => "Liggende foto, minimaal 2000px breed. De tekst staat links, dus houd het onderwerp rechts. Leeg = {$defaultNote}.",
            'return_format' => 'id',
            'preview_size' => 'medium',
        ],
        [
            'key' => "field_trivium_{$prefix}_titel",
            'label' => 'Titel',
            'name' => "{$prefix}_titel",
            'type' => 'text',
            'wrapper' => ['width' => 50],
        ],
        [
            'key' => "field_trivium_{$prefix}_highlight",
            'label' => 'Roze tweede regel',
            'name' => "{$prefix}_highlight",
            'type' => 'text',
            'wrapper' => ['width' => 50],
        ],
        [
            'key' => "field_trivium_{$prefix}_tekst",
            'label' => 'Tekst',
            'name' => "{$prefix}_tekst",
            'type' => 'textarea',
            'rows' => 3,
        ],
        [
            'key' => "field_trivium_{$prefix}_link",
            'label' => 'Knop',
            'name' => "{$prefix}_link",
            'type' => 'link',
            'instructions' => 'Leeg = geen knop.',
            'return_format' => 'array',
        ],
    ];

    acf_add_local_field_group([
        'key' => 'group_trivium_fotobanner',
        'title' => 'Fotobanner',
        'fields' => [
            [
                'key' => 'field_trivium_fotobanner_message',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'message' => 'Twee schermvullende foto\'s met titel, tekst en knop onderaan de voorpagina, direct na elkaar. Zonder titel wordt een banner niet getoond.',
            ],
            [
                'key' => 'field_trivium_fotobanner_tab_boven',
                'label' => 'Bovenste banner',
                'type' => 'tab',
            ],
            ...$bannerFields('fotobanner_boven', 'tijdelijke foto'),
            [
                'key' => 'field_trivium_fotobanner_tab_onder',
                'label' => 'Onderste banner',
                'type' => 'tab',
            ],
            ...$bannerFields('fotobanner', 'standaardfoto'),
        ],
        'location' => $location('trivium-fotobanner'),
    ]);

    acf_add_local_field_group([
        'key' => 'group_trivium_footer',
        'title' => 'Footer',
        'fields' => [
            [
                'key' => 'field_trivium_footer_titel',
                'label' => 'Titel',
                'name' => 'footer_titel',
                'type' => 'text',
                'instructions' => 'Leeg = naam van de website.',
            ],
            [
                'key' => 'field_trivium_footer_tekst',
                'label' => 'Tekst',
                'name' => 'footer_tekst',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => 'Korte introductie boven de contactgegevens. Adres, telefoon en e-mail komen uit Contactgegevens.',
            ],
            [
                'key' => 'field_trivium_footer_afbeelding',
                'label' => 'Foto',
                'name' => 'footer_afbeelding',
                'type' => 'image',
                'instructions' => 'Staat vanaf tablet op de rechterhelft, op mobiel onder de tekst. Leeg = standaardfoto.',
                'return_format' => 'id',
                'preview_size' => 'medium',
            ],
            [
                'key' => 'field_trivium_footer_sitemap_label',
                'label' => 'Label bij sitemap-lijn',
                'name' => 'footer_sitemap_label',
                'type' => 'text',
                'default_value' => 'Gratis lunch en fruit, elke dag',
                'instructions' => 'Korte zin met fruiticoontjes aan het eind van de lijn boven de sitemap (vanaf tablet). Leeg = geen label.',
            ],
        ],
        'location' => $location('trivium-footer'),
    ]);
});
