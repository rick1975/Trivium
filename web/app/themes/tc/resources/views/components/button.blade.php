{{-- Knop/link in huisstijl. Gebruik: <x-button href="..." variant="pink|green|yellow|white|outline">Tekst</x-button>
     Zonder stip: :dot="false".
     Bij hover loopt een iets donkerdere tint (::before) van links naar rechts over de knop:
     een cirkel die vanuit de witte stip uitdijt. De stip verwijst naar de stip in het logo.
     --btn-dot-x = middelpunt van de stip: padding-links + halve stip. --}}
@props([
  'href' => '#',
  'variant' => 'pink',
  'dot' => true,
])

@php($variantClass = match ($variant) {
  'white' => 'bg-white text-triv-blue px-8 [--btn-dot-x:calc(2rem+4px)] before:bg-triv-blue hover:text-white focus-visible:text-white',
  'green' => 'bg-triv-green text-white px-6 [--btn-dot-x:calc(1.5rem+4px)] before:bg-[color-mix(in_srgb,var(--color-triv-green)_92%,black)]',
  // Donkerblauwe tekst: wit op geel is onleesbaar.
  'yellow' => 'bg-triv-yellow text-triv-blue px-6 [--btn-dot-x:calc(1.5rem+4px)] before:bg-[color-mix(in_srgb,var(--color-triv-yellow)_85%,white)] hover:text-white focus-visible:text-white',
  'outline' => 'border-2 border-gray-800 text-gray-800 px-6 [--btn-dot-x:calc(1.5rem+4px)] before:bg-gray-800 hover:text-white focus-visible:text-white',
  // Een vleugje triv-red maakt het roze feller in plaats van doffer.
  default => 'bg-triv-pink text-white px-6 [--btn-dot-x:calc(1.5rem+4px)] before:bg-[color-mix(in_oklch,var(--color-triv-pink)_65%,var(--color-triv-red))]',
})

@php($fillClass = 'relative isolate overflow-hidden before:absolute before:inset-0 before:-z-1 before:[clip-path:circle(0_at_var(--btn-dot-x)_50%)] before:transition-[clip-path] before:duration-500 before:ease-[cubic-bezier(.3,.7,.3,1)] hover:before:[clip-path:circle(120%_at_var(--btn-dot-x)_50%)] focus-visible:before:[clip-path:circle(120%_at_var(--btn-dot-x)_50%)] motion-reduce:before:transition-none')

<a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-flex items-center gap-2.5 font-semibold text-sm py-3 rounded-xl transition-all duration-200 no-underline {$fillClass} {$variantClass}"]) }}>
  @if($dot)
    <span class="size-1.5 flex-none rounded-full bg-current" aria-hidden="true"></span>
  @endif
  {{ $slot }}
</a>
