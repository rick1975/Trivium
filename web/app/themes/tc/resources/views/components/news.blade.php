{{-- ── NIEUWS — de vier nieuwste berichten (data uit de News-composer) ── --}}
@if($newsItems)
  <section class="pb-20 pt-10 bg-triv-cream">
    <div class="page-container">

      {{-- Header --}}
      <div class="flex items-end justify-between mb-10">
        <h2 class="text-4xl font-bold text-gray-800 mb-0">Laatste nieuws</h2>
        <a href="{{ $newsArchiveUrl }}" class="inline-flex items-center gap-2 text-sm font-semibold text-triv-blue border-b-2 border-triv-yellow pb-0.5 no-underline hover:text-triv-pink transition-colors">
          Alle berichten
        </a>
      </div>

      {{-- Groot artikel links; vanaf lg rechts daarnaast, achter een verticale lijn, de overige berichten als lijst met een
           kleine foto (op mobiel eronder, achter een horizontale lijn) --}}
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1.5fr_1fr] lg:gap-0">
        <x-news-card :item="$newsItems[0]" size="large" />

        @if(count($newsItems) > 1)
          <ul class="mb-0 flex flex-col justify-between gap-6 border-t border-[#ddd8cc] pt-8 lg:ml-10 lg:border-t-0 lg:border-l lg:pt-0 lg:pl-10">
            @foreach(array_slice($newsItems, 1) as $item)
              <li class="mb-0">
                <x-news-card :item="$item" size="row" />
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </section>
@endif
