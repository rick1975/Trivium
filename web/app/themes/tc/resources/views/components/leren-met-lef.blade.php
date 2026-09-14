{{-- ── LEREN MET LEF — repeater uit Trivium Settings (max 6, 3+3 op desktop) ── --}}
@php
  $onderwerpen = get_field('leren_met_lef', 'option') ?: [];
  $kleuren = ['bg-triv-blue', 'bg-triv-pink', 'bg-triv-orange', 'bg-triv-green', 'bg-triv-yellow', 'bg-triv-lightblue'];
@endphp

<section class="relative z-20 -mt-[12vh] lg:-mt-[22vh] pt-16 pb-20 px-6 xl:px-20 bg-triv-cream">
  {{-- Golfboog binnen de section, zodat hij boven de opgetilde hero-overlap zichtbaar blijft --}}
  @include('components.wave-divider', ['fill' => '#fbfaf4'])

  <div class="max-w-[1280px] mx-auto">
     {{-- Grid: 1 kolom mobiel, 3+3 op desktop --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      @foreach ($onderwerpen as $i => $item)
        <div class="rounded-3xl bg-white p-7 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
          <div class="{{ $kleuren[$i % count($kleuren)] }} w-11 h-11 rounded-2xl flex items-center justify-center text-white font-black text-lg mb-5">
            {{ $i + 1 }}
          </div>
          <h3 class="text-xl font-bold text-gray-800">{{ $item['titel'] }}</h3>
          @if(!empty($item['content']))
            <p class="text-sm text-gray-600 mt-2">{!! nl2br(e($item['content'])) !!}</p>
          @endif
        </div>
      @endforeach

      @if(count($onderwerpen) < 6)
        {{-- Placeholder: content volgt later --}}
        <div class="rounded-3xl border-2 border-dashed border-[#ddd8cc] p-7 flex flex-col items-center justify-center text-center min-h-[180px]">
          <span class="text-sm font-semibold text-[#9b9e4b]">Binnenkort meer</span>
        </div>
      @endif

    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
