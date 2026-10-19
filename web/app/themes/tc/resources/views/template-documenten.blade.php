{{--
  Template Name: Documenten
--}}

{{-- ── DOCUMENTEN — paginatekst met daaronder downloads per rubriek (ACF-velden van de pagina, Composers\Documents).
     Bovenaan springlinks naar de rubrieken; elk document is een witte kaart in de stijl van de Snelle links-knoppen,
     met bestandstype en -grootte. Iconen en hover in de rubriekskleur (--accent). ── --}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    @include('partials.content-page')

    @if($rubrieken)
      {{-- Springlinks naar de rubrieken --}}
      <nav aria-label="Rubrieken" class="mb-12">
        <ul class="flex flex-wrap gap-2">
          @foreach($rubrieken as $rubriek)
            <li><a href="#{{ $rubriek['id'] }}" class="inline-block rounded-full border border-[#ddd8cc] bg-white px-4 py-2 text-sm font-semibold text-triv-navy no-underline transition-colors hover:border-(--accent) hover:bg-(--accent) hover:text-white">{{ $rubriek['title'] }}</a></li>
          @endforeach
        </ul>
      </nav>

      @foreach($rubrieken as $rubriek)
        <section id="{{ $rubriek['id'] }}" class="mb-12 scroll-mt-28" aria-labelledby="{{ $rubriek['id'] }}-titel">
          <h2 id="{{ $rubriek['id'] }}-titel" class="text-2xl md:text-3xl text-triv-navy">{{ $rubriek['title'] }}</h2>
          <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-0">
            @foreach($rubriek['documents'] as $document)
              <li class="mb-0"><a href="{{ $document['url'] }}" class="group flex h-full items-center gap-4 rounded-xl bg-white border border-gray-200 px-5 py-4 no-underline shadow-[0_1px_2px_rgb(11_31_58/0.04)] transition-colors duration-200 hover:border-(--accent)">
                <x-icon name="document" class="size-6 shrink-0 text-(--accent)" />
                <span class="flex-1 min-w-0">
                  <span class="block font-bold leading-snug text-triv-navy transition-colors group-hover:text-(--accent)">{{ $document['title'] }}</span>
                  <span class="block text-xs text-gray-500">{{ $document['type'] }}@if($document['size']) · {{ $document['size'] }}@endif</span>
                </span>
                <x-icon name="download" class="size-5 shrink-0 stroke-2 text-(--accent) transition-transform duration-200 group-hover:translate-y-0.5" />
              </a></li>
            @endforeach
          </ul>
        </section>
      @endforeach
    @endif
  @endwhile
@endsection
