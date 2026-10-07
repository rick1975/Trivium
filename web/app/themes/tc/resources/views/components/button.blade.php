{{-- Knop/link in huisstijl. Gebruik: <x-button href="..." variant="pink|green|white|outline">Tekst</x-button>
     Stip en hover-animatie: resources/css/components/button.css --}}
@props([
  'href' => '#',
  'variant' => 'pink',
])

@php($variantClass = match ($variant) {
  'white' => 'btn--white bg-white text-triv-blue px-8',
  'green' => 'btn--green bg-triv-green text-white px-6',
  'outline' => 'btn--outline border-2 border-gray-800 text-gray-800 px-6',
  default => 'btn--pink bg-triv-pink text-white px-6',
})

<a href="{{ $href }}" {{ $attributes->merge(['class' => "btn inline-flex items-center gap-2.5 font-semibold text-sm py-3 rounded-xl hover:-translate-y-px hover:shadow-md transition-all duration-200 no-underline {$variantClass}"]) }}>
  <span class="btn__dot" aria-hidden="true"></span>
  {{ $slot }}
</a>
