{{-- Herbruikbare iconen. Gebruik: <x-icon name="close" class="..." />
     Fruit (apple, pear, banana, orange): vrucht in currentColor, blaadje groen. --}}
@props(['name', 'size' => null])

@switch($name)
  @case('close')
    <svg width="{{ $size ?? 14 }}" height="{{ $size ?? 14 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true" {{ $attributes }}>
      <line x1="4" y1="4" x2="20" y2="20"/>
      <line x1="20" y1="4" x2="4" y2="20"/>
    </svg>
    @break

  @case('search')
    <svg width="{{ $size ?? 16 }}" height="{{ $size ?? 16 }}" viewBox="0 0 15 15" fill="none" aria-hidden="true" {{ $attributes }}>
      <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.4"/>
      <path d="M11 11l2.5 2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
    </svg>
    @break

  @case('chevron-right')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" {{ $attributes }}>
      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
    </svg>
    @break

  @case('apple')
    <svg width="{{ $size ?? 20 }}" height="{{ $size ?? 20 }}" viewBox="0 0 24 24" aria-hidden="true" {{ $attributes }}>
      <path fill="currentColor" d="M12 7.5c-1.5-1-4.5-1.3-6 .7-1.8 2.4-1 6.6.8 9.3 1.2 1.8 2.6 3 4 2.3.8-.4 1.6-.4 2.4 0 1.4.7 2.8-.5 4-2.3 1.8-2.7 2.6-6.9.8-9.3-1.5-2-4.5-1.7-6-.7z"/>
      <path fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M12 7.5c0-1.5.4-3 1.3-4"/>
      <path class="fill-triv-green" d="M13 5.5c1-1.8 3-2.3 4.5-1.8-.5 1.6-2.5 2.6-4.5 1.8z"/>
    </svg>
    @break

  @case('pear')
    <svg width="{{ $size ?? 20 }}" height="{{ $size ?? 20 }}" viewBox="0 0 24 24" aria-hidden="true" {{ $attributes }}>
      <path fill="currentColor" d="M12 6c-1.6 0-2.5 1.2-2.6 2.8-.1 1.6-.7 2.5-1.8 3.7C6.3 14 6 15.6 6.5 17.2 7.3 19.5 9.5 21 12 21s4.7-1.5 5.5-3.8c.5-1.6.2-3.2-1.1-4.7-1.1-1.2-1.7-2.1-1.8-3.7C14.5 7.2 13.6 6 12 6z"/>
      <path fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M12 6.5V3"/>
      <path class="fill-triv-green" d="M12.5 4.5c.8-1.3 2.4-1.8 3.8-1.3-.6 1.3-2.3 2-3.8 1.3z"/>
    </svg>
    @break

  @case('banana')
    <svg width="{{ $size ?? 20 }}" height="{{ $size ?? 20 }}" viewBox="0 0 24 24" aria-hidden="true" {{ $attributes }}>
      <path fill="currentColor" d="M4.5 8c1 6 5 10 11.5 10 2 0 3.5-.6 4-1.5-.4-.4-1.4-.4-2.5-.4-5 0-8.6-3-10.6-8.6C6.4 6.3 5 6.3 4.5 8z"/>
      <path fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M5.3 7.2 4.6 4.8"/>
    </svg>
    @break

  @case('orange')
    <svg width="{{ $size ?? 20 }}" height="{{ $size ?? 20 }}" viewBox="0 0 24 24" aria-hidden="true" {{ $attributes }}>
      <circle fill="currentColor" cx="12" cy="13.5" r="7"/>
      <path class="fill-triv-green" d="M12 6.5c.5-1.8 2.2-3 4-3-.3 1.9-2 3-4 3z"/>
    </svg>
    @break
@endswitch
