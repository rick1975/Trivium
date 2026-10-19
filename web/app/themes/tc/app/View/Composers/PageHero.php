<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageHero extends Composer
{
    protected static $views = [
        'components.page-hero',
        'components.page-backdrop',
    ];

    /**
     * Fotoheader van een gewone pagina: uitgelichte afbeelding, titel en de bovenliggende pagina (als label boven
     * de titel). Het focuspunt (ACF "Fotoheader") bepaalt de horizontale uitsnede; verticaal ligt het iets boven
     * het midden, waar gezichten meestal zitten. Stijl: 'half' (standaard, vanaf desktop foto rechts), 'half-links', 'kader' of
     * 'achtergrond' (foto achter de inhoud, components/page-backdrop). De schermbrede stijl ('breed') is geen keuze meer:
     * oude of lege waarden worden 'half'.
     */
    public function with()
    {
        $id = get_queried_object_id();
        $parent = wp_get_post_parent_id($id);
        $focus = function_exists('get_field') ? get_field('foto_focus', $id) : null;

        return [
            'image' => get_post_thumbnail_id($id),
            'title' => get_the_title($id),
            'parent' => $parent ? ['title' => get_the_title($parent), 'url' => get_permalink($parent)] : null,
            'features' => $this->features($id),
            'intro' => $this->intro($id),
            'buttons' => $this->buttons($id),
            'layout' => match ($stijl = function_exists('get_field') ? get_field('foto_stijl', $id) : null) {
                'half-links', 'kader', 'achtergrond' => $stijl,
                default => 'half',
            },
            'position' => match ($focus) {
                'links' => '35% 40%',
                'rechts' => '65% 40%',
                default => '50% 40%',
            },
        ];
    }

    /**
     * De intro: de eerste alinea, als de inhoud daarmee begint (HTML van de alinea, met eventuele links). De fotoheader
     * "half" toont hem vanaf desktop onder de titel; in de inhoud is hij dan verborgen (zie css/app.css).
     */
    protected function intro(int $id): ?string
    {
        $blocks = array_values(array_filter(
            parse_blocks(get_post_field('post_content', $id)),
            fn ($block) => $block['blockName'] !== null
        ));

        if (($blocks[0]['blockName'] ?? null) !== 'core/paragraph') {
            return null;
        }

        $html = trim(preg_replace('#^\s*<p[^>]*>|</p>\s*$#', '', $blocks[0]['innerHTML']));

        return $html !== '' ? $html : null;
    }

    /**
     * Knoppen direct na de intro (een blok Knoppen als tweede blok, na de eerste alinea): de fotoheader "half" en
     * "kader" tonen ze vanaf desktop onder de intro; in de inhoud zijn ze dan verborgen (zie css/app.css).
     */
    protected function buttons(int $id): ?string
    {
        $blocks = array_values(array_filter(
            parse_blocks(get_post_field('post_content', $id)),
            fn ($block) => $block['blockName'] !== null
        ));

        if (($blocks[0]['blockName'] ?? null) !== 'core/paragraph' || ($blocks[1]['blockName'] ?? null) !== 'core/buttons') {
            return null;
        }

        return trim(render_block($blocks[1])) ?: null;
    }

    /**
     * Teksten van de eerste lijst met blokstijl "Kenmerken" in de inhoud; de fotoheader "half" toont ze vanaf
     * desktop onderaan over de foto.
     */
    protected function features(int $id): array
    {
        foreach (parse_blocks(get_post_field('post_content', $id)) as $block) {
            if ($block['blockName'] === 'core/list' && str_contains($block['attrs']['className'] ?? '', 'is-style-kenmerken')) {
                return array_values(array_filter(array_map(
                    fn ($item) => trim(wp_strip_all_tags($item['innerHTML'])),
                    $block['innerBlocks']
                )));
            }
        }

        return [];
    }
}
