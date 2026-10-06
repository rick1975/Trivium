{{-- Herbruikbare iconen. Gebruik: <x-icon name="close" class="..." /> --}}
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
@endswitch
