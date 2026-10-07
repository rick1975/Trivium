{{-- Sitemap: volledige navigatie (met submenu's) als overzicht boven de footer; zelfde nachtblauw als de footer --}}
@if($navigation)
  <nav aria-label="Sitemap" class="py-12 md:py-16 xl:py-24 bg-triv-navy">
    <div class="px-6 xl:px-20">
      <div class="flex flex-wrap justify-between gap-8">
        @foreach($navigation as $item)
          <div class="w-full sm:w-auto sm:flex-1">
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
