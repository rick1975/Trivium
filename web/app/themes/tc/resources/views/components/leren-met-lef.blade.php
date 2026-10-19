{{-- ── LEREN MET LEF — kaarten uit Trivium Settings > Leren met lef (Composers\LerenMetLef; max 6, 3+3 op desktop) ── --}}
@php
  $kleuren = ['bg-triv-blue', 'bg-triv-pink', 'bg-triv-orange', 'bg-triv-green', 'bg-triv-yellow', 'bg-triv-lightblue'];
@endphp

<section class="relative z-20 -mt-[8vh]">
  {{-- Golfboog direct over de hero-foto: de section zelf heeft hier geen achtergrond, zodat er contrast is --}}
  @include('components.wave-divider', ['fill' => '#fbfaf4'])

  <div class="bg-triv-cream pt-16 pb-20">
    <div class="page-container">
       {{-- Grid: 1 kolom mobiel, 3+3 op desktop. Genummerde lijst; kaarttitels zijn h2 (direct onder de h1 "Leren met Lef" in de hero) --}}
      <ol class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-0">

        @foreach ($onderwerpen as $i => $item)
          <li class="mb-0 rounded-xl bg-white p-7 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div aria-hidden="true" class="{{ $kleuren[$i % count($kleuren)] }} w-11 h-11 rounded-2xl flex items-center justify-center text-white font-black text-lg mb-5">
              {{ $i + 1 }}
            </div>
            <h2 class="text-xl md:text-xl font-bold text-gray-800 mb-4">{{ $item['titel'] }}</h2>
            {{-- Content, per alinea (gescheiden door een witregel):
                 - regels die met • of - beginnen worden een opsomming (die regel vet, de regels eronder de toelichting);
                 - een alinea waarvan de eerste regel kort is en niet op een leesteken eindigt, krijgt die regel als vetgedrukte kop;
                 - de rest is gewone tekst. Afgebroken regels (bijv. geplakt uit een pdf) worden weer aan elkaar gezet. --}}
            @if(!empty($item['content']))
              @php
                $blokken = [];
                foreach (preg_split('/\R\s*\R/', trim($item['content'])) as $alinea) {
                  $regels = array_values(array_filter(array_map('trim', preg_split('/\R/', $alinea)), 'strlen'));
                  if (! $regels) continue;
                  if (! preg_match('/^[•\-]/u', $regels[0])) {
                    $tekst = [];
                    while ($regels && ! preg_match('/^[•\-]/u', $regels[0])) $tekst[] = array_shift($regels);
                    $isKop = count($tekst) > 1 && mb_strlen($tekst[0]) <= 60 && ! preg_match('/[.!?:,;]$/u', $tekst[0]);
                    $blokken[] = $isKop
                      ? ['type' => 'kop', 'kop' => array_shift($tekst), 'tekst' => implode(' ', $tekst)]
                      : ['type' => 'tekst', 'tekst' => implode(' ', $tekst)];
                  }
                  foreach ($regels as $regel) {
                    if (preg_match('/^[•\-]\s*(.+)$/u', $regel, $m)) {
                      if (($blokken[array_key_last($blokken)]['type'] ?? null) !== 'lijst') $blokken[] = ['type' => 'lijst', 'punten' => []];
                      $blokken[array_key_last($blokken)]['punten'][] = ['kop' => $m[1], 'tekst' => []];
                    } else {
                      $punten = &$blokken[array_key_last($blokken)]['punten'];
                      $punten[array_key_last($punten)]['tekst'][] = $regel;
                      unset($punten);
                    }
                  }
                }
              @endphp
              <div class="mt-2 flex flex-col gap-3 text-sm">
                @foreach($blokken as $blok)
                  @if($blok['type'] === 'lijst')
                    <ul class="mb-0 flex flex-col gap-3">
                      @foreach($blok['punten'] as $punt)
                        <li class="relative mb-0 pl-4 before:absolute before:left-0 before:top-[0.5em] before:size-1.5 before:rounded-full before:bg-triv-pink">
                          <span class="block font-semibold text-triv-navy">{{ $punt['kop'] }}</span>
                          @if($punt['tekst'])
                            <span class="block text-stone-600">{{ implode(' ', $punt['tekst']) }}</span>
                          @endif
                        </li>
                      @endforeach
                    </ul>
                  @elseif($blok['type'] === 'kop')
                    <div>
                      <h3 class="mb-0 text-sm font-semibold text-triv-navy">{{ $blok['kop'] }}</h3>
                      <p class="mb-0 text-stone-600">{{ $blok['tekst'] }}</p>
                    </div>
                  @else
                    <p class="mb-0 text-stone-600">{{ $blok['tekst'] }}</p>
                  @endif
                @endforeach
              </div>
            @endif
          </li>
        @endforeach

        @if(count($onderwerpen) < 6)
          {{-- Placeholder: content volgt later --}}
          <li aria-hidden="true" class="mb-0 rounded-3xl border-2 border-dashed border-[#ddd8cc] p-7 flex flex-col items-center justify-center text-center min-h-[180px]">
            <span class="text-sm font-semibold text-triv-section">Binnenkort meer</span>
          </li>
        @endif

      </ol>
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
