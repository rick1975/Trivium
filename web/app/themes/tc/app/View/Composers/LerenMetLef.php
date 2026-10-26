<?php

namespace App\View\Composers;

use Illuminate\Support\Str;
use Roots\Acorn\View\Composer;

class LerenMetLef extends Composer
{
    protected static $views = [
        'components.leren-met-lef',
        'components.leren-met-lef-test',
    ];

    public function with()
    {
        $onderwerpen = function_exists('get_field') ? (get_field('leren_met_lef', 'option') ?: []) : [];

        return [
            'onderwerpen' => array_map(fn ($item) => [
                'titel' => $item['titel'] ?? '',
                'anker' => $this->anker($item['titel'] ?? ''),
                'intro' => $item['intro'] ?? '',
                'foto' => $item['foto'] ?? null,
                'video' => $this->video($item['video'] ?? ''),
                'blokken' => $this->blokken($item['content'] ?? ''),
            ], $onderwerpen),
        ];
    }

    /**
     * Video-link (YouTube of Vimeo) omzetten naar wat de speler nodig heeft: de embed-URL (pas na de klik geladen, zonder
     * tracking), een stilstaand beeld voor als er geen foto is en de duur (die geeft alleen Vimeo zonder API-sleutel).
     * De Vimeo-gegevens komen uit oEmbed en worden een dag bewaard. Onbekende link → null, dan blijft alles zoals zonder video.
     */
    protected function video(string $url): ?array
    {
        $url = trim($url);

        if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([\w-]{11})~', $url, $m)) {
            return [
                'embed' => "https://www.youtube-nocookie.com/embed/{$m[1]}?autoplay=1&rel=0",
                'beeld' => "https://i.ytimg.com/vi/{$m[1]}/maxresdefault.jpg",
                'reserve' => "https://i.ytimg.com/vi/{$m[1]}/hqdefault.jpg",
                'duur' => null,
            ];
        }

        // Ook niet-openbare video's: vimeo.com/123/abcdef of player.vimeo.com/video/123?h=abcdef
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)(?:/([\da-f]+))?~', $url, $m)) {
            $hash = $m[2] ?? (preg_match('~[?&]h=([\da-f]+)~', $url, $h) ? $h[1] : '');

            $sleutel = 'trivium_vimeo_'.md5($url);
            $info = get_transient($sleutel);
            if ($info === false) {
                $antwoord = wp_remote_get('https://vimeo.com/api/oembed.json?width=1280&url='.rawurlencode($url), ['timeout' => 5]);
                $info = json_decode(wp_remote_retrieve_body($antwoord), true) ?: [];
                // Mislukt: na een uur opnieuw proberen
                set_transient($sleutel, $info, $info ? DAY_IN_SECONDS : HOUR_IN_SECONDS);
            }

            $duur = (int) ($info['duration'] ?? 0);

            return [
                'embed' => "https://player.vimeo.com/video/{$m[1]}?autoplay=1&dnt=1".($hash ? "&h={$hash}" : ''),
                'beeld' => $info['thumbnail_url'] ?? null,
                'reserve' => null,
                'duur' => $duur ? sprintf('%d:%02d', intdiv($duur, 60), $duur % 60) : null,
            ];
        }

        return null;
    }

    /**
     * Korte, deelbare anker-id uit de titel (bijv. "Leren met lef is goed voor je zorgen" → "goed-voor-je-zorgen"),
     * zodat je direct naar een onderwerp kunt linken: /#goed-voor-je-zorgen.
     */
    protected function anker(string $titel): string
    {
        $slug = preg_replace('/^leren-met-lef-(is-)?/', '', Str::slug($titel));

        return $slug !== '' ? $slug : 'leren-met-lef';
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
