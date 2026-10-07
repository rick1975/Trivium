{{-- Parallax-foto met gecentreerde tekst. Titel via de 'title'-slot, tekst via de standaard slot. --}}
@props([
  'image',
  'href' => null,
  'linkText' => 'Lees meer',
])

<section class="relative h-svh overflow-hidden">
  <div class="absolute inset-0 bg-cover bg-center bg-fixed" style="background-image: url('{{ $image }}');"></div>

  <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-transparent"></div>

  <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
    <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
      {{ $title }}
    </h2>
    <p class="text-white font-light max-w-2xl leading-relaxed mb-8">
      {{ $slot }}
    </p>
    @if($href)
      <x-button :href="$href" variant="white">{{ $linkText }}</x-button>
    @endif
  </div>
</section>
