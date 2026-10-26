{{-- ── LEREN MET LEF (TESTVERSIE 2, te zien via /?lef-test=2) — zelfde gegevens als components/leren-met-lef (Composers\LerenMetLef).
     Concept "alles in één oogopslag": de onderwerpen als tegels in één raster (vanaf lg één grote tegel links en vier kleinere
     ernaast, op mobiel de eerste breed en de rest twee aan twee). Elke tegel: beeld (foto, anders het beeld van de video, anders
     de onderwerpkleur), genummerd bolletje, titel en intro; met een video een afspeelknop. Een klik opent een venster met
     bovenin de video (speelt meteen) en daaronder de volledige tekst, dus video en tekst blijven bij elkaar. ── --}}
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

  <div class="bg-triv-cream pt-12 pb-20" x-data="{ open: null }">
    <div class="page-container">
      @if($onderwerpen)
        <p class="mb-8 text-sm font-semibold uppercase tracking-wider text-stone-500">Leren met lef in {{ count($onderwerpen) }} filmpjes</p>

        <ul class="mb-0 grid list-none grid-cols-2 gap-3 pl-0 sm:gap-4 lg:h-[min(40rem,calc(100vh-8rem))] lg:grid-cols-4 lg:grid-rows-2">
          @foreach ($onderwerpen as $i => $item)
            @php($kleur = $kleuren[$i % count($kleuren)])
            <li id="{{ $item['anker'] }}" @class(['mb-0 scroll-mt-6', 'col-span-2 lg:row-span-2' => $i === 0])>
              <button type="button" @click="open = {{ $i }}" aria-haspopup="dialog"
                @class(['group relative flex size-full cursor-pointer flex-col justify-end overflow-hidden rounded-2xl text-left shadow-sm sm:rounded-3xl', $kleur['vlak'], 'aspect-video lg:aspect-auto' => $i === 0, 'aspect-3/4 sm:aspect-4/3 lg:aspect-auto' => $i > 0])>

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
                @else
                  <span aria-hidden="true" class="absolute -top-6 -right-2 font-['Poppins',sans-serif] text-[9rem] font-black leading-none text-white/20 lg:text-[11rem]">{{ $i + 1 }}</span>
                @endif

                {{-- Afspeelknop rechtsboven (grote tegel vanaf lg: in het midden) --}}
                @if($item['video'])
                  <span aria-hidden="true" @class(['absolute flex items-center justify-center rounded-full bg-white/95 shadow-lg ring-white/30 transition-transform duration-300 ease-[cubic-bezier(.34,1.56,.64,1)] group-hover:scale-110 motion-reduce:transition-none', $kleur['tekst'], 'top-3 right-3 size-11 ring-4 lg:top-1/2 lg:right-auto lg:left-1/2 lg:size-24 lg:-translate-x-1/2 lg:-translate-y-1/2 lg:ring-8' => $i === 0, 'top-3 right-3 size-11 ring-4 lg:top-4 lg:right-4' => $i > 0])>
                    <x-icon name="play" @class(['size-5 lg:size-10' => $i === 0, 'size-5' => $i > 0]) />
                  </span>
                @endif

                <span class="relative flex flex-col gap-1.5 p-4 sm:p-5 lg:p-6">
                  <span class="flex items-center gap-2.5">
                    <span aria-hidden="true" class="{{ $kleur['vlak'] }} flex size-7 shrink-0 items-center justify-center rounded-full text-sm font-black text-white ring-2 ring-white/70">{{ $i + 1 }}</span>
                    @if($item['video']['duur'] ?? null)
                      <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs font-semibold text-white backdrop-blur-sm">{{ $item['video']['duur'] }}</span>
                    @endif
                  </span>
                  <span @class(['block font-[\'Poppins\',sans-serif] font-bold leading-tight text-white', 'text-2xl lg:text-4xl' => $i === 0, 'text-base sm:text-lg lg:text-xl' => $i > 0])>{{ $item['titel'] }}</span>
                  @if($item['intro'])
                    <span @class(['text-white/85 leading-snug', 'block text-base lg:text-lg lg:max-w-md' => $i === 0, 'hidden text-sm sm:block lg:line-clamp-2' => $i > 0])>{{ $item['intro'] }}</span>
                  @endif
                </span>
              </button>
            </li>
          @endforeach
        </ul>

        {{-- Venster per onderwerp: video bovenin (pas geladen als het venster open is, stopt bij sluiten), daaronder de tekst --}}
        <template x-teleport="body">
          <div x-show="open !== null" x-transition.opacity.duration.300ms x-trap.inert.noscroll="open !== null"
            @keydown.escape.window="open = null" @click.self="open = null" role="dialog" aria-modal="true"
            class="fixed inset-0 z-60 flex items-end justify-center bg-triv-navy/70 backdrop-blur-sm sm:items-center sm:p-8" style="display: none;">
            @foreach ($onderwerpen as $i => $item)
              @php($kleur = $kleuren[$i % count($kleuren)])
              <div x-show="open === {{ $i }}" class="relative max-h-[92vh] w-full max-w-3xl overflow-y-auto rounded-t-3xl bg-white shadow-2xl sm:rounded-3xl">
                <button type="button" @click="open = null" aria-label="Sluiten"
                  @class(['absolute top-3 right-3 z-10 flex size-10 cursor-pointer items-center justify-center rounded-full transition-colors', 'bg-triv-navy/60 text-white hover:bg-triv-navy/80' => $item['video'], 'text-triv-navy hover:bg-stone-100' => ! $item['video']])>
                  <x-icon name="close" :size="16" />
                </button>
                @if($item['video'])
                  <div class="aspect-video bg-black">
                    <template x-if="open === {{ $i }}">
                      <iframe src="{{ $item['video']['embed'] }}" title="{{ $item['titel'] }}" class="size-full" allow="autoplay; fullscreen; picture-in-picture; encrypted-media" allowfullscreen></iframe>
                    </template>
                  </div>
                @endif
                <div class="p-6 sm:p-10">
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
              </div>
            @endforeach
          </div>
        </template>
      @endif
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
