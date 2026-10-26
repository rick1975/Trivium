{{-- ── LEREN MET LEF (TESTVERSIE, te zien via /?lef-test) — zelfde gegevens als components/leren-met-lef (Composers\LerenMetLef).
     Concept "vijf keer lef": elk onderwerp is een grote kaart met de video als hoofdzaak. Vanaf lg stapelen de kaarten bij
     het scrollen op elkaar (sticky, elke volgende iets lager, zodat de randen van de vorige zichtbaar blijven); op mobiel
     gewoon onder elkaar. De kaart toont titel, intro en video (speelt in de kaart zelf af na een klik); de volledige tekst
     staat achter "Lees meer" in een venster. Zonder video de foto, zonder beide het grote cijfer. ── --}}
@php
  $kleuren = [
    ['tekst' => 'text-triv-hemelblauw', 'knop' => 'bg-triv-hemelblauw', 'bolletje' => 'before:bg-triv-hemelblauw', 'vlak' => 'bg-[color-mix(in_oklab,var(--color-triv-hemelblauw)_16%,white)]'],
    ['tekst' => 'text-triv-oudroze', 'knop' => 'bg-triv-oudroze', 'bolletje' => 'before:bg-triv-oudroze', 'vlak' => 'bg-[color-mix(in_oklab,var(--color-triv-oudroze)_16%,white)]'],
    ['tekst' => 'text-triv-koraal', 'knop' => 'bg-triv-koraal', 'bolletje' => 'before:bg-triv-koraal', 'vlak' => 'bg-[color-mix(in_oklab,var(--color-triv-koraal)_16%,white)]'],
    ['tekst' => 'text-triv-zeegroen', 'knop' => 'bg-triv-zeegroen', 'bolletje' => 'before:bg-triv-zeegroen', 'vlak' => 'bg-[color-mix(in_oklab,var(--color-triv-zeegroen)_16%,white)]'],
    ['tekst' => 'text-triv-paars', 'knop' => 'bg-triv-paars', 'bolletje' => 'before:bg-triv-paars', 'vlak' => 'bg-[color-mix(in_oklab,var(--color-triv-paars)_16%,white)]'],
    ['tekst' => 'text-triv-lightblue', 'knop' => 'bg-triv-lightblue', 'bolletje' => 'before:bg-triv-lightblue', 'vlak' => 'bg-[color-mix(in_oklab,var(--color-triv-lightblue)_16%,white)]'],
  ];
@endphp

<section class="relative z-20 -mt-[7vh]">
  @include('components.wave-divider', ['fill' => '#fbfaf4'])

  <div class="bg-triv-cream pt-12 pb-20 lg:pb-[10vh]" x-data="{ lees: null }">
    <div class="page-container">
      @if($onderwerpen)
        <p class="mb-8 text-sm font-semibold uppercase tracking-wider text-stone-500 lg:mb-10">Leren met lef in {{ count($onderwerpen) }} filmpjes</p>

        <ol class="mb-0 flex list-none flex-col gap-6 pl-0 lg:gap-[12vh]">
          @foreach ($onderwerpen as $i => $item)
            @php($kleur = $kleuren[$i % count($kleuren)])
            <li id="{{ $item['anker'] }}" class="mb-0 scroll-mt-6 lg:sticky" style="top: calc(6rem + {{ $i }} * 1.25rem);">
              <article x-data="{ speelt: false }"
                class="{{ $kleur['vlak'] }} grid overflow-hidden rounded-3xl shadow-[0_-8px_30px_-12px_rgb(11_31_58/0.25)] lg:h-[min(34rem,calc(100vh-10rem))] lg:grid-cols-[minmax(0,1fr)_minmax(0,1.35fr)]">

                {{-- Tekstkant: groot cijfer, titel, intro en de knoppen --}}
                <div class="relative order-2 flex flex-col justify-end p-6 sm:p-8 lg:order-1 lg:p-12">
                  <span aria-hidden="true" class="{{ $kleur['tekst'] }} pointer-events-none absolute hidden lg:block font-['Poppins',sans-serif] text-[7rem] font-black leading-none opacity-20 lg:top-6 lg:left-10 lg:text-[11rem]">{{ $i + 1 }}</span>
                  <h2 class="{{ $kleur['tekst'] }} relative mb-3 font-['Poppins',sans-serif] text-3xl font-bold leading-tight lg:text-4xl">{{ $item['titel'] }}</h2>
                  @if($item['intro'])
                    <p class="relative mb-6 text-lg leading-relaxed text-stone-700">{{ $item['intro'] }}</p>
                  @endif
                  <div class="relative flex flex-wrap items-center gap-x-6 gap-y-3">
                    @if($item['video'])
                      <button type="button" @click="speelt = true"
                        class="{{ $kleur['knop'] }} inline-flex cursor-pointer items-center gap-2.5 rounded-full py-3 pr-5 pl-4 font-semibold text-white shadow-sm transition-transform hover:scale-105 motion-reduce:transition-none">
                        <x-icon name="play" :size="18" /> Bekijk de video
                        @if($item['video']['duur'])<span class="font-normal text-white/75">{{ $item['video']['duur'] }}</span>@endif
                      </button>
                    @endif
                    @if($item['blokken'])
                      <button type="button" @click="lees = {{ $i }}" aria-haspopup="dialog"
                        class="inline-flex cursor-pointer items-center gap-1.5 font-semibold text-triv-navy underline decoration-2 underline-offset-4 hover:decoration-current {{ $kleur['tekst'] }}">
                        <span class="text-triv-navy">Lees meer</span> <x-icon name="chevron-right" class="size-3 stroke-[2.5]" />
                      </button>
                    @endif
                  </div>
                </div>

                {{-- Beeldkant: video (na de klik in de kaart zelf), anders de foto, anders niets (dan is het cijfer het beeld) --}}
                <div class="relative order-1 aspect-video overflow-hidden bg-triv-navy lg:order-2 lg:aspect-auto">
                  @if($item['video'])
                    <template x-if="speelt">
                      <iframe src="{{ $item['video']['embed'] }}" title="{{ $item['titel'] }}" class="absolute inset-0 size-full" allow="autoplay; fullscreen; picture-in-picture; encrypted-media" allowfullscreen></iframe>
                    </template>
                  @endif
                  <div x-show="! speelt" class="absolute inset-0">
                    @if($item['foto'])
                      {!! wp_get_attachment_image($item['foto'], 'large', false, [
                        'class' => 'absolute inset-0 size-full max-w-none object-cover object-[50%_40%]',
                        'sizes' => '(min-width: 1024px) 700px, 100vw',
                        'loading' => 'lazy',
                        'decoding' => 'async',
                      ]) !!}
                    @elseif($item['video']['beeld'] ?? null)
                      <img src="{{ $item['video']['beeld'] }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full max-w-none object-cover"
                        @if($item['video']['reserve']) onerror="this.onerror = null; this.src = '{{ $item['video']['reserve'] }}'" @endif>
                    @else
                      <span aria-hidden="true" class="{{ $kleur['knop'] }} absolute inset-0 flex items-center justify-center font-['Poppins',sans-serif] text-[14rem] font-black leading-none text-white/25">{{ $i + 1 }}</span>
                    @endif
                    @if($item['video'])
                      <button type="button" @click="speelt = true" aria-label="Bekijk de video: {{ $item['titel'] }}"
                        class="group/video absolute inset-0 flex size-full cursor-pointer items-center justify-center bg-triv-navy/10 transition-colors duration-300 hover:bg-triv-navy/25">
                        <span class="{{ $kleur['tekst'] }} flex size-20 items-center justify-center rounded-full bg-white/95 shadow-lg ring-8 ring-white/30 transition-transform duration-300 ease-[cubic-bezier(.34,1.56,.64,1)] group-hover/video:scale-110 motion-reduce:transition-none lg:size-24">
                          <x-icon name="play" class="size-8 lg:size-10" />
                        </span>
                      </button>
                    @endif
                  </div>
                </div>
              </article>
            </li>
          @endforeach
        </ol>

        {{-- Volledige tekst per onderwerp in een venster (naar de body verplaatst, zodat het boven de sticky kaarten ligt) --}}
        <template x-teleport="body">
          <div x-show="lees !== null" x-transition.opacity.duration.300ms x-trap.inert.noscroll="lees !== null"
            @keydown.escape.window="lees = null" @click.self="lees = null" role="dialog" aria-modal="true"
            class="fixed inset-0 z-60 flex items-end justify-center bg-triv-navy/60 backdrop-blur-sm sm:items-center sm:p-8" style="display: none;">
            @foreach ($onderwerpen as $i => $item)
              @php($kleur = $kleuren[$i % count($kleuren)])
              <div x-show="lees === {{ $i }}" class="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-t-3xl bg-white p-6 shadow-2xl sm:rounded-3xl sm:p-10">
                <button type="button" @click="lees = null" aria-label="Sluiten"
                  class="absolute top-4 right-4 flex size-10 cursor-pointer items-center justify-center rounded-full text-triv-navy transition-colors hover:bg-stone-100">
                  <x-icon name="close" :size="16" />
                </button>
                <p class="{{ $kleur['tekst'] }} mb-2 pr-10 font-['Poppins',sans-serif] text-2xl font-bold leading-tight sm:text-3xl">{{ $item['titel'] }}</p>
                @if($item['intro'])
                  <p class="mb-6 text-lg leading-relaxed text-stone-600">{{ $item['intro'] }}</p>
                @endif
                <div class="flex flex-col gap-5 text-base">
                  @foreach($item['blokken'] as $blok)
                    @if($blok['type'] === 'lijst')
                      <ul class="mb-0 grid gap-4 pl-0">
                        @foreach($blok['punten'] as $punt)
                          <li class="relative mb-0 list-none pl-5 before:absolute before:left-0 before:top-[0.55em] before:size-2 before:rounded-full {{ $kleur['bolletje'] }}">
                            <span @class(['block', 'font-semibold text-triv-navy' => $punt['vet'], 'text-stone-600' => ! $punt['vet']])>{{ $punt['kop'] }}</span>
                            @if($punt['tekst'])
                              <span class="mt-1 block text-stone-600">{{ $punt['tekst'] }}</span>
                            @endif
                          </li>
                        @endforeach
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
              </div>
            @endforeach
          </div>
        </template>
      @endif
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
