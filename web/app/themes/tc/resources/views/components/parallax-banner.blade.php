{{-- Parallax-foto met links uitgelijnde tekst. Titel via de 'title'-slot, tekst via de standaard slot.
     Bij het in beeld scrollen schuift de foto trager mee dan de sectie (zoals fullPage.js' "cover"-parallax)
     en komt de tekst omhoog. De animatie hangt aan de scrollpositie van de sectie (animation-timeline: view()). --}}
@props([
  'image',
  'href' => null,
  'linkText' => 'Lees meer',
])

<section class="relative h-svh overflow-hidden [view-timeline:--banner]">
  <div class="absolute inset-0 bg-cover bg-center scroll-driven:animate-parallax-cover scroll-driven:[animation-timeline:--banner] scroll-driven:[animation-range:cover]" style="background-image: url('{{ $image }}');"></div>

  <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>

  <div class="relative z-10 h-full max-w-[1280px] mx-auto flex items-center px-6">
    <div class="max-w-md scroll-driven:animate-scroll-fade-up scroll-driven:[animation-timeline:--banner] scroll-driven:[animation-range:entry_30%_entry_100%]">
      <h2 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight mb-6">
        {{ $title }}
      </h2>
      <p class="text-white leading-relaxed mb-8">
        {{ $slot }}
      </p>
      @if($href)
        <x-button :href="$href">{{ $linkText }}</x-button>
      @endif
    </div>
  </div>
</section>
