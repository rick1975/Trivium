<?php

/**
 * ACF-optiepagina "Trivium Settings" en bijbehorende velden.
 */

namespace App;

/**
 * Registreer de optiepagina.
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
        'redirect' => false,
        'icon_url' => 'dashicons-admin-generic',
        'position' => 80,
    ]);
});

/**
 * Registreer de velden voor de optiepagina.
 *
 * @return void
 */
add_action('acf/init', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_trivium_settings',
        'title' => 'Trivium Settings',
        'fields' => [
            [
                'key' => 'field_trivium_tab_contactgegevens',
                'label' => 'Contactgegevens',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_trivium_adres',
                'label' => 'Adres',
                'name' => 'adres',
                'type' => 'textarea',
                'rows' => 3,
                'new_lines' => 'br',
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
                'key' => 'field_trivium_tab_leren_met_lef',
                'label' => 'Leren met lef',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_trivium_leren_met_lef',
                'label' => 'Leren met lef',
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
                        'new_lines' => 'br',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'trivium-settings',
                ],
            ],
        ],
    ]);
});
