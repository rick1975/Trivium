<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Vite;
use Roots\Acorn\View\Composer;

class News extends Composer
{
    protected static $views = [
        'components.news',
    ];

    /**
     * Kleuren voor het categorie-label, per kaart om de beurt.
     */
    protected array $categoryClasses = [
        'bg-triv-pink text-white',
        'bg-triv-blue text-white',
        'bg-triv-yellow text-[#1a1612]',
    ];

    public function with()
    {
        return [
            'newsItems' => $this->items(),
            'newsArchiveUrl' => get_post_type_archive_link('post'),
        ];
    }

    /**
     * De drie nieuwste berichten. Zolang er nog geen berichten zijn,
     * worden de voorbeeldberichten getoond.
     */
    protected function items(): array
    {
        $posts = get_posts([
            'numberposts' => 3,
            'post_status' => 'publish',
            'no_found_rows' => true,
        ]);

        if (! $posts) {
            return $this->placeholders();
        }

        $fallbackImages = $this->fallbackImages();

        return array_map(function (\WP_Post $post, int $i) use ($fallbackImages) {
            $category = get_the_category($post->ID)[0] ?? null;
            $thumbnail = get_post_thumbnail_id($post);

            return [
                'url' => get_permalink($post),
                'image' => get_the_post_thumbnail_url($post, 'large') ?: $fallbackImages[$i % count($fallbackImages)],
                'alt' => $thumbnail ? (get_post_meta($thumbnail, '_wp_attachment_image_alt', true) ?: '') : '',
                'category' => $category?->name,
                'categoryClass' => $this->categoryClasses[$i % count($this->categoryClasses)],
                'date' => get_the_date('j F Y', $post),
                'datetime' => get_the_date('Y-m-d', $post),
                'title' => get_the_title($post),
                'excerpt' => has_excerpt($post)
                    ? $post->post_excerpt
                    : wp_trim_words(wp_strip_all_tags(strip_shortcodes($post->post_content)), 18),
            ];
        }, $posts, array_keys($posts));
    }

    protected function fallbackImages(): array
    {
        return [
            Vite::asset('resources/images/Jongen-roert-in-pan.avif'),
            Vite::asset('resources/images/twee-jongens-aan-het-werk.avif'),
            Vite::asset('resources/images/drie-dames-kijken-op-laptop.avif'),
        ];
    }

    /**
     * Voorbeeldberichten (de oorspronkelijke statische inhoud).
     */
    protected function placeholders(): array
    {
        $images = $this->fallbackImages();

        return [
            [
                'url' => '#',
                'image' => $images[0],
                'alt' => 'Jongen roert in een pan in het schoolrestaurant',
                'category' => 'Levensecht leren',
                'categoryClass' => $this->categoryClasses[0],
                'date' => '28 maart 2026',
                'datetime' => '2026-03-28',
                'title' => 'Leerlingen koken voor echte gasten in ons schoolrestaurant',
                'excerpt' => 'Een driegangenmenu voor ouders en docenten. Levensecht leren in de keuken een avond om nooit te vergeten.',
            ],
            [
                'url' => '#',
                'image' => $images[1],
                'alt' => 'Twee jongens aan het werk in het praktijklokaal',
                'category' => 'Nieuws',
                'categoryClass' => $this->categoryClasses[1],
                'date' => '15 maart 2026',
                'datetime' => '2026-03-15',
                'title' => 'Trivium wint regionale vakwedstrijd techniek',
                'excerpt' => 'Eerste prijs bij de regionale skills-wedstrijd!',
            ],
            [
                'url' => \App\page_url('open-dagen'),
                'image' => Vite::asset('resources/images/jongen-achter-laptop.avif'),
                'alt' => 'Jongen met krullen werkt op een laptop in de klas',
                'category' => 'Agenda',
                'categoryClass' => $this->categoryClasses[2],
                'date' => '5 maart 2026',
                'datetime' => '2026-03-05',
                'title' => 'Open dag > 18 april > kom langs!',
                'excerpt' => 'Groep 8 leerlingen en ouders zijn van harte welkom.',
            ],
        ];
    }
}
