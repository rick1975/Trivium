{{-- Sitemap: volledige navigatie (met submenu's) als overzicht boven de footer --}}
@if($navigation)
  <nav aria-label="Sitemap" class="py-12 md:py-16 xl:py-24 bg-triv-cream">
    <div class="px-6 xl:px-20">
      <div class="flex flex-wrap justify-between gap-8">
        @foreach($navigation as $item)
          <div class="w-full sm:w-auto sm:flex-1">
            <span id="sitemap-{{ $loop->index }}" class="block font-bold text-[#1a1612] mb-3">
              {!! $item->label !!}
            </span>
            @if($item->children)
              <ul class="space-y-2" aria-labelledby="sitemap-{{ $loop->index }}">
                @foreach($item->children as $child)
                  <li>
                    <a href="{{ $child->url }}"
                      class="inline-block text-gray-700 transition-opacity hover:text-gray-900"
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
