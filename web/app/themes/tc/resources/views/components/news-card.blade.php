{{-- Nieuwskaart. 'large' = groot artikel met foto als achtergrond, 'small' = kleine fotokaart,
     'row' = regel in de lijst naast het grote artikel: kleine foto met titel en beschrijving ernaast,
     'tile' = kaart in het raster van het nieuwsoverzicht: foto boven, datum, titel en beschrijving eronder. --}}
@props([
  'item',
  'size' => 'small',
])

@php($large = $size === 'large')

@if($size === 'tile')
<a href="{{ $item['url'] }}" {{ $attributes->merge(['class' => 'group flex h-full flex-col no-underline']) }}>
  <div class="mb-4 aspect-4/3 overflow-hidden rounded-xl">
    <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" loading="lazy" decoding="async"
      class="size-full max-w-none object-cover transition-transform duration-500 group-hover:scale-105" />
  </div>
  <time @if(! empty($item['datetime'])) datetime="{{ $item['datetime'] }}" @endif class="mb-1 text-sm text-stone-500">{{ $item['date'] }}</time>
  <h3 class="mb-2 text-lg font-semibold leading-snug text-triv-navy transition-colors group-hover:text-triv-pink">
    {{ $item['title'] }}
  </h3>
  @if($item['excerpt'])
    <p class="mb-0 line-clamp-3 text-sm leading-relaxed text-stone-600">{{ $item['excerpt'] }}</p>
  @endif
</a>
@elseif($size === 'row')
<a href="{{ $item['url'] }}" {{ $attributes->merge(['class' => 'group flex items-start gap-5 no-underline']) }}>
  <div class="aspect-4/3 w-28 shrink-0 overflow-hidden rounded-lg sm:w-36">
    <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" loading="lazy" decoding="async"
      class="size-full max-w-none object-cover transition-transform duration-500 group-hover:scale-105" />
  </div>
  <div class="min-w-0">
    <h3 class="mb-1 text-base font-semibold leading-snug text-triv-navy transition-colors group-hover:text-triv-pink md:text-lg">
      {{ $item['title'] }}
    </h3>
    @if($item['excerpt'])
      <p class="mb-0 line-clamp-2 text-sm leading-relaxed text-stone-600">{{ $item['excerpt'] }}</p>
    @endif
  </div>
</a>
@else

<a href="{{ $item['url'] }}" {{ $attributes->merge(['class' => 'group relative rounded-xl overflow-hidden no-underline block ' . ($large ? 'min-h-[500px]' : 'min-h-[235px]')]) }}>
  <img
    src="{{ $item['image'] }}"
    alt="{{ $item['alt'] }}"
    loading="lazy" decoding="async"
    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
  />
  <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
  <div class="absolute inset-0 flex flex-col justify-end {{ $large ? 'p-8' : 'p-6' }}">
    {{-- <div class="flex items-center gap-3 {{ $large ? 'mb-3' : 'mb-2' }}">
      @if($item['category'])
        <span class="{{ $item['categoryClass'] }} text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">{{ $item['category'] }}</span>
      @endif
      <time @if(! empty($item['datetime'])) datetime="{{ $item['datetime'] }}" @endif class="text-white/60 text-xs">{{ $item['date'] }}</time>
    </div> --}}
    <h3 class="{{ $large ? 'text-2xl' : 'text-base' }} !mb-1 font-medium text-white leading-snug group-hover:underline transition-colors">
      {{ $item['title'] }}
    </h3>
  </div>
</a>
@endif
