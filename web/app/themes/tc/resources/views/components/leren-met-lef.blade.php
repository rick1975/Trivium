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
            @if(!empty($item['content']))
              <p class="text-sm text-gray-600 mt-2">{!! nl2br(e($item['content'])) !!}</p>
            @endif
          </li>
        @endforeach

        @if(count($onderwerpen) < 6)
          {{-- Placeholder: content volgt later --}}
          <li aria-hidden="true" class="mb-0 rounded-3xl border-2 border-dashed border-[#ddd8cc] p-7 flex flex-col items-center justify-center text-center min-h-[180px]">
            <span class="text-sm font-semibold text-[#9b9e4b]">Binnenkort meer</span>
          </li>
        @endif

      </ol>
    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
