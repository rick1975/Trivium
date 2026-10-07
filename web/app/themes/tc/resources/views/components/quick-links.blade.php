{{-- ── SNELLE LINKS — gekleurde blokken en "Ga direct naar"-links uit Trivium Settings > Snelle links
     (Composers\QuickLinks), in de stijl van de fotobanner (grote titel met roze tweede regel).
     Mobiel alles onder elkaar, vanaf lg twee kolommen. ── --}}
@if($links || $ctas)
<section class="bg-white py-16 md:py-24">
  <div class="page-container grid gap-12 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)] lg:gap-20">

    {{-- Titel + gekleurde CTA-blokken --}}
    <div>
      @if($title)
        <h2 class="text-4xl lg:text-5xl font-bold text-triv-blue leading-tight mb-8">
          {{ $title }}
          @if($highlight)
            <br><span class="text-triv-pink">{{ $highlight }}</span>
          @endif
        </h2>
      @endif
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        @foreach($ctas as $cta)
          <a href="{{ $cta['url'] }}" class="{{ $cta['classes']['block'] }} rounded-xl p-5 no-underline block hover:-translate-y-1 transition-transform duration-200">
            <h3 class="text-base font-bold {{ $cta['classes']['title'] }} mb-1">{{ $cta['title'] }}</h3>
            <span class="text-sm font-semibold {{ $cta['classes']['text'] }}">{{ $cta['text'] }}</span>
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
@endif
