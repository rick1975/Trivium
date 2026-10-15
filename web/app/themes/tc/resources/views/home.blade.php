{{-- Nieuwsoverzicht (berichtenpagina /nieuws/, Instellingen > Lezen; data uit Composers\NewsArchive). Crème vlak met
     de titel, op de eerste pagina het nieuwste bericht groot met de drie volgende ernaast (components/news-featured,
     als op de voorpagina), de overige als kaarten in een raster, en paginering. --}}
@extends('layouts.app')

@section('before-main')
  <section class="bg-triv-cream pt-10 pb-20 md:pt-16">
    <div class="page-container">
      <h1 class="mb-0 text-4xl font-bold text-triv-navy md:text-5xl xl:text-6xl">{!! $title !!}</h1>
      @if($intro)
        <div class="mt-4 max-w-2xl text-lg leading-relaxed text-triv-navy">{!! wpautop($intro) !!}</div>
      @endif

      @if($featured)
        <div class="mt-10">
          <x-news-featured :items="$featured" />
        </div>
      @endif

      @if($tiles)
        <ul @class([
          'mb-0 grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3',
          'mt-16 border-t border-[#ddd8cc] pt-12' => $featured,
          'mt-10' => ! $featured,
        ])>
          @foreach($tiles as $item)
            <li class="mb-0">
              <x-news-card :item="$item" size="tile" />
            </li>
          @endforeach
        </ul>
      @endif

      @if($pagination)
        <nav aria-label="{{ __('Meer berichten', 'sage') }}" class="mt-16 flex flex-wrap items-center justify-center gap-2
          [&_.page-numbers]:inline-flex [&_.page-numbers]:min-w-11 [&_.page-numbers]:h-11 [&_.page-numbers]:items-center [&_.page-numbers]:justify-center [&_.page-numbers]:rounded-full [&_.page-numbers]:px-4 [&_.page-numbers]:text-sm [&_.page-numbers]:font-semibold [&_.page-numbers]:no-underline
          [&_a.page-numbers]:bg-white [&_a.page-numbers]:text-triv-navy [&_a.page-numbers]:transition-colors [&_a.page-numbers:hover]:bg-triv-pink [&_a.page-numbers:hover]:text-white
          [&_.current]:bg-triv-navy [&_.current]:text-white [&_.dots]:text-stone-500">
          @foreach($pagination as $link)
            {!! $link !!}
          @endforeach
        </nav>
      @endif
    </div>
  </section>
@endsection
