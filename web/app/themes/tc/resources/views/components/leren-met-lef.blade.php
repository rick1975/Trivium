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
            {{-- Content: regels die met • of - beginnen worden een opsomming (die regel vetgedrukt, de regels eronder de toelichting) --}}
            @if(!empty($item['content']))
              @php
                $punten = [];
                $intro = [];
                foreach (preg_split('/\R/', trim($item['content'])) as $regel) {
                  $regel = trim($regel);
                  if ($regel === '') continue;
                  if (preg_match('/^[•\-]\s*(.+)$/u', $regel, $m)) {
                    $punten[] = ['kop' => $m[1], 'tekst' => []];
                  } elseif ($punten) {
                    $punten[array_key_last($punten)]['tekst'][] = $regel;
                  } else {
                    $intro[] = $regel;
                  }
                }
              @endphp
              @if($intro)
                <p class="text-sm text-gray-600 mt-2">{!! implode('<br>', array_map('e', $intro)) !!}</p>
              @endif
              @if($punten)
                <ul class="mt-2 mb-0 space-y-3 text-sm">
                  @foreach($punten as $punt)
                    <li class="relative mb-0 pl-4 before:absolute before:left-0 before:top-[0.5em] before:size-1.5 before:rounded-full before:bg-triv-pink">
                      <span class="block font-semibold text-triv-navy">{{ $punt['kop'] }}</span>
                      @if($punt['tekst'])
                        <span class="block text-stone-600">{{ implode(' ', $punt['tekst']) }}</span>
                      @endif
                    </li>
                  @endforeach
                </ul>
              @endif
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
