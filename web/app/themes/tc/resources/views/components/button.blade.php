{{-- Knop/link in huisstijl. Gebruik: <x-button href="..." variant="pink|white">Tekst</x-button> --}}
@props([
  'href' => '#',
  'variant' => 'pink',
])

@php($variantClass = match ($variant) {
  'white' => 'bg-white text-triv-blue px-8',
  default => 'bg-triv-pink text-white px-6',
})

<a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-flex items-center gap-2 font-semibold text-sm py-3 rounded-xl hover:-translate-y-0.5 hover:shadow-lg transition-all duration-200 no-underline {$variantClass}"]) }}>
  {{ $slot }}
</a>
