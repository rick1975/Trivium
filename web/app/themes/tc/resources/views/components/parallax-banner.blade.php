{{-- Parallax-foto met links uitgelijnde tekst. Titel via de 'title'-slot, tekst via de standaard slot. --}}
@props([
  'image',
  'href' => null,
  'linkText' => 'Lees meer',
])

<section class="relative h-svh overflow-hidden">
  <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ $image }}');"></div>

  <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent"></div>

  <div class="relative z-10 h-full max-w-[1280px] mx-auto flex items-center px-6">
    <div class="max-w-xl">
      <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
        {{ $title }}
      </h2>
      <p class="text-white leading-relaxed mb-8">
        {{ $slot }}
      </p>
      @if($href)
        <x-button :href="$href" variant="white">{{ $linkText }}</x-button>
      @endif
    </div>
  </div>
</section>
