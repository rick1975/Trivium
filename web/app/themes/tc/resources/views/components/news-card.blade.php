{{-- Nieuwskaart met foto als achtergrond. 'large' = groot artikel links, 'small' = kleine kaart rechts. --}}
@props([
  'item',
  'size' => 'small',
])

@php($large = $size === 'large')

<a href="{{ $item['url'] }}" {{ $attributes->merge(['class' => 'group relative rounded-xl overflow-hidden no-underline block ' . ($large ? 'min-h-[500px]' : 'flex-1 min-h-[235px]')]) }}>
  <img
    src="{{ $item['image'] }}"
    alt="{{ $item['alt'] }}"
    loading="lazy" decoding="async"
    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
  />
  <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
  <div class="absolute inset-0 flex flex-col justify-end {{ $large ? 'p-8' : 'p-6' }}">
    <div class="flex items-center gap-3 {{ $large ? 'mb-3' : 'mb-2' }}">
      @if($item['category'])
        <span class="{{ $item['categoryClass'] }} text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full">{{ $item['category'] }}</span>
      @endif
      <span class="text-white/60 text-xs">{{ $item['date'] }}</span>
    </div>
    <h3 class="{{ $large ? 'text-2xl' : 'text-base' }} mb-1 font-black text-white leading-snug group-hover:text-triv-yellow transition-colors">
      {{ $item['title'] }}
    </h3>
    @if($item['excerpt'])
      <p class="text-white/70 my-1 leading-relaxed">
        {{ $item['excerpt'] }}
      </p>
    @endif
  </div>
</a>
