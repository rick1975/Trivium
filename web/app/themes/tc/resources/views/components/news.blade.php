{{-- ── NIEUWS — de vier nieuwste berichten (data uit de News-composer) ── --}}
@if($newsItems)
  <section class="pb-20 pt-10 bg-triv-cream">
    <div class="page-container">

      {{-- Header --}}
      <div class="mb-10">
        <h2 class="text-4xl md:text-5xl xl:text-6xl font-bold text-triv-navy mb-0">Nieuws</h2>
      </div>

      <x-news-featured :items="$newsItems">
        <x-button :href="$newsArchiveUrl" :dot="false">Alle berichten</x-button>
      </x-news-featured>
    </div>
  </section>
@endif
