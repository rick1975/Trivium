{{-- Parallax-foto met links uitgelijnde tekst. Gebruik:
     <x-parallax-banner image="..." title="Bij ons word je" highlight="gehoord" href="...">Tekst</x-parallax-banner>
     Bij het in beeld scrollen schuift de foto trager mee dan de sectie (zoals fullPage.js' "cover"-parallax)
     (animation-timeline). Zodra de lopende tekst half in beeld is, schuiven de woorden eenmalig na elkaar
     omhoog (zoals op nobears.com): Alpine's x-intersect zet data-shown, woord --i wacht --i × 30ms. --}}
@props([
  'image',
  'title',
  'highlight' => null,
  'href' => null,
  'linkText' => 'Lees meer',
])

@php($words = preg_split('/\s+/', trim(strip_tags($slot))))

<section data-slide class="relative h-svh overflow-hidden [view-timeline:--banner]">
  <div class="absolute inset-0 bg-cover bg-center scroll-driven:animate-parallax-cover scroll-driven:[animation-timeline:--banner] scroll-driven:[animation-range:cover]" style="background-image: url('{{ $image }}');"></div>

  <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>

  <div class="relative z-10 h-full max-w-[1280px] mx-auto flex items-center px-6">
    <div class="max-w-md">
      <h2 class="text-5xl xl:text-6xl font-bold text-white leading-tight mb-6">
        {{ $title }}
        @if($highlight)
          <br><span class="text-triv-pink">{{ $highlight }}</span>
        @endif
      </h2>
      <p class="group text-white leading-relaxed mb-8" x-data x-intersect.once.half="$el.dataset.shown = ''">
        @foreach($words as $i => $word)
          <span class="inline-block overflow-clip -my-1 py-1 align-bottom"><span class="inline-block translate-y-2/3 opacity-0 transition-[translate,opacity] duration-700 ease-out delay-[calc(var(--i)*30ms)] group-data-shown:translate-y-0 group-data-shown:opacity-100 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none" style="--i: {{ $i }}">{{ $word }}</span></span>
        @endforeach
      </p>
      @if($href)
        <x-button :href="$href" :dot="false">{{ $linkText }}</x-button>
      @endif
    </div>
  </div>
</section>
