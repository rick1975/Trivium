{{-- Sitemap: volledige navigatie (met submenu's) als overzicht boven de footer --}}
@if($navigation)
  <section class="py-12 md:py-16 bg-triv-cream">
    <div class="container">
      <h2 class="text-lg font-semibold mb-8 text-[#1a1612]">Sitemap</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        @foreach($navigation as $item)
          <div>
            <a href="{{ $item->url }}"
              class="block font-bold text-[#1a1612] hover:text-triv-pink transition-colors mb-3"
              @if($item->target) target="{{ $item->target }}" @endif>
              {!! $item->label !!}
            </a>
            @if($item->children)
              <ul class="space-y-2">
                @foreach($item->children as $child)
                  <li>
                    <a href="{{ $child->url }}"
                      class="text-sm text-[#5a616b] hover:text-triv-pink transition-colors"
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
