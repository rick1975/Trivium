<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class LerenMetLef extends Composer
{
    protected static $views = [
        'components.leren-met-lef',
    ];

    public function with()
    {
        $onderwerpen = function_exists('get_field') ? (get_field('leren_met_lef', 'option') ?: []) : [];

        return [
            'onderwerpen' => array_map(fn ($item) => [
                'titel' => $item['titel'] ?? '',
                'intro' => $item['intro'] ?? '',
                'foto' => $item['foto'] ?? null,
                'blokken' => $this->blokken($item['content'] ?? ''),
            ], $onderwerpen),
        ];
    }

    /**
     * Deel de content op in blokken, per alinea (gescheiden door een witregel):
     * - regels die met • of - beginnen worden een opsomming ('lijst'; die regel vet, de regels eronder de toelichting;
     *   een lange regel zonder toelichting blijft gewone tekst);
     * - een alinea waarvan de eerste regel kort is en niet op een leesteken eindigt, krijgt die regel als kop ('kop');
     * - de rest is gewone tekst ('tekst').
     * Afgebroken regels (bijv. geplakt uit een pdf) worden weer aan elkaar gezet.
     */
    protected function blokken(string $content): array
    {
        $blokken = [];

        foreach (preg_split('/\R\s*\R/', trim($content)) as $alinea) {
            $regels = array_values(array_filter(array_map('trim', preg_split('/\R/', $alinea)), 'strlen'));
            if (! $regels) {
                continue;
            }

            if (! preg_match('/^[•\-]/u', $regels[0])) {
                $tekst = [];
                while ($regels && ! preg_match('/^[•\-]/u', $regels[0])) {
                    $tekst[] = array_shift($regels);
                }
                $isKop = count($tekst) > 1 && mb_strlen($tekst[0]) <= 60 && ! preg_match('/[.!?:,;]$/u', $tekst[0]);
                $blokken[] = $isKop
                    ? ['type' => 'kop', 'kop' => array_shift($tekst), 'tekst' => implode(' ', $tekst)]
                    : ['type' => 'tekst', 'tekst' => implode(' ', $tekst)];
            }

            foreach ($regels as $regel) {
                $laatste = array_key_last($blokken);
                if (preg_match('/^[•\-]\s*(.+)$/u', $regel, $m)) {
                    if (($blokken[$laatste]['type'] ?? null) !== 'lijst') {
                        $blokken[] = ['type' => 'lijst', 'punten' => []];
                        $laatste = array_key_last($blokken);
                    }
                    $blokken[$laatste]['punten'][] = ['kop' => $m[1], 'tekst' => ''];
                } else {
                    $punt = array_key_last($blokken[$laatste]['punten']);
                    $blokken[$laatste]['punten'][$punt]['tekst'] = trim($blokken[$laatste]['punten'][$punt]['tekst'].' '.$regel);
                }
            }
        }

        // Een opsommingspunt zonder toelichting dat zelf een lange zin is, is geen kop: dat wordt gewone tekst (niet vet)
        foreach ($blokken as &$blok) {
            foreach ($blok['punten'] ?? [] as $n => $punt) {
                $blok['punten'][$n]['vet'] = $punt['tekst'] !== '' || mb_strlen($punt['kop']) <= 80;
            }
        }
        unset($blok);

        return $blokken;
    }
}
