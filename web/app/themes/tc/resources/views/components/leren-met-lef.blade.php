{{-- ── LEREN MET LEF — 5 onderwerpen + 1 placeholder (3+3 op desktop) ── --}}
@php
  $onderwerpen = [
    [
      'kleur' => 'bg-triv-blue',
      'titel' => 'Leren met lef is leuk',
    ],
    [
      'kleur' => 'bg-triv-pink',
      'titel' => 'Leren met lef doe je op maat',
    ],
    [
      'kleur' => 'bg-triv-orange',
      'titel' => 'Leren met lef is ontdekken en doen!',
    ],
    [
      'kleur' => 'bg-triv-green',
      'titel' => 'Leren met lef is goed voor je zorgen',
    ],
    [
      'kleur' => 'bg-triv-yellow',
      'titel' => 'Wijs in een digitale wereld',
    ],
  ];
@endphp

<section class="relative z-20 -mt-[12vh] lg:-mt-[22vh] pt-16 pb-20 px-6 xl:px-20 bg-triv-cream">
  <div class="max-w-[1280px] mx-auto">
     {{-- Grid: 1 kolom mobiel, 3+3 op desktop --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

      @foreach ($onderwerpen as $i => $item)
        <div class="rounded-3xl bg-white p-7 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
          <div class="{{ $item['kleur'] }} w-11 h-11 rounded-2xl flex items-center justify-center text-white font-black text-lg mb-5">
            {{ $i + 1 }}
          </div>
          <h3 class="text-xl font-bold text-gray-800">{{ $item['titel'] }}</h3>
        </div>
      @endforeach

      {{-- Zesde blok: content volgt later --}}
      <div class="rounded-3xl border-2 border-dashed border-[#ddd8cc] p-7 flex flex-col items-center justify-center text-center min-h-[180px]">
        <span class="text-sm font-semibold text-[#9b9e4b]">Binnenkort meer</span>
      </div>

    </div>
  </div>
</section>

@include('components.wave-divider', ['fill' => '#fbfaf4', 'edge' => 'bottom'])
