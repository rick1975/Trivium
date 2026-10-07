{{-- Sitemap: volledige navigatie (met submenu's) als overzicht onder de footer; zelfde nachtblauw als de footer --}}
@if($navigation)
  <nav aria-label="Sitemap" class="py-12 md:py-16 xl:py-24 bg-triv-navy border-t border-white/10">
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
