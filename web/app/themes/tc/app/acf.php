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
    'trivium-menu' => 'Menu en zoeken',
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
                'instructions' => 'Maximaal 6 onderwerpen. Op de voorpagina als tabbladen (desktop) of uitklaplijst (mobiel).',
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
                        'key' => 'field_trivium_leren_met_lef_intro',
                        'label' => 'Korte intro',
                        'name' => 'intro',
                        'type' => 'textarea',
                        'rows' => 2,
                        'instructions' => 'Eén zin die altijd zichtbaar is bij de titel, ook als de rest ingeklapt is.',
                    ],
                    [
                        'key' => 'field_trivium_leren_met_lef_foto',
                        'label' => 'Foto',
                        'name' => 'foto',
                        'type' => 'image',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'instructions' => 'Optioneel. Vanaf desktop rechts naast de inhoud (staand beeld werkt het best), op mobiel erboven.',
                    ],
                    [
                        'key' => 'field_trivium_leren_met_lef_content',
                        'label' => 'Content',
                        'name' => 'content',
                        'type' => 'textarea',
                        'rows' => 6,
                        'instructions' => 'Begin een regel met • of - voor een opsommingspunt (vetgedrukt); de regel(s) eronder vormen de toelichting. Een korte kop zonder leesteken aan het eind, direct gevolgd door tekst, wordt vetgedrukt. Scheid alinea\'s met een witregel.',
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
                'label' => 'Fotoblokken',
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
                    ['required' => 0, 'wrapper' => ['width' => 50]] + $pageLink('field_trivium_snelle_links_blok_pagina'),
                    [
                        'key' => 'field_trivium_snelle_links_blok_externe_link',
                        'label' => 'Of een externe link',
                        'name' => 'externe_link',
                        'type' => 'url',
                        'instructions' => 'Bijvoorbeeld een aanmeldformulier. Gaat voor de pagina en opent in een nieuw tabblad.',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'key' => 'field_trivium_snelle_links_blok_afbeelding',
                        'label' => 'Foto',
                        'name' => 'afbeelding',
                        'type' => 'image',
                        'instructions' => 'Staande of vierkante foto; onderin komt de titel op een donker verloop. Leeg = standaardfoto.',
                        'return_format' => 'id',
                        'preview_size' => 'medium',
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
    $bannerFields = fn (string $prefix, string $defaultNote, string $defaultAlign, string $defaultAccent) => [
        [
            'key' => "field_trivium_{$prefix}_afbeelding",
            'label' => 'Foto',
            'name' => "{$prefix}_afbeelding",
            'type' => 'image',
            'instructions' => "Liggende foto, minimaal 2000px breed. Houd het onderwerp aan de kant zonder tekst. Leeg = {$defaultNote}.",
            'return_format' => 'id',
            'preview_size' => 'medium',
        ],
        [
            'key' => "field_trivium_{$prefix}_uitlijning",
            'label' => 'Tekst',
            'name' => "{$prefix}_uitlijning",
            'type' => 'button_group',
            'choices' => ['links' => 'Links', 'rechts' => 'Rechts'],
            'default_value' => $defaultAlign,
            'wrapper' => ['width' => 50],
        ],
        [
            'key' => "field_trivium_{$prefix}_accent",
            'label' => 'Kleur tweede regel',
            'name' => "{$prefix}_accent",
            'type' => 'select',
            'choices' => ['roze' => 'Roze', 'geel' => 'Geel', 'groen' => 'Groen', 'oranje' => 'Oranje'],
            'default_value' => $defaultAccent,
            'wrapper' => ['width' => 50],
        ],
        [
            'key' => "field_trivium_{$prefix}_mobiel_tekst",
            'label' => 'Tekst op mobiel',
            'name' => "{$prefix}_mobiel_tekst",
            'type' => 'button_group',
            'instructions' => 'Zet de tekst waar hij niet over een gezicht valt.',
            'choices' => ['boven' => 'Boven', 'midden' => 'Midden', 'onder' => 'Onder'],
            'default_value' => 'onder',
            'wrapper' => ['width' => 50],
        ],
        [
            'key' => "field_trivium_{$prefix}_mobiel_focus",
            'label' => 'Focuspunt foto op mobiel',
            'name' => "{$prefix}_mobiel_focus",
            'type' => 'button_group',
            'instructions' => 'Welk deel van de foto in beeld blijft als hij smal wordt bijgesneden.',
            'choices' => ['links' => 'Links', 'midden' => 'Midden', 'rechts' => 'Rechts'],
            'default_value' => 'midden',
            'wrapper' => ['width' => 50],
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
            'label' => 'Tweede regel (in kleur)',
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
            ...$bannerFields('fotobanner_boven', 'tijdelijke foto', 'rechts', 'geel'),
            [
                'key' => 'field_trivium_fotobanner_tab_onder',
                'label' => 'Onderste banner',
                'type' => 'tab',
            ],
            ...$bannerFields('fotobanner', 'standaardfoto', 'links', 'roze'),
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
                'key' => 'field_trivium_footer_fotos',
                'label' => "Foto's",
                'name' => 'footer_fotos',
                'type' => 'gallery',
                'instructions' => 'Wisselen elkaar om de 6 seconden af. Staan vanaf tablet op de rechterhelft, op mobiel onder de tekst. Volgorde aanpassen door te slepen. Leeg = standaardfoto\'s.',
                'return_format' => 'id',
                'preview_size' => 'medium',
                'insert' => 'append',
                'max' => 6,
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

    // Knoppen onderin het uitklapmenu (components/nav-drawer) en de snelle links in het zoekpaneel (components/search-panel)
    $menuButton = fn (string $key, string $name, string $label, string $default) => [
        'key' => $key,
        'label' => $label,
        'name' => $name,
        'type' => 'link',
        'instructions' => "Leeg = {$default}.",
        'return_format' => 'array',
        'wrapper' => ['width' => 50],
    ];

    acf_add_local_field_group([
        'key' => 'group_trivium_menu',
        'title' => 'Menu en zoeken',
        'fields' => [
            [
                'key' => 'field_trivium_menu_tab_knoppen',
                'label' => 'Knoppen in het menu',
                'type' => 'tab',
            ],
            [
                'key' => 'field_trivium_menu_knoppen_message',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'message' => 'Twee knoppen onderin het uitklapmenu. De menu-items zelf beheer je onder Weergave > Menu\'s.',
            ],
            $menuButton('field_trivium_menu_knop_1', 'menu_knop_1', 'Knop 1 (roze)', 'Contact'),
            $menuButton('field_trivium_menu_knop_2', 'menu_knop_2', 'Knop 2 (omlijnd)', 'Open dagen'),
            [
                'key' => 'field_trivium_menu_tab_zoeken',
                'label' => 'Zoekpaneel',
                'type' => 'tab',
            ],
            [
                'key' => 'field_trivium_populaire_paginas',
                'label' => "Populaire pagina's",
                'name' => 'populaire_paginas',
                'type' => 'repeater',
                'instructions' => 'Links in het zoekpaneel zolang er nog niets is getypt. Geen links = het kopje verdwijnt.',
                'layout' => 'table',
                'button_label' => 'Link toevoegen',
                'sub_fields' => [
                    [
                        'key' => 'field_trivium_populaire_pagina_titel',
                        'label' => 'Titel',
                        'name' => 'titel',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    $pageLink('field_trivium_populaire_pagina_pagina'),
                ],
            ],
        ],
        'location' => $location('trivium-menu'),
    ]);

    // Fotoheader op gewone pagina's (uitgelichte afbeelding, components/page-hero.blade.php)
    acf_add_local_field_group([
        'key' => 'group_trivium_pagina_foto',
        'title' => 'Fotoheader',
        'fields' => [
            [
                'key' => 'field_trivium_pagina_foto_stijl',
                'label' => 'Stijl',
                'name' => 'foto_stijl',
                'type' => 'button_group',
                'instructions' => 'Half: vanaf desktop staat de foto rechts en loopt hij uit in het wit, met de titel links. Op mobiel zijn beide gelijk. Achter de inhoud: de foto ligt bovenaan achter de pagina en vervaagt naar beneden; titel en inhoud staan in een wit vlak in het midden. Half, foto links: hetzelfde, gespiegeld. Kader: de foto rechts in een afgerond kader, titel en intro links.',
                'choices' => ['half' => 'Half', 'half-links' => 'Half, foto links', 'kader' => 'Kader', 'achtergrond' => 'Achter de inhoud'],
                'default_value' => 'half',
            ],
            [
                'key' => 'field_trivium_pagina_foto_focus',
                'label' => 'Focuspunt foto',
                'name' => 'foto_focus',
                'type' => 'button_group',
                'instructions' => 'Met een uitgelichte afbeelding krijgt de pagina een fotoheader. Kies welk deel van de foto in beeld blijft als hij wordt bijgesneden (vooral op mobiel).',
                'choices' => ['links' => 'Links', 'midden' => 'Midden', 'rechts' => 'Rechts'],
                'default_value' => 'midden',
            ],
        ],
        'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]],
        'position' => 'side',
    ]);

    // Paginatemplate "Documenten" (template-documenten.blade.php): downloadlijst per rubriek
    acf_add_local_field_group([
        'key' => 'group_trivium_documenten',
        'title' => 'Documenten',
        'fields' => [
            [
                'key' => 'field_trivium_documenten_rubrieken',
                'label' => 'Rubrieken',
                'name' => 'documenten_rubrieken',
                'type' => 'repeater',
                'instructions' => 'Komen onder de paginatekst, elk met een kop en de documenten als downloadlijst.',
                'layout' => 'block',
                'button_label' => 'Rubriek toevoegen',
                'collapsed' => 'field_trivium_documenten_rubriek_titel',
                'sub_fields' => [
                    [
                        'key' => 'field_trivium_documenten_rubriek_titel',
                        'label' => 'Titel',
                        'name' => 'titel',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'key' => 'field_trivium_documenten_rubriek_documenten',
                        'label' => 'Documenten',
                        'name' => 'documenten',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'button_label' => 'Document toevoegen',
                        'sub_fields' => [
                            [
                                'key' => 'field_trivium_documenten_document_bestand',
                                'label' => 'Bestand',
                                'name' => 'bestand',
                                'type' => 'file',
                                'return_format' => 'id',
                                'required' => 1,
                            ],
                            [
                                'key' => 'field_trivium_documenten_document_titel',
                                'label' => 'Titel',
                                'name' => 'titel',
                                'type' => 'text',
                                'instructions' => 'Leeg = titel van het bestand in de mediabibliotheek.',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'template-documenten.blade.php']]],
    ]);
});
