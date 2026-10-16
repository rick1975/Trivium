{{-- Op de voorpagina en bij fotoheaderstijl "achter de inhoud" ligt de header transparant over de foto (wit logo en witte
     iconen, zie Composers\Header); elders staat hij in de flow met een lichte achtergrond --}}
<header @class([
    'banner z-50',
    'absolute top-0 left-0 right-0 bg-transparent' => $overPhoto,
    'relative bg-white border-b border-[#eef0f2]' => ! $overPhoto,
  ])
  x-data="{ mobileOpen: false, searchOpen: false }"
  @keydown.escape.window="mobileOpen = false; searchOpen = false"
  x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen || searchOpen)">

  <div class="px-4 md:px-6 xl:px-20">
    <div class="flex items-center justify-between min-h-[80px]">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}" class="block" aria-label="{{ $siteName }} – home">
        <x-logo @class(["w-48 md:w-56 lg:w-64", "[--logo-letters:#fff]" => $overPhoto]) aria-hidden="true" />
      </a>

      {{-- Zoek-icoon + hamburger, altijd gegroepeerd rechts --}}
      <div class="flex items-center gap-2">

        {{-- Zoek-icoon --}}
        @php($searchIdleClass = $overPhoto
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

        {{-- Taalknop (TranslatePress): rondje met de actieve taal, bij meer talen een keuzelijstje --}}
        @if($languages)
          @php($current = collect($languages)->firstWhere('active', true) ?? $languages[0])
          @php($others = collect($languages)->where('active', false))
          @php($langClass = 'w-9 h-9 rounded-full flex items-center justify-center border text-xs font-bold tracking-wide transition-all duration-300 ' . $searchIdleClass)
          @if($others->isEmpty())
            <span class="{{ $langClass }}" title="{{ $current->name }}">
              <span aria-hidden="true">{{ $current->code }}</span>
              <span class="sr-only">Taal: {{ $current->name }}</span>
            </span>
          @else
            <div class="relative" x-data="{ langOpen: false }" @click.outside="langOpen = false" @keydown.escape="langOpen = false">
              <button type="button" class="{{ $langClass }} cursor-pointer" @click="langOpen = !langOpen"
                :aria-expanded="langOpen.toString()" aria-controls="lang-menu" aria-label="Taal kiezen, nu {{ $current->name }}">
                <span aria-hidden="true">{{ $current->code }}</span>
              </button>
              <ul id="lang-menu" data-no-translation x-show="langOpen" x-transition style="display: none;"
                class="absolute right-0 top-full mt-2 min-w-36 rounded-2xl bg-white p-1.5 shadow-xl border border-[#f4f0e8]">
                @foreach($others as $language)
                  <li class="mb-0">
                    <a href="{{ $language->url }}" hreflang="{{ strtolower($language->code) }}" lang="{{ strtolower($language->code) }}"
                      class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-[#1a1612] no-underline hover:bg-triv-cream hover:text-triv-pink transition-colors">
                      <span class="font-bold w-6">{{ $language->code }}</span>{{ $language->name }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif
        @endif

        {{-- Hamburger --}}
        @php($barColor = $overPhoto ? 'bg-white' : 'bg-[#1a1612]')
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
