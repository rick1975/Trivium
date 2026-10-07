{{-- Sitemap: volledige navigatie (met submenu's) als overzicht onder de footer; zelfde nachtblauw als de footer.
     Scheidingslijn bovenaan loopt vanaf tablet alleen onder de tekstkant van de footer en vervaagt richting de foto. --}}
@if($navigation)
  <nav aria-label="Sitemap" class="relative py-12 md:py-16 xl:py-32 bg-triv-navy border-t border-white/10 md:border-t-0 md:before:absolute md:before:top-0 md:before:left-0 md:before:w-1/2 md:before:h-px md:before:bg-linear-to-r md:before:from-white/10 md:before:via-white/10 md:before:via-60% md:before:to-transparent">
    <div class="max-w-[1280px] mx-auto px-6">
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
