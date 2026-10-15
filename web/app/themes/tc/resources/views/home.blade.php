{{-- Nieuwsoverzicht (berichtenpagina /nieuws/, Instellingen > Lezen; data uit Composers\NewsArchive). Crème vlak met
     de titel, alle berichten als kaarten in een raster (geen groot bericht zoals op de voorpagina) en paginering. --}}
@extends('layouts.app')

@section('before-main')
  <section class="bg-triv-cream pt-10 pb-20 md:pt-16">
    <div class="page-container">
      {{-- Titel en intro zoals op de andere pagina's (components/page-hero): 600, in de accentkleur, en schuift bij het laden omhoog.
           Label erboven zoals daar het rubriekslabel, met een knipoog naar het gratis fruit: "Vers geplukt / Nieuws" --}}
      <p class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-triv-navy/55 md:ml-1 motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.15s_both]">
        <span class="size-1.5 rounded-full bg-(--accent)" aria-hidden="true"></span>
        Vers geplukt
      </p>
      <h1 class="mb-0 text-4xl font-semibold text-(--accent) md:text-5xl md:leading-[1.05] lg:text-6xl motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.3s_both]">{!! $title !!}</h1>
      @if($intro)
        <div class="mt-6 max-w-2xl text-xl leading-relaxed text-triv-navy md:text-[1.375rem] [&>p:last-child]:mb-0 motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.45s_both]">{!! wpautop($intro) !!}</div>
      @endif

      @if($tiles)
        <ul class="mt-10 mb-0 grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3 md:mt-14">
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
