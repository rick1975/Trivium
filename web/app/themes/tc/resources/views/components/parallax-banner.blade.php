{{-- Parallax-foto met links uitgelijnde tekst. Gebruik:
     <x-parallax-banner image="..." title="Bij ons word je" highlight="gehoord" href="...">Tekst</x-parallax-banner>
     Bij het in beeld scrollen schuift de foto trager mee dan de sectie (zoals fullPage.js' "cover"-parallax),
     komen de woorden van de titel één voor één omhoog en daarna de tekst en knop. Het roze highlight-woord
     krijgt bewegende equalizer-balkjes. De animaties hangen aan de scrollpositie van de sectie
     (animation-timeline: view()); elk woord start iets later via --i. --}}
@props([
  'image',
  'title',
  'highlight' => null,
  'href' => null,
  'linkText' => 'Lees meer',
])

@php
  $words = preg_split('/\s+/', trim($title));
  $scroll = 'scroll-driven:[animation-timeline:--banner] scroll-driven:[animation-range:entry_calc(20%+var(--i)*8%)_entry_calc(55%+var(--i)*8%)]';
  // Balkjes: [duur, vertraging, rusthoogte bij "minder beweging"]
  $bars = [[.9, -.2, .6], [.6, -.5, 1], [1.1, -.1, .45], [.75, -.4, .8]];
@endphp

<section class="relative h-svh overflow-hidden [view-timeline:--banner]">
  <div class="absolute inset-0 bg-cover bg-center scroll-driven:animate-parallax-cover scroll-driven:[animation-timeline:--banner] scroll-driven:[animation-range:cover]" style="background-image: url('{{ $image }}');"></div>

  <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>

  <div class="relative z-10 h-full max-w-[1280px] mx-auto flex items-center px-6">
    <div class="max-w-md">
      <h2 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight mb-6">
        @foreach($words as $i => $word)
          <span class="inline-block overflow-hidden align-bottom pb-[0.12em] -mb-[0.12em]"><span class="inline-block scroll-driven:animate-word-up {{ $scroll }}" style="--i: {{ $i }}">{{ $word }}</span></span>
        @endforeach
        @if($highlight)
          <br>
          <span class="inline-block overflow-hidden align-bottom pb-[0.12em] -mb-[0.12em]"><span class="inline-block text-triv-pink scroll-driven:animate-word-up {{ $scroll }}" style="--i: {{ count($words) }}">{{ $highlight }}</span></span>
          <span class="inline-flex items-end gap-[0.08em] h-[0.55em] ml-[0.15em] scroll-driven:animate-scroll-fade-up {{ $scroll }}" style="--i: {{ count($words) + 1 }}" aria-hidden="true">
            @foreach($bars as [$duration, $delay, $rest])
              <span class="w-[0.09em] h-full rounded-full bg-triv-pink origin-bottom motion-safe:animate-equalizer" style="--eq-duration: {{ $duration }}s; --eq-delay: {{ $delay }}s; scale: 1 {{ $rest }};"></span>
            @endforeach
          </span>
        @endif
      </h2>
      <div class="scroll-driven:animate-scroll-fade-up scroll-driven:[animation-timeline:--banner] scroll-driven:[animation-range:entry_60%_entry_100%]">
        <p class="text-white leading-relaxed mb-8">
          {{ $slot }}
        </p>
        @if($href)
          <x-button :href="$href">{{ $linkText }}</x-button>
        @endif
      </div>
    </div>
  </div>
</section>
