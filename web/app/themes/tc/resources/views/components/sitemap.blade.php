{{-- Sitemap: volledige navigatie (met submenu's) als overzicht onder de footer; zelfde nachtblauw als de footer.
     Scheidingslijn bovenaan loopt vanaf tablet tot tweederde en vervaagt onder de foto. Zodra de sitemap
     ruim in beeld is (bovenrand 40% het scherm in), groeit de lijn eenmalig van links naar rechts (x-intersect zet data-shown).
     Aan het eind van de lijn verschijnt daarna het label uit Trivium Settings > Footer ($footer->sitemapLabel, via Composers\Footer); de fruiticoontjes ploppen na elkaar op (--i × 120ms)
     als witte outline en kleuren zo'n 3 seconden later na elkaar in (.fruit-fill, --i × 250ms). --}}
@if($navigation)
  <nav aria-label="Sitemap" x-data x-intersect.once.margin.0.0.-40%.0="$el.dataset.shown = ''" class="group relative py-12 md:py-16 xl:py-32 bg-triv-navy border-t border-white/10 md:border-t-0">
    {{-- Scheidingslijn vanaf tablet: groeit van links naar rechts en vervaagt richting de foto --}}
    <span aria-hidden="true" class="hidden md:block absolute top-0 left-0 w-2/3 h-px bg-linear-to-r from-white/15 via-white/15 via-50% to-transparent origin-left scale-x-0 transition-transform duration-1000 ease-out group-data-shown:scale-x-100 motion-reduce:scale-x-100 motion-reduce:transition-none"></span>
    {{-- Label op het eind van de lijn (rechterkant op 2/3): schuift in beeld als de lijn bijna klaar is --}}
    @if(! empty($footer->sitemapLabel))
    <p class="hidden md:flex absolute top-0 right-1/3 z-10 -translate-y-1/2 translate-x-4 opacity-0 items-center gap-3 rounded-full border border-white/15 bg-triv-navy px-4 py-2 text-sm font-medium text-white whitespace-nowrap transition-[translate,opacity] duration-500 ease-out delay-800 group-data-shown:translate-x-0 group-data-shown:opacity-100 motion-reduce:translate-x-0 motion-reduce:opacity-100 motion-reduce:transition-none">
      <span class="flex items-center gap-1">
        @foreach(['apple', 'banana', 'watermelon'] as $fruit)
          <x-icon :name="$fruit" :size="24" class="text-white [&_.fruit-fill]:opacity-0 [&_.fruit-fill]:transition-opacity [&_.fruit-fill]:duration-700 [&_.fruit-fill]:delay-[calc(4100ms+var(--i)*250ms)] group-data-shown:[&_.fruit-fill]:opacity-100 motion-reduce:[&_.fruit-fill]:opacity-100 scale-0 transition-transform duration-400 ease-[cubic-bezier(.34,1.56,.64,1)] delay-[calc(1100ms+var(--i)*120ms)] group-data-shown:scale-100 motion-reduce:scale-100 motion-reduce:transition-none" style="--i: {{ $loop->index }}" />
        @endforeach
      </span>
      {{ $footer->sitemapLabel }}
    </p>
    @endif
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
