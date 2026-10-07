{{-- ── NIEUWS — de drie nieuwste berichten (data uit de News-composer) ── --}}
@if($newsItems)
  <section class="pb-20 pt-10 bg-triv-cream">
    <div class="page-container">

      {{-- Header --}}
      <div class="flex items-end justify-between mb-10">
        <h2 class="text-4xl font-bold text-gray-800 mb-0">Laatste nieuws</h2>
        <a href="{{ $newsArchiveUrl }}" class="inline-flex items-center gap-2 text-sm font-semibold text-triv-blue border-b-2 border-triv-yellow pb-0.5 no-underline hover:text-triv-pink transition-colors">
          Alle berichten →
        </a>
      </div>

      {{-- Magazine grid: groot artikel links, kleinere rechts --}}
      <div class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-6">
        <x-news-card :item="$newsItems[0]" size="large" />

        @if(count($newsItems) > 1)
          <div class="flex flex-col gap-6">
            @foreach(array_slice($newsItems, 1) as $item)
              <x-news-card :item="$item" />
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </section>
@endif
