{{-- ── LEREN MET LEF — onderwerpen uit Trivium Settings > Leren met lef (Composers\LerenMetLef, die de content ook opdeelt in blokken).
     Vanaf lg tabbladen: links de genummerde titels, rechts de inhoud van het gekozen onderwerp (één vast vlak, dus niets verspringt).
     Op mobiel dezelfde markup als uitklaplijst: knop met titel en korte intro, de inhoud klapt eronder open.
     Eén grid voor beide: de knoppen vullen kolom 1 van boven naar beneden, alle panelen liggen in kolom 2 over elkaar
     (over alle rijen plus een laatste 1fr-rij die de extra hoogte opvangt) en alleen het actieve is zichtbaar.
     Het eerste onderwerp staat standaard open, tenzij de URL een anker van een onderwerp heeft (/#goed-voor-je-zorgen, zie
     Composers\LerenMetLef::anker); kiezen zet dat anker ook in de URL, zodat je de link kunt delen.
     Pijltjestoetsen (en Home/End) springen tussen de onderwerpen; op desktop wordt het onderwerp dan ook meteen gekozen.
     Binnenkomst: zodra het blok in beeld komt (x-intersect zet data-shown, net als bij Nieuws) schuiven de onderwerpen
     één voor één omhoog en daarna het inhoudsvlak; bij "minder beweging" staat alles meteen stil.
     Video (YouTube/Vimeo, zie Composers\LerenMetLef::video): afspeelknop op de foto (of zonder foto op het beeld van de video);
     de speler laadt pas na de klik, in een venster over de pagina. Sluiten (knop, Esc of klik ernaast) haalt de iframe weg,
     zodat de video stopt. ── --}}
{{-- Per onderwerp een rubriekskleur (Over de school, Leerlingen & ouders, Groep 8, Beleid & documenten, Ons onderwijs):
     voor de rand en het cijfer van het bolletje, de titel bij hover en het pijltje links, en in het inhoudsvlak de titel en de opsommingsbolletjes
     (vette tekst en tussenkoppen blijven navy). Vanaf lg krijgen het inhoudsvlak en het actieve tabblad een lichte tint van die kleur ('vlak'),
     zodat het hele blok van sfeer wisselt. Klassen voluit, zodat Tailwind ze vindt. --}}
@php
  $kleuren = [
    ['rand' => 'border-triv-hemelblauw', 'tekst' => 'text-triv-hemelblauw', 'hover' => 'group-hover:text-triv-hemelblauw', 'bolletje' => 'before:bg-triv-hemelblauw', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-hemelblauw)_11%,white)]'],
    ['rand' => 'border-triv-oudroze', 'tekst' => 'text-triv-oudroze', 'hover' => 'group-hover:text-triv-oudroze', 'bolletje' => 'before:bg-triv-oudroze', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-oudroze)_11%,white)]'],
    ['rand' => 'border-triv-koraal', 'tekst' => 'text-triv-koraal', 'hover' => 'group-hover:text-triv-koraal', 'bolletje' => 'before:bg-triv-koraal', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-koraal)_11%,white)]'],
    ['rand' => 'border-triv-zeegroen', 'tekst' => 'text-triv-zeegroen', 'hover' => 'group-hover:text-triv-zeegroen', 'bolletje' => 'before:bg-triv-zeegroen', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-zeegroen)_11%,white)]'],
    ['rand' => 'border-triv-paars', 'tekst' => 'text-triv-paars', 'hover' => 'group-hover:text-triv-paars', 'bolletje' => 'before:bg-triv-paars', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-paars)_11%,white)]'],
    ['rand' => 'border-triv-lightblue', 'tekst' => 'text-triv-lightblue', 'hover' => 'group-hover:text-triv-lightblue', 'bolletje' => 'before:bg-triv-lightblue', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-lightblue)_11%,white)]'],
  ];
  $rijen = count($onderwerpen);
  $videos = array_map(fn ($o) => $o['video'] ? $o['video'] + ['titel' => $o['titel']] : null, $onderwerpen);
@endphp

<section class="relative z-20 -mt-[7vh]">
  {{-- Golfboog direct over de hero-foto: de section zelf heeft hier geen achtergrond, zodat er contrast is --}}
  @include('components.wave-divider', ['fill' => '#fbfaf4'])

  <div class="bg-triv-cream pt-16 pb-20">
    <div class="page-container">
      @if($onderwerpen)
        {{-- Desktop: klik kiest een ander onderwerp (er staat er altijd één open); mobiel: klik klapt open of dicht.
             Wordt het scherm breder terwijl alles dicht is, dan gaat het eerste weer open. --}}
        <div x-data="{ actief: 0, video: null, videos: {{ Js::from($videos) }}, ankers: {{ Js::from(array_column($onderwerpen, 'anker')) }}, lg: () => window.matchMedia('(min-width: 1024px)').matches, init() { this.volgHash() }, volgHash() { const i = this.ankers.indexOf(decodeURIComponent(location.hash.slice(1))); if (i > -1) this.actief = i }, kies(i) { this.actief = (this.actief === i && ! this.lg()) ? null : i; if (this.actief !== null) history.replaceState(null, '', '#' + this.ankers[i]) }, naar(i) { const n = (i + this.ankers.length) % this.ankers.length; document.getElementById('lef-knop-' + n).focus(); if (this.lg()) this.kies(n) } }"
          @resize.window.debounce.150ms="if (actief === null && lg()) actief = 0"
          @hashchange.window="volgHash()"
          x-intersect.once.margin.0.0.-20%.0="$el.dataset.shown = ''"
          class="group/lef flex flex-col gap-3 lg:grid lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:gap-x-10 lg:gap-y-4 lg:items-start"
          style="grid-template-rows: repeat({{ $rijen }}, auto) 1fr;">

          @foreach ($onderwerpen as $i => $item)
            @php($kleur = $kleuren[$i % count($kleuren)])
            @php($beeld = $item['foto'] || $item['video'])
            {{-- Titel + knop (kolom 1). Titels zijn h2, direct onder de h1 "Leren met Lef" in de hero --}}
            {{-- Vanaf lg loopt het actieve onderwerp als tabblad door in het inhoudsvlak: zelfde tint, geen ruimte ertussen.
                 De knop is daarvoor de kolomafstand (gap-x-10) plus 0,75rem breder, zodat hij ook de afgeronde hoek van het
                 vlak afdekt, en de h2 komt boven het vlak te liggen (z-10). --}}
            <h2 id="{{ $item['anker'] }}" style="--i: {{ $i }}" :class="actief === {{ $i }} && 'lg:z-10'"
              class="relative mb-0 scroll-mt-6 lg:col-start-1 translate-y-6 opacity-0 transition-[translate,opacity] duration-700 ease-[cubic-bezier(.2,.8,.2,1)] delay-[calc(var(--i)*90ms)] group-data-shown/lef:translate-y-0 group-data-shown/lef:opacity-100 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none">
              <button type="button" id="lef-knop-{{ $i }}" aria-controls="lef-paneel-{{ $i }}"
                aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" :aria-expanded="(actief === {{ $i }}).toString()"
                class="group flex w-full items-start gap-4 rounded-xl border border-transparent p-4 lg:p-3 text-left cursor-pointer transition-all duration-300"
                :class="actief === {{ $i }} ? 'bg-white {{ $kleur['vlak'] }} lg:w-[calc(100%+3.25rem)] lg:pr-[calc(0.75rem+3.25rem)] lg:rounded-r-none' : 'bg-white lg:bg-transparent lg:hover:bg-white/70'"
                @click="kies({{ $i }})"
                @keydown.down.prevent="naar({{ $i + 1 }})" @keydown.right.prevent="naar({{ $i + 1 }})"
                @keydown.up.prevent="naar({{ $i - 1 }})" @keydown.left.prevent="naar({{ $i - 1 }})"
                @keydown.home.prevent="naar(0)" @keydown.end.prevent="naar(ankers.length - 1)">
                <span aria-hidden="true" class="{{ $kleur['rand'] }} {{ $kleur['tekst'] }} size-10 shrink-0 rounded-full border-2 flex items-center justify-center font-black text-base">
                  {{ $i + 1 }}
                </span>
                <span class="flex-1 self-center">
                  <span class="block text-lg font-semibold leading-snug lg:text-base text-triv-navy transition-colors {{ $kleur['hover'] }}">{{ $item['titel'] }}</span>
                  @if($item['intro'])
                    <span class="mt-1 block text-sm font-normal leading-relaxed text-stone-600 lg:hidden">{{ $item['intro'] }}</span>
                  @endif
                </span>
                {{-- Pijltje: navy, bij het actieve onderwerp in de rubriekskleur; mobiel draait het bij openklappen, vanaf lg blijft het staan --}}
                <span aria-hidden="true" class="mt-3.5 shrink-0 transition-[rotate,color] duration-300"
                  :class="actief === {{ $i }} ? 'rotate-90 lg:rotate-0 {{ $kleur['tekst'] }}' : 'text-triv-navy'">
                  <x-icon name="chevron-right" class="size-3 stroke-[2.5]" />
                </span>
              </button>
            </h2>

            {{-- Inhoud (kolom 2, alle panelen op dezelfde plek) --}}
            <div id="lef-paneel-{{ $i }}" role="region" aria-labelledby="lef-knop-{{ $i }}" x-show="actief === {{ $i }}"
              class="rounded-xl bg-white {{ $kleur['vlak'] }} p-5 shadow-sm sm:p-7 lg:col-start-2 lg:row-start-1 lg:p-0 {{ $beeld ? 'lg:grid lg:grid-cols-[minmax(0,1fr)_minmax(0,0.75fr)] lg:grid-rows-[auto_1fr] lg:overflow-hidden' : '' }} lg:translate-y-6 lg:opacity-0 lg:transition-[translate,opacity] lg:duration-700 lg:delay-300 lg:ease-[cubic-bezier(.2,.8,.2,1)] lg:group-data-shown/lef:translate-y-0 lg:group-data-shown/lef:opacity-100 lg:motion-reduce:translate-y-0 lg:motion-reduce:opacity-100 lg:motion-reduce:transition-none"
              style="grid-row-end: span {{ $rijen + 1 }};{{ $i > 0 ? ' display: none;' : '' }}">

              {{-- Bij wisselen van onderwerp schuift de tekst zacht omhoog en komt de foto in beeld: een CSS-animatie start
                   opnieuw zodra x-show het paneel weer toont (display: none → block). Keyframes uit app.css (fotoheader). --}}
              {{-- Titel en intro alleen vanaf lg (op mobiel staan ze al in de knop); bij een foto in de linkerkolom, naast de foto --}}
              <div class="hidden lg:col-start-1 lg:row-start-1 lg:block lg:px-10 lg:pt-10 lg:pb-5 lg:animate-[hero-rise_500ms_cubic-bezier(.2,.8,.2,1)_both] motion-reduce:animate-none">
                <p class="mb-2 font-['Poppins',sans-serif] text-3xl font-bold leading-tight {{ $kleur['tekst'] }}">{{ $item['titel'] }}</p>
                @if($item['intro'])
                  <p class="mb-0 text-lg leading-relaxed text-stone-600">{{ $item['intro'] }}</p>
                @endif
              </div>

              {{-- Met foto of video: vanaf lg is het vlak een grid met onder de titel de tekst links en rechts het beeld, dat van boven tot onder
                   tegen de rand van het vlak loopt (het vlak zelf heeft dan geen padding, titel en tekst wel); op mobiel het beeld erboven
                   (bij een video liggend 16:9). Zonder foto het beeld van de video; bij YouTube valt dat terug op een kleinere versie
                   als er geen groot beeld is. --}}
              @if($beeld)
                <div @class(['relative mb-6 overflow-hidden rounded-xl lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:mb-0 lg:aspect-auto lg:min-h-80 lg:rounded-none lg:animate-[hero-photo_700ms_ease-out_both] motion-reduce:animate-none', 'aspect-4/3' => ! $item['video'], 'aspect-video bg-triv-navy' => $item['video']])>
                @if($item['foto'])
                  {!! wp_get_attachment_image($item['foto'], 'large', false, [
                    'class' => 'absolute inset-0 size-full max-w-none object-cover object-[45%_35%] lg:object-[50%_40%]',
                    'sizes' => '(min-width: 1024px) 600px, 100vw',
                    'loading' => 'lazy',
                    'decoding' => 'async',
                  ]) !!}
                @elseif($item['video']['beeld'])
                  <img src="{{ $item['video']['beeld'] }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full max-w-none object-cover"
                    @if($item['video']['reserve']) onerror="this.onerror = null; this.src = '{{ $item['video']['reserve'] }}'" @endif>
                @endif
                @if($item['video'])
                  <button type="button" @click="video = {{ $i }}" aria-haspopup="dialog" aria-label="Bekijk de video: {{ $item['titel'] }}"
                    class="group/video absolute inset-0 flex size-full cursor-pointer items-center justify-center bg-triv-navy/10 transition-colors duration-300 hover:bg-triv-navy/25">
                    <span class="{{ $kleur['tekst'] }} flex size-16 items-center justify-center rounded-full bg-white/95 shadow-lg ring-8 ring-white/30 transition-transform duration-300 ease-[cubic-bezier(.34,1.56,.64,1)] group-hover/video:scale-110 group-focus-visible/video:scale-110 motion-reduce:transition-none lg:size-20">
                      <x-icon name="play" class="size-7 lg:size-8" />
                    </span>
                    @if($item['video']['duur'])
                      <span class="absolute right-3 bottom-3 rounded-full bg-triv-navy/80 px-2.5 py-1 text-xs font-semibold text-white">{{ $item['video']['duur'] }}</span>
                    @endif
                  </button>
                @endif
                </div>
              @endif

              <div class="lg:col-start-1 lg:row-start-2 lg:px-10 lg:pb-10">

              @if($item['blokken'])
                <div class="flex flex-col gap-6 text-base lg:animate-[hero-rise_500ms_100ms_cubic-bezier(.2,.8,.2,1)_both] motion-reduce:animate-none">
                  @foreach($item['blokken'] as $blok)
                    @if($blok['type'] === 'lijst')
                      <ul @class(['mb-0 grid gap-x-10 gap-y-5', 'md:grid-cols-2' => ! $beeld])>
                        @foreach($blok['punten'] as $punt)
                          <li class="relative mb-0 pl-5 before:absolute before:left-0 before:top-[0.55em] before:size-2 before:rounded-full {{ $kleur['bolletje'] }}">
                            <span @class(['block', 'font-semibold text-triv-navy' => $punt['vet'], 'text-stone-600' => ! $punt['vet']])>
                              {{ $punt['kop'] }}
                              {{-- Bij het punt over (gratis) fruit: de fruitanimatie uit het nieuwsblok (ploppen op, kleuren dan in).
                                   x-intersect zet data-shown zodra het paneel in beeld komt en haalt het weg als het verdwijnt (ander tabblad / dichtgeklapt), zodat hij elke keer opnieuw speelt. --}}
                              @if(str_contains(mb_strtolower($punt['kop']), 'fruit'))
                                <span x-data="{ shown: false }" x-intersect="shown = true" x-intersect:leave="shown = false" :data-shown="shown" aria-hidden="true" class="group/fruit mt-2 flex items-center gap-1.5">
                                  @foreach(['apple', 'banana', 'watermelon'] as $fruit)
                                    <x-icon :name="$fruit" :size="24" class="h-6 w-auto md:h-7 text-triv-navy scale-0 transition-transform duration-400 ease-[cubic-bezier(.34,1.56,.64,1)] delay-[calc(300ms+var(--i)*120ms)] group-data-shown/fruit:scale-100 motion-reduce:scale-100 motion-reduce:transition-none [&_.fruit-fill]:opacity-0 [&_.fruit-fill]:transition-opacity [&_.fruit-fill]:duration-700 [&_.fruit-fill]:delay-[calc(1200ms+var(--i)*250ms)] group-data-shown/fruit:[&_.fruit-fill]:opacity-100 motion-reduce:[&_.fruit-fill]:opacity-100 [&_.fruit-outline]:transition-[stroke-width,color] [&_.fruit-outline]:duration-700 [&_.fruit-outline]:delay-[calc(1200ms+var(--i)*250ms)] group-data-shown/fruit:[&_.fruit-outline]:stroke-6 group-data-shown/fruit:[&_.fruit-outline]:text-triv-navy/70 motion-reduce:[&_.fruit-outline]:stroke-6 motion-reduce:[&_.fruit-outline]:text-triv-navy/70" style="--i: {{ $loop->index }}" />
                                  @endforeach
                                </span>
                              @endif
                            </span>
                            @if($punt['tekst'])
                              <span class="mt-1 block text-stone-600">{{ $punt['tekst'] }}</span>
                            @endif
                          </li>
                        @endforeach
                        {{-- Bij "op maat" (zonder foto, oneven aantal punten) vult een meetlint het lege vak rechtsonder; speelt net als
                             het fruit elke keer opnieuw als het paneel in beeld komt (x-intersect). Vanaf md, waar de lijst twee kolommen heeft. --}}
                        @if(! $beeld && str_contains(mb_strtolower($item['titel']), 'op maat') && count($blok['punten']) % 2)
                          <li aria-hidden="true" class="mb-0 hidden items-center justify-center md:flex">
                            <span x-data="{ shown: false }" x-intersect="shown = true" x-intersect:leave="shown = false" :data-shown="shown" class="block w-full max-w-60">
                              <x-icon name="meetlint" class="h-auto w-full text-triv-navy" />
                            </span>
                          </li>
                        @endif
                      </ul>
                    @elseif($blok['type'] === 'kop')
                      <div>
                        <h3 class="mb-1 text-lg font-semibold text-triv-navy">{{ $blok['kop'] }}</h3>
                        <p class="mb-0 text-stone-600">{{ $blok['tekst'] }}</p>
                      </div>
                    @else
                      <p class="mb-0 text-stone-600">{{ $blok['tekst'] }}</p>
                    @endif
                  @endforeach
                </div>
              @else
                <p class="mb-0 italic text-stone-500">Hierover volgt binnenkort meer.</p>
              @endif
              </div>
            </div>
          @endforeach

          {{-- Videovenster: naar de body verplaatst, zodat het boven alles ligt (en niet in het grid of onder een translate valt).
               x-trap houdt de focus in het venster (eerst op de sluitknop) en zet hem bij sluiten terug op de afspeelknop. --}}
          <template x-teleport="body">
            <div x-show="video !== null" x-transition.opacity.duration.300ms x-trap.inert.noscroll="video !== null"
              @keydown.escape.window="video = null" @click.self="video = null"
              role="dialog" aria-modal="true" :aria-label="video !== null && videos[video].titel"
              class="fixed inset-0 z-60 flex items-center justify-center bg-triv-navy/90 p-4 backdrop-blur-sm sm:p-10" style="display: none;">
              <div class="relative w-full max-w-5xl">
                <button type="button" @click="video = null" aria-label="Video sluiten"
                  class="absolute right-0 -top-12 flex size-10 cursor-pointer items-center justify-center rounded-full text-white/80 transition-colors hover:bg-white/10 hover:text-white">
                  <x-icon name="close" :size="18" />
                </button>
                <div class="aspect-video overflow-hidden rounded-xl bg-black shadow-2xl">
                  <template x-if="video !== null">
                    <iframe :src="videos[video].embed" :title="videos[video].titel" class="size-full" allow="autoplay; fullscreen; picture-in-picture; encrypted-media" allowfullscreen></iframe>
                  </template>
                </div>
              </div>
            </div>
          </template>

        </div>
      @endif
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
