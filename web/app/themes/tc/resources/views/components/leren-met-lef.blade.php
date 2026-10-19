{{-- ── LEREN MET LEF — onderwerpen uit Trivium Settings > Leren met lef (Composers\LerenMetLef, die de content ook opdeelt in blokken).
     Vanaf lg tabbladen: links de genummerde titels, rechts de inhoud van het gekozen onderwerp (één vast vlak, dus niets verspringt).
     Op mobiel dezelfde markup als uitklaplijst: knop met titel en korte intro, de inhoud klapt eronder open.
     Eén grid voor beide: de knoppen vullen kolom 1 van boven naar beneden, alle panelen liggen in kolom 2 over elkaar
     (over alle rijen plus een laatste 1fr-rij die de extra hoogte opvangt) en alleen het actieve is zichtbaar.
     Het eerste onderwerp staat standaard open. ── --}}
@php
  $kleuren = ['bg-triv-blue', 'bg-triv-pink', 'bg-triv-orange', 'bg-triv-green', 'bg-triv-yellow', 'bg-triv-lightblue'];
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
        <div x-data="{ actief: 0, lg: () => window.matchMedia('(min-width: 1024px)').matches }"
          @resize.window.debounce.150ms="if (actief === null && lg()) actief = 0"
          class="flex flex-col gap-3 lg:grid lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:gap-x-10 lg:gap-y-2 lg:items-start"
          style="grid-template-rows: repeat({{ $rijen }}, auto) 1fr;">

          @foreach ($onderwerpen as $i => $item)
            {{-- Titel + knop (kolom 1). Titels zijn h2, direct onder de h1 "Leren met Lef" in de hero --}}
            <h2 class="mb-0 lg:col-start-1">
              <button type="button" id="lef-knop-{{ $i }}" aria-controls="lef-paneel-{{ $i }}"
                aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" :aria-expanded="(actief === {{ $i }}).toString()"
                class="group flex w-full items-start gap-4 rounded-xl p-4 lg:p-3 text-left cursor-pointer transition-all duration-300"
                :class="actief === {{ $i }} ? 'bg-white' : 'bg-white lg:bg-transparent lg:hover:bg-white/70'"
                @click="actief = (actief === {{ $i }} && ! lg()) ? null : {{ $i }}">
                <span aria-hidden="true" class="{{ $kleuren[$i % count($kleuren)] }} size-10 shrink-0 rounded-full flex items-center justify-center text-white font-black text-base">
                  {{ $i + 1 }}
                </span>
                <span class="flex-1 self-center">
                  <span class="block text-lg font-bold leading-snug text-triv-navy transition-colors group-hover:text-triv-pink">{{ $item['titel'] }}</span>
                  @if($item['intro'])
                    <span class="mt-1 block text-sm font-normal leading-relaxed text-stone-600 lg:hidden">{{ $item['intro'] }}</span>
                  @endif
                </span>
                {{-- Pijltje: mobiel draait het bij openklappen, vanaf lg schuift het iets op richting het inhoudsvlak --}}
                <span aria-hidden="true" class="mt-3.5 shrink-0 text-triv-pink transition-transform duration-300"
                  :class="actief === {{ $i }} ? 'rotate-90 lg:rotate-0 lg:translate-x-1' : ''">
                  <x-icon name="chevron-right" class="size-3 stroke-[2.5]" />
                </span>
              </button>
            </h2>

            {{-- Inhoud (kolom 2, alle panelen op dezelfde plek) --}}
            <div id="lef-paneel-{{ $i }}" role="region" aria-labelledby="lef-knop-{{ $i }}" x-show="actief === {{ $i }}"
              class="rounded-xl bg-white p-5 shadow-sm sm:p-7 lg:col-start-2 lg:row-start-1 lg:p-10"
              style="grid-row-end: span {{ $rijen + 1 }};{{ $i > 0 ? ' display: none;' : '' }}">

              {{-- Titel en intro alleen vanaf lg (op mobiel staan ze al in de knop) --}}
              <div class="mb-8 hidden lg:block">
                <p class="mb-2 font-['Poppins',sans-serif] text-3xl font-bold leading-tight text-triv-navy">{{ $item['titel'] }}</p>
                @if($item['intro'])
                  <p class="mb-0 text-lg leading-relaxed text-stone-600">{{ $item['intro'] }}</p>
                @endif
              </div>

              @if($item['blokken'])
                <div class="flex flex-col gap-6 text-sm sm:text-base">
                  @foreach($item['blokken'] as $blok)
                    @if($blok['type'] === 'lijst')
                      <ul class="mb-0 grid gap-x-10 gap-y-5 md:grid-cols-2">
                        @foreach($blok['punten'] as $punt)
                          <li class="relative mb-0 pl-5 before:absolute before:left-0 before:top-[0.55em] before:size-2 before:rounded-full before:bg-triv-pink">
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
          @endforeach

        </div>
      @endif
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
