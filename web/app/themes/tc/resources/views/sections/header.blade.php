<header class="banner absolute top-0 left-0 right-0 z-50 bg-transparent transition-colors duration-300"
  x-data="{ mobileOpen: false, searchOpen: false }"
  @keydown.escape.window="mobileOpen = false; searchOpen = false"
  x-effect="document.body.classList.toggle('overflow-hidden', mobileOpen)"
  :class="searchOpen ? 'bg-white shadow-sm' : 'bg-transparent'">

  <div class="px-6 xl:px-20">
    <div class="flex items-center justify-between min-h-[80px]">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}">
        <div class="w-44 [&>svg]:w-full [&>svg]:h-auto">
          {!! file_get_contents(get_template_directory() . '/resources/images/VMBO-Trivium-college.svg') !!}
        </div>
      </a>

      {{-- Zoek-icoon + hamburger: mobiel gegroepeerd rechts, op desktop los verspreid tussen logo en hamburger --}}
      <div class="flex items-center gap-2 lg:contents">

        {{-- Zoek-icoon + paneel: paneel verankert op desktop precies onder dit icoon --}}
        <div class="relative">
          <button type="button"
            class="w-9 h-9 rounded-full flex items-center justify-center border transition-all duration-300"
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

          {{-- Uitklappend zoekpaneel --}}
          <div x-show="searchOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-init="$watch('searchOpen', open => { if (open) $nextTick(() => $refs.searchInput.focus()) })"
            class="pb-6 lg:pb-0 lg:absolute lg:top-full lg:left-0 lg:mt-3 lg:w-[380px] lg:z-10"
            style="display: none;">
            <form method="GET" action="{{ home_url('/') }}" x-ref="searchForm" class="flex items-center gap-3 bg-white border border-[#ddd8cc] rounded-full px-5 py-3 lg:w-full max-w-lg focus-within:border-[#004289] focus-within:shadow-[0_6px_28px_rgba(0,66,137,.12)] transition-all duration-200">
              <svg width="15" height="15" viewBox="0 0 15 15" fill="none" class="text-[#7a7060] shrink-0">
                <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.4"/>
                <path d="M11 11l2.5 2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
              </svg>
              <input x-ref="searchInput" type="search" name="s" placeholder="Waar ben je naar op zoek?" aria-label="Zoeken"
                class="border-none outline-none bg-transparent text-sm text-[#1a1612] placeholder:text-[#7a7060] w-full font-['DM_Sans']" />
              <button type="button" @click="searchOpen = false" class="text-2xl leading-none text-[#8b9098] hover:text-[#d14d51] transition-colors shrink-0" aria-label="Zoeken sluiten">&times;</button>
            </form>
            <div class="flex flex-wrap gap-2 mt-3 lg:mt-2 lg:bg-white lg:p-3 lg:rounded-2xl lg:shadow-[0_18px_40px_rgba(20,24,30,.15)] lg:border lg:border-[#eee]">
              @foreach(['Aanmelden', 'Open dag', 'Rooster', 'Ziekmelden', 'Vakanties'] as $suggestion)
                <button type="button"
                  @click="$refs.searchInput.value = '{{ $suggestion }}'; $refs.searchForm.requestSubmit()"
                  class="text-xs font-medium text-[#6f757d] bg-white border border-[#ddd8cc] rounded-full px-3 py-1.5 hover:border-[#e56b6f] hover:text-[#d14d51] transition-colors">
                  {{ $suggestion }}
                </button>
              @endforeach
            </div>
          </div>
        </div>

        {{-- Hamburger --}}
        <button type="button" class="-m-2.5 p-2.5" @click="mobileOpen = !mobileOpen; searchOpen = false" :aria-expanded="mobileOpen.toString()" aria-label="Toggle menu">
          <span class="block relative w-6 h-4">
            <span
              class="absolute left-0 top-0 block h-[2px] w-6 transition-all duration-300"
              :class="[mobileOpen ? 'translate-y-[7px] rotate-45' : '', searchOpen ? 'bg-[#1a1612]' : 'bg-white']"
            ></span>
            <span
              class="absolute left-0 top-1/2 block h-[2px] w-6 -translate-y-1/2 transition-all duration-200"
              :class="[mobileOpen ? 'opacity-0' : 'opacity-100', searchOpen ? 'bg-[#1a1612]' : 'bg-white']"
            ></span>
            <span
              class="absolute left-0 bottom-0 block h-[2px] transition-all duration-300"
              :class="[mobileOpen ? 'w-6 -translate-y-[7px] -rotate-45' : 'w-4', searchOpen ? 'bg-[#1a1612]' : 'bg-white']"
            ></span>
          </span>
        </button>

      </div>

    </div>

  </div>

  {{-- Backdrop --}}
  <div x-show="mobileOpen" x-transition.opacity
    class="fixed inset-0 bg-black/40 z-40" style="display:none;"
    @click="mobileOpen = false" aria-hidden="true"></div>

  {{-- Mobile Navigation (drawer) --}}
  @if($navigation)
    <aside x-show="mobileOpen"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 translate-x-full"
      x-transition:enter-end="opacity-100 translate-x-0"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 translate-x-0"
      x-transition:leave-end="opacity-0 translate-x-full"
      class="fixed top-0 right-0 h-full w-[360px] max-w-[88vw] bg-white shadow-2xl z-50 flex flex-col overflow-y-auto"
      style="display: none;"
      aria-label="Hoofdmenu">
      <div class="sticky top-0 bg-white flex items-center justify-between px-6 py-4 border-b border-[#eef0f2] shrink-0">
        <span class="font-bold text-base text-[#2f333a]">Menu</span>
        <button type="button" @click="mobileOpen = false" class="text-3xl leading-none text-[#8b9098] hover:text-[#d14d51] transition-colors" aria-label="Menu sluiten">&times;</button>
      </div>

      <nav class="flex flex-col py-1 pb-6">
        @foreach($navigation as $item)
          <div class="border-b border-[#eef0f2]" x-data="{ subOpen: false }">
            @if($item->children)
              <button type="button" @click="subOpen = !subOpen" :aria-expanded="subOpen.toString()"
                class="w-full flex items-center justify-between gap-2.5 py-4 px-6 text-left font-bold text-base transition-colors"
                :class="subOpen ? 'text-[#e56b6f]' : 'text-[#2f333a] hover:text-[#d14d51]'">
                {!! $item->label !!}
                <svg class="w-2.5 h-2.5 shrink-0 border-r-2 border-b-2 border-[#9aa0a8] transition-transform duration-200" :class="subOpen ? '-rotate-[135deg]' : 'rotate-45'" style="transform-origin:center;"></svg>
              </button>

              <ul x-show="subOpen" x-collapse class="mb-2 bg-[#faf7f7]" style="display: none;">
                @foreach($item->children as $child)
                  <li class="border-t border-[#f0eaea]">
                    <a href="{{ $child->url }}" @click="mobileOpen = false"
                      class="block py-2.5 pl-8 pr-6 text-sm text-[#5a616b] hover:text-[#d14d51] hover:bg-[#f4eded] transition-colors"
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
