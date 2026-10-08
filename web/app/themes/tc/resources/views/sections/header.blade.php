{{-- Op de voorpagina ligt de header transparant over de hero; elders staat hij in de flow met een lichte achtergrond --}}
<header @class([
    'banner z-50',
    'absolute top-0 left-0 right-0 bg-transparent' => $isFront,
    'relative bg-white border-b border-[#eef0f2]' => ! $isFront,
  ])
  x-data="{ mobileOpen: false, searchOpen: false }"
  @keydown.escape.window="mobileOpen = false; searchOpen = false"
  x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen || searchOpen)">

  <div class="px-6 xl:px-20">
    <div class="flex items-center justify-between min-h-[80px]">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}" aria-label="{{ $siteName }} – home">
        <x-logo class="w-44" aria-hidden="true" />
      </a>

      {{-- Zoek-icoon + hamburger, altijd gegroepeerd rechts --}}
      <div class="flex items-center gap-2">

        {{-- Zoek-icoon --}}
        @php($searchIdleClass = $isFront
          ? 'bg-white/15 border-white/30 text-white backdrop-blur-sm hover:bg-white/25'
          : 'bg-white border-[#ddd8cc] text-[#1a1612] hover:bg-triv-cream')
        <button type="button"
          class="w-9 h-9 rounded-full flex items-center justify-center border transition-all duration-300 cursor-pointer"
          :class="searchOpen
            ? 'bg-[#e56b6f] border-[#e56b6f] text-white'
            : @js($searchIdleClass)"
          @click="searchOpen = !searchOpen; mobileOpen = false"
          :aria-expanded="searchOpen.toString()"
          aria-controls="search-panel"
          aria-label="Zoeken">
          <x-icon name="search" />
        </button>

        {{-- Hamburger --}}
        @php($barColor = $isFront ? 'bg-white' : 'bg-[#1a1612]')
        <button type="button" class="-m-2.5 p-2.5 cursor-pointer" @click="mobileOpen = !mobileOpen; searchOpen = false" :aria-expanded="mobileOpen.toString()" aria-controls="nav-drawer" aria-label="Menu openen of sluiten">
          <span class="block relative w-6 h-4">
            <span class="absolute left-0 top-0 block h-[2px] w-6 {{ $barColor }} transition-transform duration-300" :class="mobileOpen ? 'translate-y-[7px] rotate-45' : ''"></span>
            <span class="absolute left-0 top-1/2 block h-[2px] w-6 {{ $barColor }} -translate-y-1/2 transition-opacity duration-200" :class="mobileOpen ? 'opacity-0' : 'opacity-100'"></span>
            <span class="absolute left-0 bottom-0 block h-[2px] {{ $barColor }} transition-all duration-300" :class="mobileOpen ? 'w-6 -translate-y-[7px] -rotate-45' : 'w-4'"></span>
          </span>
        </button>

      </div>

    </div>

  </div>

  @include('components.search-panel')

  {{-- Uitschuifmenu --}}
  @includeWhen($navigation, 'components.nav-drawer')
</header>
