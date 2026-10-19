{{-- ── LEREN MET LEF — onderwerpen uit Trivium Settings > Leren met lef (Composers\LerenMetLef, die de content ook opdeelt in blokken).
     Vanaf lg tabbladen: links de genummerde titels, rechts de inhoud van het gekozen onderwerp (één vast vlak, dus niets verspringt).
     Op mobiel dezelfde markup als uitklaplijst: knop met titel en korte intro, de inhoud klapt eronder open.
     Eén grid voor beide: de knoppen vullen kolom 1 van boven naar beneden, alle panelen liggen in kolom 2 over elkaar
     (over alle rijen plus een laatste 1fr-rij die de extra hoogte opvangt) en alleen het actieve is zichtbaar.
     Het eerste onderwerp staat standaard open, tenzij de URL een anker van een onderwerp heeft (/#goed-voor-je-zorgen, zie
     Composers\LerenMetLef::anker); kiezen zet dat anker ook in de URL, zodat je de link kunt delen.
     Pijltjestoetsen (en Home/End) springen tussen de onderwerpen; op desktop wordt het onderwerp dan ook meteen gekozen.
     Binnenkomst: zodra het blok in beeld komt (x-intersect zet data-shown, net als bij Nieuws) schuiven de onderwerpen
     één voor één omhoog en daarna het inhoudsvlak; bij "minder beweging" staat alles meteen stil. ── --}}
{{-- Per onderwerp een rubriekskleur (Over de school, Leerlingen & ouders, Groep 8, Beleid & documenten, Ons onderwijs):
     voor het bolletje, de titel bij hover en het pijltje links, en in het inhoudsvlak de titel en de opsommingsbolletjes
     (vette tekst en tussenkoppen blijven navy). Vanaf lg krijgen het inhoudsvlak en het actieve tabblad een lichte tint van die kleur ('vlak'),
     zodat het hele blok van sfeer wisselt. Klassen voluit, zodat Tailwind ze vindt. --}}
@php
  $kleuren = [
    ['bg' => 'bg-triv-hemelblauw', 'tekst' => 'text-triv-hemelblauw', 'hover' => 'group-hover:text-triv-hemelblauw', 'bolletje' => 'before:bg-triv-hemelblauw', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-hemelblauw)_11%,white)]'],
    ['bg' => 'bg-triv-oudroze', 'tekst' => 'text-triv-oudroze', 'hover' => 'group-hover:text-triv-oudroze', 'bolletje' => 'before:bg-triv-oudroze', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-oudroze)_11%,white)]'],
    ['bg' => 'bg-triv-koraal', 'tekst' => 'text-triv-koraal', 'hover' => 'group-hover:text-triv-koraal', 'bolletje' => 'before:bg-triv-koraal', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-koraal)_11%,white)]'],
    ['bg' => 'bg-triv-zeegroen', 'tekst' => 'text-triv-zeegroen', 'hover' => 'group-hover:text-triv-zeegroen', 'bolletje' => 'before:bg-triv-zeegroen', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-zeegroen)_11%,white)]'],
    ['bg' => 'bg-triv-paars', 'tekst' => 'text-triv-paars', 'hover' => 'group-hover:text-triv-paars', 'bolletje' => 'before:bg-triv-paars', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-paars)_11%,white)]'],
    ['bg' => 'bg-triv-lightblue', 'tekst' => 'text-triv-lightblue', 'hover' => 'group-hover:text-triv-lightblue', 'bolletje' => 'before:bg-triv-lightblue', 'vlak' => 'lg:bg-[color-mix(in_oklab,var(--color-triv-lightblue)_11%,white)]'],
  ];
  $rijen = count($onderwerpen);
@endphp

<section class="relative z-20 -mt-[8vh]">
  {{-- Golfboog direct over de hero-foto: de section zelf heeft hier geen achtergrond, zodat er contrast is --}}
  @include('components.wave-divider', ['fill' => '#fbfaf4'])

  <div class="bg-triv-cream pt-16 pb-20">
    <div class="page-container">
      @if($onderwerpen)
        {{-- Desktop: klik kiest een ander onderwerp (er staat er altijd één open); mobiel: klik klapt open of dicht.
             Wordt het scherm breder terwijl alles dicht is, dan gaat het eerste weer open. --}}
        <div x-data="{ actief: 0, ankers: {{ Js::from(array_column($onderwerpen, 'anker')) }}, lg: () => window.matchMedia('(min-width: 1024px)').matches, init() { this.volgHash() }, volgHash() { const i = this.ankers.indexOf(decodeURIComponent(location.hash.slice(1))); if (i > -1) this.actief = i }, kies(i) { this.actief = (this.actief === i && ! this.lg()) ? null : i; if (this.actief !== null) history.replaceState(null, '', '#' + this.ankers[i]) }, naar(i) { const n = (i + this.ankers.length) % this.ankers.length; document.getElementById('lef-knop-' + n).focus(); if (this.lg()) this.kies(n) } }"
          @resize.window.debounce.150ms="if (actief === null && lg()) actief = 0"
          @hashchange.window="volgHash()"
          x-intersect.once.margin.0.0.-20%.0="$el.dataset.shown = ''"
          class="group/lef flex flex-col gap-3 lg:grid lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:gap-x-10 lg:gap-y-4 lg:items-start"
          style="grid-template-rows: repeat({{ $rijen }}, auto) 1fr;">

          @foreach ($onderwerpen as $i => $item)
            @php($kleur = $kleuren[$i % count($kleuren)])
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
                <span aria-hidden="true" class="{{ $kleur['bg'] }} size-10 shrink-0 rounded-full flex items-center justify-center text-white font-black text-base">
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
              class="rounded-xl bg-white {{ $kleur['vlak'] }} p-5 shadow-sm sm:p-7 lg:col-start-2 lg:row-start-1 lg:p-0 {{ $item['foto'] ? 'lg:grid lg:grid-cols-[minmax(0,1fr)_minmax(0,0.75fr)] lg:grid-rows-[auto_1fr] lg:overflow-hidden' : '' }} lg:translate-y-6 lg:opacity-0 lg:transition-[translate,opacity] lg:duration-700 lg:delay-300 lg:ease-[cubic-bezier(.2,.8,.2,1)] lg:group-data-shown/lef:translate-y-0 lg:group-data-shown/lef:opacity-100 lg:motion-reduce:translate-y-0 lg:motion-reduce:opacity-100 lg:motion-reduce:transition-none"
              style="grid-row-end: span {{ $rijen + 1 }};{{ $i > 0 ? ' display: none;' : '' }}">

              {{-- Bij wisselen van onderwerp schuift de tekst zacht omhoog en komt de foto in beeld: een CSS-animatie start
                   opnieuw zodra x-show het paneel weer toont (display: none → block). Keyframes uit app.css (fotoheader). --}}
              {{-- Titel en intro alleen vanaf lg (op mobiel staan ze al in de knop); bij een foto in de linkerkolom, naast de foto --}}
              <div class="hidden lg:col-start-1 lg:row-start-1 lg:block lg:px-10 lg:pt-10 lg:pb-8 lg:animate-[hero-rise_500ms_cubic-bezier(.2,.8,.2,1)_both] motion-reduce:animate-none">
                <p class="mb-2 font-['Poppins',sans-serif] text-3xl font-bold leading-tight {{ $kleur['tekst'] }}">{{ $item['titel'] }}</p>
                @if($item['intro'])
                  <p class="mb-0 text-lg leading-relaxed text-stone-600">{{ $item['intro'] }}</p>
                @endif
              </div>

              {{-- Met foto: vanaf lg is het vlak een grid met onder de titel de tekst links en rechts de foto, die van boven tot onder
                   tegen de rand van het vlak loopt (het vlak zelf heeft dan geen padding, titel en tekst wel); op mobiel de foto erboven --}}
              @if($item['foto'])
                <div class="relative mb-6 aspect-4/3 overflow-hidden rounded-xl lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:mb-0 lg:aspect-auto lg:min-h-80 lg:rounded-none lg:animate-[hero-photo_700ms_ease-out_both] motion-reduce:animate-none">
                {!! wp_get_attachment_image($item['foto'], 'large', false, [
                  'class' => 'absolute inset-0 size-full max-w-none object-cover object-[45%_35%] lg:object-[50%_40%]',
                  'sizes' => '(min-width: 1024px) 600px, 100vw',
                  'loading' => 'lazy',
                  'decoding' => 'async',
                ]) !!}
                </div>
              @endif

              <div class="lg:col-start-1 lg:row-start-2 lg:px-10 lg:pb-10">

              @if($item['blokken'])
                <div class="flex flex-col gap-6 text-sm sm:text-base lg:animate-[hero-rise_500ms_100ms_cubic-bezier(.2,.8,.2,1)_both] motion-reduce:animate-none">
                  @foreach($item['blokken'] as $blok)
                    @if($blok['type'] === 'lijst')
                      <ul @class(['mb-0 grid gap-x-10 gap-y-5', 'md:grid-cols-2' => ! $item['foto']])>
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
                        @if(! $item['foto'] && str_contains(mb_strtolower($item['titel']), 'op maat') && count($blok['punten']) % 2)
                          <li aria-hidden="true" class="mb-0 hidden items-center justify-center md:flex">
                            <span x-data="{ shown: false }" x-intersect="shown = true" x-intersect:leave="shown = false" :data-shown="shown" class="block w-full max-w-60">
                              <x-icon name="meetlint" class="h-auto w-full text-triv-navy" />
                            </span>
                          </li>
                        @endif
                      </ul>
                    @elseif($blok['type'] === 'kop')
                      <div>
                        <h3 class="mb-1 text-base font-semibold text-triv-navy sm:text-lg">{{ $blok['kop'] }}</h3>
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

        </div>
      @endif
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
