{{-- Fotobanner: schermvullende foto met titel (optioneel gekleurde tweede regel), tekst en knop.
     Gebruik: <x-photo-banner image="..." title="Bij ons word je" highlight="gehoord" href="...">Tekst</x-photo-banner>
     align="left|right": kant van de tekst (het verloop loopt mee); accent="roze|geel|groen|oranje": kleur tweede regel.
     Op de voorpagina gevuld vanuit Trivium Settings > Fotobanner (Composers\PhotoBanner).
     Als slide (data-slide) glijdt hij in beeld (js/slide-sections.js), op mobiel na het loslaten van een veeg.
     animate="text" (standaard): zodra de tekst half in beeld is, schuiven de woorden eenmalig na elkaar omhoog
     (x-intersect zet data-shown, woord --i wacht --i × 30ms). Screenreaders krijgen de tekst als één zin (sr-only);
     de opgeknipte, geanimeerde woorden zijn aria-hidden.
     animate="title": de titelregels rollen eenmalig van links naar rechts uit (clip-path), de tweede regel iets later;
     de broodtekst staat stil.
     mobile-text="top|center|bottom": plek van de tekst op mobiel (verloop loopt mee: van boven, opzij of van onder),
     zodat hij niet over een gezicht loopt; vanaf md staat hij altijd verticaal in het midden.
     Bij bottom telt de ruimte onderin het verschil lvh − svh mee: zo valt de knop niet achter een uitgeklapte adresbalk.
     mobile-focus="left|center|right": welk deel van de foto zichtbaar blijft als object-cover hem smal bijsnijdt.
     align="right": op mobiel staat de titel ook rechts (broodtekst en knop blijven links).
     Leesbaarheid: vanaf desktop blijft het verloop donker tot voorbij de tekst.
     Vlak vanaf lg breder (max-w-2xl) zodat de witte titelregel op één regel past; de broodtekst blijft smaller
     (max-w-xl; bij animate="text" max-w-md, zodat hij op de foto van de onderste banner niet tot de mond van de jongen loopt). --}}
@props([
  'image',
  'title',
  'highlight' => null,
  'href' => null,
  'linkText' => 'Lees meer',
  'target' => null,
  'align' => 'left',
  'accent' => 'roze',
  'animate' => 'text',
  'mobileText' => 'center',
  'mobileFocus' => 'center',
])

@php($words = preg_split('/\s+/', trim(strip_tags($slot))))
@php($right = $align === 'right')
@php($mobileCenter = $mobileText === 'center')
@php($mobileGradient = match ($mobileText) {
  'top' => 'bg-gradient-to-b',
  'bottom' => 'bg-gradient-to-t',
  default => $right ? 'bg-gradient-to-l' : 'bg-gradient-to-r',
})
@php($accentClass = match ($accent) {
  'geel' => 'text-triv-yellow',
  'groen' => 'text-triv-green',
  'oranje' => 'text-triv-orange',
  default => 'text-triv-pink',
})
{{-- Knop in dezelfde kleur als de tweede titelregel (geen oranje knopvariant: dan roze) --}}
@php($buttonVariant = match ($accent) {
  'geel' => 'yellow',
  'groen' => 'green',
  default => 'pink',
})

<section data-slide class="relative h-lvh overflow-hidden">
  <img src="{{ $image }}" alt="" loading="lazy" decoding="async" @class([
    'absolute inset-0 size-full max-w-none object-cover',
    'object-left' => $mobileFocus === 'left',
    'object-right' => $mobileFocus === 'right',
  ])>

  <div @class([
    'absolute inset-0 to-transparent lg:from-black/80 lg:via-black/50 lg:via-40%',
    $mobileGradient,
    $right ? 'md:bg-gradient-to-l' : 'md:bg-gradient-to-r',
    'from-black/70 via-black/30' => $mobileCenter,
    'from-black/80 via-black/40 md:from-black/70 md:via-black/30' => ! $mobileCenter,
  ])></div>

  <div @class([
    'relative z-10 h-full page-container flex',
    'items-center' => $mobileCenter,
    'items-start pt-20 md:items-center md:pt-0' => $mobileText === 'top',
    'items-end pb-[calc(1.5rem_+_100lvh_-_100svh)] md:items-center md:pb-0' => $mobileText === 'bottom',
    'justify-end' => $right,
  ])>
    <div class="max-w-md lg:max-w-2xl">
      @if($animate === 'title')
        @php($unroll = ($right ? 'max-md:ml-auto max-md:text-right ' : '') . 'block w-fit [clip-path:inset(0_100%_0_0)] transition-[clip-path] duration-1800 ease-[cubic-bezier(.65,0,.25,1)] group-data-shown:[clip-path:inset(0)] motion-reduce:[clip-path:inset(0)] motion-reduce:transition-none')
        <h2 class="group text-[2.5rem] md:text-5xl xl:text-6xl font-bold text-white leading-tight mb-6" x-data x-intersect.once.half="$el.dataset.shown = ''">
          <span class="{{ $unroll }}">{{ $title }}</span>
          @if($highlight)
            <span class="{{ $unroll }} delay-700 {{ $accentClass }}">{{ $highlight }}</span>
          @endif
        </h2>
        <p class="text-white font-medium leading-relaxed mb-8 max-w-xl">{{ implode(' ', $words) }}</p>
      @else
        <h2 @class(['text-[2.5rem] md:text-5xl xl:text-6xl font-bold text-white leading-tight mb-6', 'max-md:text-right' => $right])>
          {{ $title }}
          @if($highlight)
            <br><span class="{{ $accentClass }}">{{ $highlight }}</span>
          @endif
        </h2>
        <p class="sr-only">{{ implode(' ', $words) }}</p>
        <p aria-hidden="true" class="group text-white font-medium leading-relaxed mb-8 max-w-md" x-data x-intersect.once.half="$el.dataset.shown = ''">
          @foreach($words as $i => $word)
            <span class="inline-block overflow-clip -my-1 py-1 align-bottom"><span class="inline-block translate-y-2/3 opacity-0 transition-[translate,opacity] duration-700 ease-out delay-[calc(var(--i)*30ms)] group-data-shown:translate-y-0 group-data-shown:opacity-100 motion-reduce:translate-y-0 motion-reduce:opacity-100 motion-reduce:transition-none" style="--i: {{ $i }}">{{ $word }}</span></span>
          @endforeach
        </p>
      @endif
      @if($href)
        <x-button :href="$href" :target="$target ?: null" :variant="$buttonVariant" :dot="false">{{ $linkText }}</x-button>
      @endif
    </div>
  </div>
</section>
