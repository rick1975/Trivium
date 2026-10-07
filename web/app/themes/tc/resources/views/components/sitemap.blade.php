{{-- Sitemap: volledige navigatie (met submenu's) als overzicht onder de footer; zelfde nachtblauw als de footer.
     Scheidingslijn bovenaan loopt vanaf tablet tot tweederde en vervaagt onder de foto. Zodra de bezoeker
     helemaal onderaan de pagina is gescrold, groeit de lijn eenmalig van links naar rechts (zet data-shown). --}}
@if($navigation)
  <nav aria-label="Sitemap" x-data @scroll.window.throttle.100ms="if (innerHeight + scrollY >= document.documentElement.scrollHeight - 4) $el.dataset.shown = ''" class="group relative py-12 md:py-16 xl:py-32 bg-triv-navy border-t border-white/10 md:border-t-0">
    {{-- Scheidingslijn vanaf tablet: groeit van links naar rechts en vervaagt richting de foto --}}
    <span aria-hidden="true" class="hidden md:block absolute top-0 left-0 w-2/3 h-px bg-linear-to-r from-white/15 via-white/15 via-50% to-transparent origin-left scale-x-0 transition-transform duration-1500 ease-out group-data-shown:scale-x-100 motion-reduce:scale-x-100 motion-reduce:transition-none"></span>
    <div class="page-container">
      <div class="flex flex-wrap justify-between gap-x-12 gap-y-10">
        @foreach($navigation as $item)
          <div class="w-full sm:w-auto">
            <span id="sitemap-{{ $loop->index }}" class="block font-bold text-white mb-3">
              {!! $item->label !!}
            </span>
            @if($item->children)
              <ul class="space-y-2" aria-labelledby="sitemap-{{ $loop->index }}">
                @foreach($item->children as $child)
                  <li>
                    <a href="{{ $child->url }}"
                      class="inline-block text-white/70 transition-colors hover:text-white aria-[current=page]:text-white"
                      @if($child->active) aria-current="page" @endif
                      @if($child->target) target="{{ $child->target }}" @endif>
                      {!! $child->label !!}
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </nav>
@endif
