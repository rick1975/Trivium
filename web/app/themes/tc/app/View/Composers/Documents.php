<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Documents extends Composer
{
    protected static $views = [
        'template-documenten',
    ];

    /**
     * Rubrieken met documenten uit de ACF-velden van de pagina (template "Documenten"). Per document de
     * url, titel (eigen titel, anders die uit de mediabibliotheek), bestandstype en -grootte; verwijderde
     * bestanden en lege rubrieken vallen weg.
     */
    public function with()
    {
        $rubrieken = function_exists('get_field') ? (get_field('documenten_rubrieken') ?: []) : [];

        $rubrieken = array_map(fn ($rubriek) => [
            'title' => $rubriek['titel'],
            'id' => sanitize_title($rubriek['titel']),
            'documents' => array_values(array_filter(array_map(function ($document) {
                $id = (int) $document['bestand'];
                $url = $id ? wp_get_attachment_url($id) : false;

                if (! $url) {
                    return null;
                }

                $path = get_attached_file($id);

                return [
                    'url' => $url,
                    // get_the_title geeft HTML-entiteiten (&#8211;), Blade escapet die nog een keer
                    'title' => $document['titel'] ?: html_entity_decode(get_the_title($id), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                    'type' => strtoupper(pathinfo($url, PATHINFO_EXTENSION)),
                    'size' => $path && file_exists($path) ? size_format(filesize($path), 1) : null,
                ];
            }, $rubriek['documenten'] ?: []))),
        ], $rubrieken);

        return [
            'rubrieken' => array_values(array_filter($rubrieken, fn ($rubriek) => $rubriek['documents'])),
        ];
    }
}
