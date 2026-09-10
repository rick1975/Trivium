<header class="banner absolute top-0 left-0 right-0 z-50 bg-transparent"
  x-data="{ mobileOpen: false, searchOpen: false }"
  @keydown.escape.window="mobileOpen = false; searchOpen = false"
  x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen)">

  <div class="px-6 xl:px-20">
    <div class="flex items-center justify-between min-h-[80px]">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}">
        <div class="w-44 [&>svg]:w-full [&>svg]:h-auto">
          {!! file_get_contents(get_template_directory() . '/resources/images/VMBO-Trivium-college.svg') !!}
        </div>
      </a>

      {{-- Zoek-icoon + hamburger, altijd gegroepeerd rechts --}}
      <div class="flex items-center gap-2">

        {{-- Zoek-icoon --}}
        <button type="button"
          class="w-9 h-9 rounded-full flex items-center justify-center border transition-all duration-300 cursor-pointer"
          :class="searchOpen
            ? 'bg-[#e56b6f] border-[#e56b6f] text-white'
            : 'bg-white/15 border-white/30 text-white backdrop-blur-sm hover:bg-white/25'"
          @click="searchOpen = !searchOpen; mobileOpen = false"
          :aria-expanded="searchOpen.toString()"
          aria-label="Zoeken">
          <svg width="16" height="16" viewBox="0 0 15 15" fill="none">
            <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.4"/>
            <path d="M11 11l2.5 2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
          </svg>
        </button>

        {{-- Hamburger --}}
        <button type="button" class="-m-2.5 p-2.5 cursor-pointer" @click="mobileOpen = !mobileOpen; searchOpen = false" :aria-expanded="mobileOpen.toString()" aria-label="Toggle menu">
          <span class="block relative w-6 h-4">
            <span class="absolute left-0 top-0 block h-[2px] w-6 bg-white transition-transform duration-300" :class="mobileOpen ? 'translate-y-[7px] rotate-45' : ''"></span>
            <span class="absolute left-0 top-1/2 block h-[2px] w-6 bg-white -translate-y-1/2 transition-opacity duration-200" :class="mobileOpen ? 'opacity-0' : 'opacity-100'"></span>
            <span class="absolute left-0 bottom-0 block h-[2px] bg-white transition-all duration-300" :class="mobileOpen ? 'w-6 -translate-y-[7px] -rotate-45' : 'w-4'"></span>
          </span>
        </button>

      </div>

    </div>

  </div>

  @include('components.search-panel')

  {{-- Backdrop --}}
  <div x-show="mobileOpen" x-transition.opacity  class="fixed inset-0 bg-black/40 z-40" style="display:none;" @click="mobileOpen = false" aria-hidden="true"></div>

  {{-- Mobile Navigation (drawer) --}}
  @if($navigation)
    <aside x-show="mobileOpen"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 translate-x-full"
      x-transition:enter-end="opacity-100 translate-x-0"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 translate-x-0"
      x-transition:leave-end="opacity-0 translate-x-full"
      class="fixed top-0 right-0 h-full w-[460px] max-w-[88vw] bg-white shadow-2xl z-50 flex flex-col overflow-y-auto"
      style="display: none;"
      aria-label="Hoofdmenu">
      <div class="sticky top-0 bg-white flex items-center justify-between px-6 py-4 border-b border-[#eef0f2] shrink-0">
        <span class="font-bold text-xs text-[#2f333a] mt-2">Menu</span>
        <button type="button" @click="mobileOpen = false"
          class="w-9 h-9 rounded-full flex items-center justify-center border border-[#ddd8cc] bg-white text-[#1a1612] hover:bg-[#e56b6f] hover:border-[#e56b6f] hover:text-white transition-all duration-300 cursor-pointer" aria-label="Menu sluiten">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="4" y1="4" x2="20" y2="20"/>
            <line x1="20" y1="4" x2="4" y2="20"/>
          </svg>
        </button>
      </div>

      <nav class="flex flex-col py-1 pb-6">
        @foreach($navigation as $item)
          <div class="border-b border-[#eef0f2]" x-data="{ subOpen: false }">
            @if($item->children)
              <button type="button" @click="subOpen = !subOpen" :aria-expanded="subOpen.toString()"
                class="w-full flex items-center justify-between gap-2.5 py-4 px-6 text-left font-bold text-base transition-colors cursor-pointer"
                :class="subOpen ? 'text-[#e56b6f]' : 'text-[#2f333a] hover:text-[#d14d51]'">
                {!! $item->label !!}
                <svg class="w-2.5 h-2.5 shrink-0 border-r-2 border-b-2 border-[#9aa0a8] transition-transform duration-200" :class="subOpen ? '-rotate-[135deg]' : 'rotate-45'" style="transform-origin:center;"></svg>
              </button>

              <ul x-show="subOpen" x-collapse class="bg-[#faf7f7]" style="display: none;">
                @foreach($item->children as $child)
                  <li class="border-t border-[#f0eaea]">
                    <a href="{{ $child->url }}" @click="mobileOpen = false"
                      class="block py-2.5 pl-6 pr-6 text-sm text-[#5a616b] hover:text-[#d14d51] hover:bg-[#f4eded] transition-colors"
                      @if($child->target) target="{{ $child->target }}" @endif>
                      {!! $child->label !!}
                    </a>
                  </li>
                @endforeach
              </ul>
            @else
              <a href="{{ $item->url }}" @click="mobileOpen = false"
                class="block py-4 px-6 font-bold text-base {{ $item->active ? 'text-[#e56b6f]' : 'text-[#2f333a]' }} hover:text-[#d14d51] transition-colors"
                @if($item->target) target="{{ $item->target }}" @endif>
                {!! $item->label !!}
              </a>
            @endif
          </div>
        @endforeach
      </nav>
    </aside>
  @endif
</header>
