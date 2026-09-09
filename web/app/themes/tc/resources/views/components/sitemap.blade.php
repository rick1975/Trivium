{{-- Sitemap: volledige navigatie (met submenu's) als overzicht boven de footer --}}
@if($navigation)
  <section class="py-12 md:py-16 bg-triv-cream">
    <div class="px-6 xl:px-20">
      <div class="flex flex-wrap justify-between gap-8">
        @foreach($navigation as $item)
          <div class="w-full sm:w-auto sm:flex-1">
            <a href="{{ $item->url }}"
              class="block font-bold text-[#1a1612] hover:text-triv-pink hover:translate-x-1.5 transition-all duration-200 mb-3"
              @if($item->target) target="{{ $item->target }}" @endif>
              {!! $item->label !!}
            </a>
            @if($item->children)
              <ul class="space-y-2">
                @foreach($item->children as $child)
                  <li>
                    <a href="{{ $child->url }}"
                      class="inline-block text-sm text-[#5a616b] hover:text-triv-pink hover:translate-x-1.5 transition-all duration-200"
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
  </section>
@endif
