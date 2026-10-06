{{--
  Uitschuifmenu (hoofdnavigatie). Wordt geopend via `mobileOpen` uit de header.
  Mobiel: volledig scherm. Desktop: smal zwevend paneel rechts.
--}}
{{-- Backdrop --}}
<div x-show="mobileOpen" x-transition.opacity.duration.300ms
  class="fixed inset-0 bg-triv-blue/30 backdrop-blur-sm z-40"
  style="display: none;" @click="mobileOpen = false" aria-hidden="true"></div>

<aside x-show="mobileOpen"
  x-transition:enter="transition ease-out duration-400"
  x-transition:enter-start="opacity-0 translate-x-8"
  x-transition:enter-end="opacity-100 translate-x-0"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100 translate-x-0"
  x-transition:leave-end="opacity-0 translate-x-8"
  class="fixed inset-0 lg:inset-auto lg:top-3 lg:right-3 lg:bottom-3 lg:w-[440px] bg-triv-cream lg:rounded-3xl shadow-2xl z-50 flex flex-col overflow-hidden"
  style="display: none;"
  aria-label="Hoofdmenu">

  {{-- Kop: sluiten --}}
  <div class="flex items-center justify-end px-6 lg:px-8 pt-6 pb-4 shrink-0">
    <button type="button" @click="mobileOpen = false"
      class="w-10 h-10 rounded-full flex items-center justify-center bg-white text-[#1a1612] shadow-sm hover:bg-triv-pink hover:text-white hover:rotate-90 transition-all duration-300 cursor-pointer"
      aria-label="Menu sluiten">
      <x-icon name="close" />
    </button>
  </div>

  {{-- Navigatie --}}
  <nav class="flex-1 overflow-y-auto px-3 lg:px-5 py-2">
    <ul class="flex flex-col gap-0.5">
      @foreach($navigation as $item)
        <li x-data="{ subOpen: {{ $item->activeAncestor || $item->activeParent ? 'true' : 'false' }} }"
          class="transition-all duration-500 ease-out"
          :class="mobileOpen ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-6'"
          style="transition-delay: {{ 80 + $loop->index * 50 }}ms;">

          @if($item->children)
            <button type="button" @click="subOpen = !subOpen" :aria-expanded="subOpen.toString()"
              class="group w-full flex items-center gap-3 px-3 py-3 rounded-2xl text-left transition-colors cursor-pointer"
              :class="subOpen ? 'bg-white' : 'hover:bg-white/70'">
              <span class="flex-1 font-bold text-lg leading-snug transition-colors"
                :class="subOpen ? 'text-triv-pink' : 'text-gray-800 group-hover:text-triv-pink'">{!! $item->label !!}</span>
              <span class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 transition-all duration-300"
                :class="subOpen ? 'bg-triv-pink text-white rotate-90' : 'bg-white text-stone-400 group-hover:text-triv-pink'">
                <x-icon name="chevron-right" class="size-3.5" />
              </span>
            </button>

            <ul x-show="subOpen" x-collapse style="display: none;"
              class="ml-3 mr-2 mt-1 mb-3 pl-3 flex flex-col">
              @foreach($item->children as $child)
                <li>
                  <a href="{{ $child->url }}" @click="mobileOpen = false"
                    @class([
                      'nav-link inline-block my-1.5 text-[0.95rem] transition-opacity hover:opacity-90',
                      'text-triv-pink font-semibold' => $child->active,
                      'text-stone-600' => ! $child->active,
                    ])
                    @if($child->active) aria-current="page" @endif
                    @if($child->target) target="{{ $child->target }}" @endif>
                    {!! $child->label !!}
                  </a>
                </li>
              @endforeach
            </ul>
          @else
            <a href="{{ $item->url }}" @click="mobileOpen = false"
              class="group flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-white/70 transition-colors"
              @if($item->target) target="{{ $item->target }}" @endif>
              <span @class([
                'flex-1 font-bold text-lg leading-snug transition-colors',
                'text-triv-pink' => $item->active,
                'text-gray-800 group-hover:text-triv-pink' => ! $item->active,
              ])>{!! $item->label !!}</span>
            </a>
          @endif
        </li>
      @endforeach
    </ul>
  </nav>

  {{-- Voet: snelle acties + contact --}}
  <div class="shrink-0 px-6 lg:px-8 pt-5 pb-6 border-t border-[#ece6d8] transition-all duration-500 ease-out"
    :class="mobileOpen ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
    style="transition-delay: {{ 120 + count($navigation) * 50 }}ms;">
    <div class="grid grid-cols-2 gap-2">
      <x-button :href="App\page_url('aanmelden')" class="justify-center">Aanmelden</x-button>
      <a href="{{ App\page_url('open-dagen') }}"
        class="inline-flex items-center justify-center font-semibold text-sm py-3 rounded-xl border-2 border-triv-blue text-triv-blue hover:bg-triv-blue hover:text-white transition-colors no-underline">
        Open dagen
      </a>
    </div>

    @if($contact->telefoon || $contact->email)
      <div class="mt-4 flex flex-wrap items-center justify-center gap-x-4 gap-y-1 text-sm">
        @if($contact->telefoon)
          <a href="tel:{{ $contact->telefoonLink }}" class="text-stone-600 hover:text-triv-pink transition-colors">{{ $contact->telefoon }}</a>
        @endif
        @if($contact->email)
          <a href="mailto:{{ $contact->email }}" class="text-stone-600 hover:text-triv-pink transition-colors">{{ $contact->email }}</a>
        @endif
      </div>
    @endif
  </div>
</aside>
