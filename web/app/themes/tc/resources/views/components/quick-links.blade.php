{{-- ── SNELLE LINKS — opvallende CTA's en "Ga direct naar"-links, in de stijl van de parallax-banner
     (grote titel met roze tweede regel, zelfde 1280px-lijn). Mobiel alles onder elkaar, vanaf lg twee kolommen. ── --}}
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

<section class="bg-white py-16 md:py-24">
  <div class="max-w-[1280px] mx-auto px-6 grid gap-12 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:gap-20">

    {{-- Titel + gekleurde CTA-blokken --}}
    <div>
      <h2 class="text-4xl lg:text-5xl font-bold text-triv-blue leading-tight mb-8">
        Ga direct<br><span class="text-triv-pink">naar</span>
      </h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        @foreach($ctas as $cta)
          <a href="{{ $cta['url'] }}" class="{{ $cta['class'] }} rounded-xl p-5 no-underline block hover:-translate-y-1 transition-transform duration-200">
            <h3 class="text-base font-bold {{ $cta['titleClass'] }} mb-1">{{ $cta['title'] }}</h3>
            <span class="text-sm font-semibold {{ $cta['textClass'] }}">{{ $cta['text'] }}</span>
          </a>
        @endforeach
      </div>
    </div>

    {{-- Ga direct naar --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 lg:self-end">
      @foreach($links as $link)
        <a href="{{ $link['url'] }}" class="group flex items-center justify-between gap-4 py-4 border-b border-gray-200 no-underline">
          <span class="flex flex-col">
            <span class="text-lg font-bold text-triv-blue group-hover:text-triv-pink transition-colors">{{ $link['title'] }}</span>
            <span class="text-sm text-gray-600 mt-0.5">{{ $link['text'] }}</span>
          </span>
          <span class="text-triv-pink text-xl transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true">→</span>
        </a>
      @endforeach
    </div>
  </div>
</section>
