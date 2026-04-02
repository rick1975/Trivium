<header class="banner bg-white shadow-sm" x-data="{ mobileOpen: false }">
  <div class="container">
    <div class="flex items-center justify-between min-h-[80px]">
      {{-- Logo --}}
      <a href="{{ home_url('/') }}" class="text-2xl font-bold" style="color: var(--primary);">
        {{ get_bloginfo('name') }}
      </a>

      {{-- Desktop Navigation --}}
      @if($navigation)
        <nav class="hidden lg:block">
          <ul class="flex items-center space-x-8 mb-0">
            @foreach($navigation as $item)
              <li @if($item->children) 
                    x-data="{ open: false }" 
                    @mouseenter="open = true" 
                    @mouseleave="open = false"
                    class="relative"
                  @endif>
                
                <a href="{{ $item->url }}" 
                   class="nav-link transition-colors duration-200 {{ $item->active ? 'font-semibold' : '' }}"
                   style="color: {{ $item->active ? 'var(--primary)' : 'inherit' }};"
                   @if($item->target) target="{{ $item->target }}" @endif>
                  {{ $item->label }}
                  
                  @if($item->children)
                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  @endif
                </a>

                {{-- Dropdown --}}
                @if($item->children)
                  <ul x-show="open"
                      x-transition:enter="transition ease-out duration-200"
                      x-transition:enter-start="opacity-0 translate-y-1"
                      x-transition:enter-end="opacity-100 translate-y-0"
                      x-transition:leave="transition ease-in duration-150"
                      x-transition:leave-start="opacity-100 translate-y-0"
                      x-transition:leave-end="opacity-0 translate-y-1"
                      class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50 mb-0"
                      style="display: none;">
                    @foreach($item->children as $child)
                      <li>
                        <a href="{{ $child->url }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                           @if($child->target) target="{{ $child->target }}" @endif>
                          {{ $child->label }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </li>
            @endforeach
          </ul>
        </nav>
      @endif

      {{-- Mobile Menu Button with 3-line Animation (lg breakpoint) --}}
      <button type="button" 
              class="lg:hidden -m-2.5 p-2.5" 
              @click="mobileOpen = !mobileOpen" 
              :aria-expanded="mobileOpen.toString()" 
              aria-label="Toggle menu">
        <span class="block relative w-6 h-4">
          <span class="absolute left-0 top-0 block h-[2px] w-6 bg-current transition-transform duration-300" 
                :class="mobileOpen ? 'translate-y-[7px] rotate-45' : ''"></span>
          <span class="absolute left-0 top-1/2 block h-[2px] w-6 -translate-y-1/2 bg-current transition-opacity duration-200" 
                :class="mobileOpen ? 'opacity-0' : 'opacity-100'"></span>
          <span class="absolute left-0 bottom-0 block h-[2px] bg-current transition-all duration-300" 
                :class="mobileOpen ? 'w-6 -translate-y-[7px] -rotate-45' : 'w-4'"></span>
        </span>
      </button>
    </div>

    {{-- Mobile Navigation --}}
    @if($navigation)
      <nav x-show="mobileOpen"
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 -translate-y-4"
           x-transition:enter-end="opacity-100 translate-y-0"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 translate-y-0"
           x-transition:leave-end="opacity-0 -translate-y-4"
           class="lg:hidden py-4 border-t border-gray-200"
           style="display: none;">
        <ul class="space-y-2 mb-0">
          @foreach($navigation as $item)
            <li x-data="{ subOpen: false }">
              <div class="flex items-center justify-between">
                <a href="{{ $item->url }}" 
                   class="block py-2 {{ $item->active ? 'font-semibold' : '' }}"
                   style="color: {{ $item->active ? 'var(--primary)' : 'inherit' }};"
                   @if($item->target) target="{{ $item->target }}" @endif>
                  {{ $item->label }}
                </a>
                
                @if($item->children)
                  <button @click="subOpen = !subOpen" 
                          class="p-2">
                    <svg x-show="!subOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <svg x-show="subOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  </button>
                @endif
              </div>

              @if($item->children)
                <ul x-show="subOpen"
                    x-transition
                    class="pl-4 space-y-2 mt-2 mb-0"
                    style="display: none;">
                  @foreach($item->children as $child)
                    <li>
                      <a href="{{ $child->url }}" 
                         class="block py-2 text-gray-600"
                         @if($child->target) target="{{ $child->target }}" @endif>
                        {{ $child->label }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      </nav>
    @endif
  </div>
</header>
