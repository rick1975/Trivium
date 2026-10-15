{{-- ── NIEUWS — de vier nieuwste berichten (data uit de News-composer) ── --}}
@if($newsItems)
  <section class="pb-20 pt-10 bg-triv-cream">
    <div class="page-container">

      {{-- Header --}}
      <div class="mb-10">
        <h2 class="text-4xl md:text-5xl xl:text-6xl font-bold text-triv-navy mb-0">Nieuws</h2>
      </div>

      {{-- Groot artikel links; vanaf lg rechts daarnaast, achter een verticale lijn, de overige berichten als lijst met een
           kleine foto (op mobiel eronder, achter een horizontale lijn), met daaronder de knop naar alle berichten --}}
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1.5fr_1fr] lg:gap-0">
        <x-news-card :item="$newsItems[0]" size="large" />
        <div class="border-t border-[#ddd8cc] pt-8 lg:ml-10 lg:border-t-0 lg:border-l lg:pt-0 lg:pl-10">
          @if(count($newsItems) > 1)
            <ul class="mb-8 flex flex-col gap-6">
              @foreach(array_slice($newsItems, 1) as $item)
                <li class="mb-0">
                  <x-news-card :item="$item" size="row" />
                </li>
              @endforeach
            </ul>
          @endif
          <x-button :href="$newsArchiveUrl">Alle berichten</x-button>
        </div>
      </div>
    </div>
  </section>
@endif
