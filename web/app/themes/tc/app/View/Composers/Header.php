<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Header extends Composer
{
    protected static $views = [
        'sections.header',
    ];

    /**
     * overPhoto: de header ligt transparant over een foto, met wit logo en witte iconen. Op de voorpagina (hero) en op
     * pagina's met fotoheaderstijl "achter de inhoud" (components/page-backdrop).
     */
    public function with()
    {
        $backdrop = is_page() && has_post_thumbnail() && function_exists('get_field') && get_field('foto_stijl') === 'achtergrond';

        return [
            'isFront' => is_front_page(),
            'overPhoto' => is_front_page() || $backdrop,
            'languages' => $this->languages(),
        ];
    }

    /**
     * Talen voor de taalknop in de header (TranslatePress). Elke taal heeft een korte code (NL, EN), de naam, de url
     * van de huidige pagina in die taal en of het de actieve taal is. Leeg als TranslatePress niet actief is.
     */
    protected function languages()
    {
        if (! function_exists('trp_custom_language_switcher')) {
            return [];
        }

        global $TRP_LANGUAGE;

        return collect(trp_custom_language_switcher())
            ->map(fn ($language, $code) => (object) [
                'code' => strtoupper(strtok($code, '_')),
                'name' => $language['language_name'],
                'url' => $language['current_page_url'],
                'active' => $code === $TRP_LANGUAGE,
            ])
            ->values()
            ->all();
    }
}
