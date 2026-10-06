{{-- ── WITTE BALK — opvallende CTA's en "Ga direct naar"-links ── --}}
@php
  $ctas = [
    ['title' => 'Zit je in groep 8?', 'text' => '→ Kijk dan snel hier', 'url' => App\page_url('groep-8'), 'class' => 'bg-triv-yellow', 'titleClass' => 'text-gray-900', 'textClass' => 'text-gray-900'],
    ['title' => 'Open dag 18 april', 'text' => '→ Meld je aan', 'url' => App\page_url('open-dagen'), 'class' => 'bg-triv-lightblue', 'titleClass' => 'text-white', 'textClass' => 'text-white/80'],
  ];

  $links = [
    ['title' => 'Kom kennismaken', 'text' => 'Infoavonden & open dagen', 'url' => App\page_url('open-dagen')],
    ['title' => 'Aanmelden', 'text' => 'Meld je aan bij onze school', 'url' => App\page_url('aanmelden')],
    ['title' => 'Schoolgids', 'text' => 'Praktische informatie', 'url' => App\page_url('beleid-documenten')],
    ['title' => 'Roosters', 'text' => 'Bekijk je rooster', 'url' => App\page_url('lestijden-roostervrije-dagen')],
    ['title' => 'Ziekmelden', 'text' => 'Snel en eenvoudig', 'url' => App\page_url('verlof-verzuim')],
    ['title' => 'De drie werelden', 'text' => 'Ontdek jouw talent', 'url' => App\page_url('profielen')],
  ];
@endphp

<div class="bg-white border-b border-[#e8e0d0] py-20 px-8">
  <div class="max-w-[1280px] mx-auto grid grid-cols-[280px_1fr] gap-12 items-start">

    {{-- Gekleurde CTA-blokken --}}
    <div class="flex flex-col gap-3 max-w-[200px]">
      @foreach($ctas as $cta)
        <a href="{{ $cta['url'] }}" class="{{ $cta['class'] }} rounded-2xl p-5 no-underline block hover:-translate-y-1 transition-transform duration-200">
          <h3 class="text-base font-bold {{ $cta['titleClass'] }} mb-1">{{ $cta['title'] }}</h3>
          <span class="text-xs font-semibold {{ $cta['textClass'] }}">{{ $cta['text'] }}</span>
        </a>
      @endforeach
    </div>

    {{-- Ga direct naar --}}
    <div class="lg:mt-10">
      <h2 class="text-2xl font-bold mb-6">Ga direct naar:</h2>
      <div class="grid grid-cols-2 gap-x-10">
        @foreach($links as $link)
          <a href="{{ $link['url'] }}" class="flex flex-col py-3 border-b border-[#e8e0d0] no-underline group">
            <span class="font-bold text-triv-blue group-hover:text-triv-lightblue transition-colors">→ {{ $link['title'] }}</span>
            <span class="text-sm text-[#7a6248] mt-0.5">{{ $link['text'] }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </div>
</div>
