{{-- Parallax-foto met links uitgelijnde tekst. Gebruik:
     <x-parallax-banner image="..." title="Bij ons word je" highlight="gehoord" href="...">Tekst</x-parallax-banner>
     Bij het in beeld scrollen schuift de foto trager mee dan de sectie (zoals fullPage.js' "cover"-parallax)
     en wordt de lopende tekst woord voor woord helder (zoals op nobears.com). Beide hangen aan de
     scrollpositie (animation-timeline); woord --i van --n krijgt een eigen stukje van het scrollbereik. --}}
@props([
  'image',
  'title',
  'highlight' => null,
  'href' => null,
  'linkText' => 'Lees meer',
])

@php($words = preg_split('/\s+/', trim(strip_tags($slot))))

<section class="relative h-svh overflow-hidden [view-timeline:--banner]">
  <div class="absolute inset-0 bg-cover bg-center scroll-driven:animate-parallax-cover scroll-driven:[animation-timeline:--banner] scroll-driven:[animation-range:cover]" style="background-image: url('{{ $image }}');"></div>

  <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>

  <div class="relative z-10 h-full max-w-[1280px] mx-auto flex items-center px-6">
    <div class="max-w-md">
      <h2 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight mb-6">
        {{ $title }}
        @if($highlight)
          <br><span class="text-triv-pink">{{ $highlight }}</span>
        @endif
      </h2>
      <p class="text-white leading-relaxed mb-8 [view-timeline:--text]" style="--n: {{ count($words) }}">
        @foreach($words as $i => $word)
          <span class="scroll-driven:animate-text-reveal scroll-driven:[animation-timeline:--text] scroll-driven:[animation-range:cover_calc(20%+30%*var(--i)/var(--n))_cover_calc(28%+30%*var(--i)/var(--n))]" style="--i: {{ $i }}">{{ $word }}</span>
        @endforeach
      </p>
      @if($href)
        <x-button :href="$href">{{ $linkText }}</x-button>
      @endif
    </div>
  </div>
</section>
