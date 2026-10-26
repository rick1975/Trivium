{{-- ── LEREN MET LEF (TESTVERSIE 2, te zien via /?lef-test=2) — zelfde gegevens als components/leren-met-lef (Composers\LerenMetLef).
     Concept "alles in één oogopslag": de onderwerpen als tegels in één raster (vanaf lg één grote tegel links en vier kleinere
     ernaast, op mobiel de eerste breed en de rest twee aan twee). Elke tegel: beeld (foto, anders het beeld van de video, anders
     de onderwerpkleur) met een groot cijfer erover, titel (en bij de grote tegel de intro), en twee aparte knoppen: "Video" (venster in het midden,
     speelt meteen, stopt bij sluiten) en "Lees meer" (de volledige tekst schuift als paneel van rechts in beeld, zoals het menu).
     Een klik elders op de tegel doet hetzelfde als de eerste knop (video, of zonder video de tekst). ── --}}
@php
  $kleuren = [
    ['tekst' => 'text-triv-hemelblauw', 'vlak' => 'bg-triv-hemelblauw', 'bolletje' => 'before:bg-triv-hemelblauw'],
    ['tekst' => 'text-triv-oudroze', 'vlak' => 'bg-triv-oudroze', 'bolletje' => 'before:bg-triv-oudroze'],
    ['tekst' => 'text-triv-koraal', 'vlak' => 'bg-triv-koraal', 'bolletje' => 'before:bg-triv-koraal'],
    ['tekst' => 'text-triv-zeegroen', 'vlak' => 'bg-triv-zeegroen', 'bolletje' => 'before:bg-triv-zeegroen'],
    ['tekst' => 'text-triv-paars', 'vlak' => 'bg-triv-paars', 'bolletje' => 'before:bg-triv-paars'],
    ['tekst' => 'text-triv-lightblue', 'vlak' => 'bg-triv-lightblue', 'bolletje' => 'before:bg-triv-lightblue'],
  ];
@endphp

<section class="relative z-20 -mt-[7vh]">
  @include('components.wave-divider', ['fill' => '#fbfaf4'])

  <div class="bg-triv-cream pt-12 pb-20" x-data="{ video: null, lees: null }">
    <div class="page-container">
      @if($onderwerpen)
        <ul class="mb-0 grid list-none grid-cols-2 gap-3 pl-0 sm:gap-4 lg:h-[min(40rem,calc(100vh-8rem))] lg:grid-cols-4 lg:grid-rows-2">
          @foreach ($onderwerpen as $i => $item)
            @php($kleur = $kleuren[$i % count($kleuren)])
            @php($actie = $item['video'] ? "video = {$i}" : "lees = {$i}")
            <li id="{{ $item['anker'] }}" @class(['group relative mb-0 flex scroll-mt-6 flex-col justify-end overflow-hidden rounded-2xl shadow-sm sm:rounded-3xl', $kleur['vlak'], 'col-span-2 aspect-video lg:row-span-2 lg:aspect-auto' => $i === 0, 'aspect-3/4 sm:aspect-4/3 lg:aspect-auto' => $i > 0])>

              {{-- Beeld, zoomt licht in bij hover --}}
              @if($item['foto'] || ($item['video']['beeld'] ?? null))
                <span class="absolute inset-0 transition-transform duration-700 ease-out group-hover:scale-105 motion-reduce:transition-none">
                  @if($item['foto'])
                    {!! wp_get_attachment_image($item['foto'], 'large', false, [
                      'class' => 'absolute inset-0 size-full max-w-none object-cover object-[50%_35%]',
                      'sizes' => $i === 0 ? '(min-width: 1024px) 640px, 100vw' : '(min-width: 1024px) 320px, 50vw',
                      'loading' => 'lazy',
                      'decoding' => 'async',
                      'alt' => '',
                    ]) !!}
                  @else
                    <img src="{{ $item['video']['beeld'] }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full max-w-none object-cover"
                      @if($item['video']['reserve']) onerror="this.onerror = null; this.src = '{{ $item['video']['reserve'] }}'" @endif>
                  @endif
                </span>
                {{-- Verloop onderin, zodat de witte tekst altijd leesbaar is --}}
                <span aria-hidden="true" class="absolute inset-0 bg-linear-to-t from-triv-navy/90 via-triv-navy/35 via-45% to-transparent"></span>
              @endif

              {{-- Groot cijfer: bij de grote tegel rechtsboven, bij de andere rechtsonder (achter de tekst); over een foto iets sterker, met een zachte schaduw --}}
              <span aria-hidden="true" @class(['pointer-events-none absolute font-[\'Poppins\',sans-serif] font-black leading-none', 'text-white/20' => ! $item['foto'] && ! ($item['video']['beeld'] ?? null), 'text-white/45 [text-shadow:0_4px_40px_rgb(11_31_58/0.25)]' => $item['foto'] || ($item['video']['beeld'] ?? null), 'top-4 right-5 text-[6rem] lg:top-6 lg:right-8 lg:text-[9rem]' => $i === 0, 'right-4 bottom-3 text-[2.75rem] lg:right-5 lg:bottom-4 lg:text-[3.5rem]' => $i > 0])>{{ $i + 1 }}</span>

              {{-- De hele tegel is klikbaar (video, of zonder video de tekst); voor toetsenbord en schermlezer tellen de knoppen onderin --}}
              <button type="button" @click="{{ $actie }}" tabindex="-1" aria-hidden="true" class="absolute inset-0 size-full cursor-pointer"></button>

              {{-- Grote tegel vanaf lg: afspeelknop in het midden --}}
              @if($i === 0 && $item['video'])
                <span aria-hidden="true" class="{{ $kleur['tekst'] }} pointer-events-none absolute top-1/2 left-1/2 hidden size-24 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white/95 shadow-lg ring-8 ring-white/30 transition-transform duration-300 ease-[cubic-bezier(.34,1.56,.64,1)] group-hover:scale-110 motion-reduce:transition-none lg:flex">
                  <x-icon name="play" class="size-10" />
                </span>
              @endif

              {{-- Kleine tegels: ruimte rechts voor het cijfer, zodat de tekst er niet overheen loopt --}}
              <div @class(['pointer-events-none relative flex flex-col gap-1.5 p-4 sm:p-5 lg:p-6', 'pr-10 sm:pr-12 lg:pr-16' => $i > 0])>
                <h2 @class(['mb-0 font-[\'Poppins\',sans-serif] font-bold leading-tight text-white', 'text-2xl lg:text-4xl' => $i === 0, 'text-base sm:text-lg lg:text-xl' => $i > 0])>{{ $item['titel'] }}</h2>
                {{-- Intro alleen in de grote tegel; bij de kleine staat hij in het tekstpaneel --}}
                @if($item['intro'] && $i === 0)
                  <p class="mb-0 text-base leading-snug text-white/85 lg:max-w-md lg:text-lg">{{ $item['intro'] }}</p>
                @endif
                <div class="pointer-events-auto mt-2 flex flex-wrap items-center gap-x-4 gap-y-2">
                  @if($item['video'])
                    <button type="button" @click="video = {{ $i }}" aria-haspopup="dialog" aria-label="Bekijk de video: {{ $item['titel'] }}"
                      class="inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-white py-1.5 pr-3.5 pl-2.5 text-sm font-semibold text-triv-navy shadow-sm transition-transform hover:scale-105 motion-reduce:transition-none">
                      <x-icon name="play" :size="14" class="{{ $kleur['tekst'] }}" /> Video
                      @if($item['video']['duur'])<span class="font-normal text-stone-500">{{ $item['video']['duur'] }}</span>@endif
                    </button>
                  @endif
                  @if($item['blokken'])
                    <button type="button" @click="lees = {{ $i }}" aria-haspopup="dialog" aria-label="Lees meer: {{ $item['titel'] }}"
                      class="inline-flex cursor-pointer items-center gap-1 text-sm font-semibold text-white underline decoration-white/50 decoration-2 underline-offset-4 transition-colors hover:decoration-white">
                      Lees meer <x-icon name="chevron-right" class="size-2.5 stroke-[2.5]" />
                    </button>
                  @endif
                </div>
              </div>
            </li>
          @endforeach
        </ul>

        {{-- Videovenster: pas geladen als het open is, stopt bij sluiten (naar de body verplaatst, zodat het boven alles ligt) --}}
        <template x-teleport="body">
          <div x-show="video !== null" x-transition.opacity.duration.300ms x-trap.inert.noscroll="video !== null"
            @keydown.escape.window="video = null" @click.self="video = null" role="dialog" aria-modal="true" aria-label="Video"
            class="fixed inset-0 z-60 flex items-center justify-center bg-triv-navy/90 p-4 backdrop-blur-sm sm:p-10" style="display: none;">
            <div class="relative w-full max-w-5xl">
              <button type="button" @click="video = null" aria-label="Video sluiten"
                class="absolute right-0 -top-12 flex size-10 cursor-pointer items-center justify-center rounded-full text-white/80 transition-colors hover:bg-white/10 hover:text-white">
                <x-icon name="close" :size="18" />
              </button>
              <div class="aspect-video overflow-hidden rounded-xl bg-black shadow-2xl">
                @foreach ($onderwerpen as $i => $item)
                  @if($item['video'])
                    <template x-if="video === {{ $i }}">
                      <iframe src="{{ $item['video']['embed'] }}" title="{{ $item['titel'] }}" class="size-full" allow="autoplay; fullscreen; picture-in-picture; encrypted-media" allowfullscreen></iframe>
                    </template>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </template>

        {{-- Tekstpaneel: schuift van rechts in beeld (mobiel volledig scherm, desktop zwevend paneel rechts zoals het menu).
             De breedte hangt af van de hoeveelheid tekst: weinig tekst → even breed als het menu; veel tekst → breder, met de
             opsomming in twee kolommen, zodat de tekst zonder scrollen in beeld past.
             Bovenin een vlak in de onderwerpkleur met de titel. --}}
        <template x-teleport="body">
          <div>
            <div x-show="lees !== null" x-transition.opacity.duration.300ms @click="lees = null" aria-hidden="true"
              class="fixed inset-0 z-60 bg-triv-navy/40 backdrop-blur-sm" style="display: none;"></div>
            @foreach ($onderwerpen as $i => $item)
              @php($kleur = $kleuren[$i % count($kleuren)])
              @php($breed = collect($item['blokken'])->sum(fn ($b) => mb_strlen(($b['kop'] ?? '').($b['tekst'] ?? '').collect($b['punten'] ?? [])->map(fn ($p) => $p['kop'].$p['tekst'])->implode(''))) > 650)
              <div x-show="lees === {{ $i }}" x-trap.inert.noscroll="lees === {{ $i }}" @keydown.escape.window="lees = null"
                x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-x-12" x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-12"
                role="dialog" aria-modal="true" aria-labelledby="lef-lees-{{ $i }}"
                @class(['fixed inset-0 z-60 flex flex-col overflow-hidden bg-white shadow-2xl lg:inset-auto lg:top-3 lg:right-3 lg:bottom-3 lg:rounded-3xl', 'lg:w-[min(56rem,calc(100vw-1.5rem))]' => $breed, 'lg:w-[440px]' => ! $breed]) style="display: none;">
                <div class="{{ $kleur['vlak'] }} relative shrink-0 overflow-hidden px-6 pt-16 pb-6 sm:px-10 lg:pt-10 lg:pr-20">
                  <button type="button" @click="lees = null" aria-label="Sluiten"
                    class="absolute top-4 right-4 flex size-9 cursor-pointer items-center justify-center rounded-full bg-white text-stone-500 transition-all duration-300 hover:rotate-90 hover:text-triv-navy">
                    <x-icon name="close" />
                  </button>
                  <p id="lef-lees-{{ $i }}" class="relative mb-2 font-['Poppins',sans-serif] text-2xl font-bold leading-tight text-white sm:text-3xl">{{ $item['titel'] }}</p>
                  @if($item['intro'])
                    <p class="relative mb-0 text-lg leading-relaxed text-white/90">{{ $item['intro'] }}</p>
                  @endif
                  @if($item['video'])
                    <button type="button" @click="lees = null; video = {{ $i }}"
                      class="relative mt-5 inline-flex cursor-pointer items-center gap-1.5 rounded-full bg-white py-2 pr-4 pl-3 text-sm font-semibold text-triv-navy shadow-sm transition-transform hover:scale-105 motion-reduce:transition-none">
                      <x-icon name="play" :size="14" class="{{ $kleur['tekst'] }}" /> Bekijk de video
                      @if($item['video']['duur'])<span class="font-normal text-stone-500">{{ $item['video']['duur'] }}</span>@endif
                    </button>
                  @endif
                </div>
                <div class="flex flex-1 flex-col gap-5 overflow-y-auto px-6 py-8 text-base sm:px-10 lg:py-10">
                  @foreach($item['blokken'] as $blok)
                    @if($blok['type'] === 'lijst')
                      <ul @class(['mb-0 grid gap-x-10 gap-y-5 pl-0', 'lg:grid-cols-2' => $breed])>
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
