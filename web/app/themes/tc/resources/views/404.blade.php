{{-- 404: zelfde opbouw als de fotoheader "half" (components/page-hero.blade.php): foto rechts die naar links en onderen
     uitloopt in het crème, de rimpelcirkels erachter en de tekst links. Op mobiel de foto bovenaan met de golfboog eronder.
     Body-class has-hero-half (app/filters.php): vanaf md ligt de header transparant over de foto.
     Populaire pagina's komen uit Composers\Menu (Trivium Settings > Menu en zoeken), net als in het zoekpaneel. --}}
@extends('layouts.app')

@section('before-main')
  <section class="relative bg-triv-cream md:flex md:min-h-[calc(min(90svh,960px)+5rem)] md:items-center md:pt-20">
    {{-- Rimpelcirkels: zelfde plek en grootte als in de fotoheader "half" --}}
    <div class="pointer-events-none absolute inset-0 z-[1] overflow-hidden opacity-80 [mask-image:linear-gradient(to_bottom,#000_calc(100%-4rem),transparent)] md:z-auto md:opacity-100 md:[mask-image:none]" aria-hidden="true">
      <div class="absolute left-full top-[calc(clamp(20rem,50svh,720px)+2rem)] w-[1500px] max-w-none -translate-x-1/2 -translate-y-1/2 -rotate-45 select-none md:left-[62%] md:top-[42%] md:rotate-0 motion-safe:animate-[hero-photo_1.6s_ease-out_both] [&>svg]:block [&>svg]:h-auto [&>svg]:w-full">{!! file_get_contents(get_theme_file_path('resources/images/shape-ripples-animated.svg')) !!}</div>
    </div>

    <div class="relative h-[50svh] min-h-80 max-h-[720px] overflow-hidden bg-triv-cream md:absolute md:inset-y-0 md:right-0 md:h-auto md:max-h-none md:w-[55%] md:bg-transparent md:hero-fade-mask">
      <img src="{{ Vite::asset('resources/images/leerling-vangt-volleybal.avif') }}" alt="Leerling vangt een volleybal in de gymzaal, klasgenoten kijken toe"
        width="2400" height="1600" loading="eager" fetchpriority="high" decoding="async"
        class="size-full max-w-none object-cover object-[70%_center] motion-safe:animate-[hero-photo_1.2s_ease-out_both]">
      {{-- Mobiel: golfboog onderaan de foto naar het crème eronder (zelfde boog als components/wave-divider) --}}
      <svg class="absolute inset-x-0 -bottom-px block h-8 w-full fill-triv-cream md:hidden" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,0 Q720,80 1440,0 L1440,80 L0,80 Z"/>
      </svg>
    </div>

    <div class="page-container relative z-[2] pb-16 md:z-auto md:max-w-[calc(var(--inhoud-breed)+3rem)] md:pb-0">
      <div class="relative pt-4 md:my-0 md:ml-8 md:mr-0 md:max-w-[42%] md:p-0">
        <p class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-triv-navy/55 md:ml-1 motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.15s_both]">
          <span class="size-1.5 rounded-full bg-(--accent)" aria-hidden="true"></span>
          {{ __('Foutcode 404', 'sage') }}
        </p>

        <h1 class="mb-0 text-4xl font-semibold text-(--accent) md:text-5xl md:leading-[1.05] lg:text-6xl motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.3s_both]">
          {{ __('Mis! Deze pagina bestaat niet', 'sage') }}
        </h1>

        <p class="mt-6 mb-0 text-lg leading-relaxed text-triv-navy lg:text-xl motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.45s_both]">
          {{ __('De bal ging net naast. De pagina die je zoekt is verplaatst of bestaat niet meer. Zoek hieronder verder of ga terug naar de homepage.', 'sage') }}
        </p>

        <div class="motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.55s_both]">
          {{-- Zoekveld in de stijl van het zoekpaneel (components/search-panel.blade.php) --}}
          <form role="search" method="GET" action="{{ home_url('/') }}" class="mt-8 flex max-w-md items-center gap-3 rounded-full border border-[#ddd8cc] bg-white px-6 py-3.5 transition-all duration-200 focus-within:border-triv-blue focus-within:shadow-[0_6px_28px_rgba(0,66,137,.12)]">
            <button type="submit" class="shrink-0 cursor-pointer text-[#7a7060] transition-colors hover:text-triv-blue" aria-label="{{ __('Zoeken uitvoeren', 'sage') }}">
              <x-icon name="search" :size="18" />
            </button>
            <input type="search" name="s" required placeholder="{{ __('Waar ben je naar op zoek?', 'sage') }}" aria-label="{{ __('Zoeken', 'sage') }}"
              class="w-full border-none bg-transparent text-base text-[#1a1612] outline-none placeholder:text-[#7a7060]">
          </form>

          <x-button :href="home_url('/')" class="mt-6">{{ __('Naar de homepage', 'sage') }}</x-button>

          @if($popularPages)
            <h2 class="mt-10 mb-3 text-xs font-semibold uppercase tracking-widest text-triv-navy/55 [font-family:inherit]">{{ __("Populaire pagina's", 'sage') }}</h2>
            <ul class="mb-0 flex flex-wrap gap-2">
              @foreach($popularPages as $page)
                <li class="mb-0">
                  <a href="{{ $page->url }}" @if($page->extern ?? false) target="_blank" rel="noopener" @endif
                    class="inline-flex items-center gap-2 rounded-full border border-[#ddd8cc] bg-white px-4 py-2 text-sm font-medium text-triv-navy/70 no-underline shadow-[0_8px_20px_-12px_rgb(11_31_58/0.4)] transition-colors hover:border-(--accent) hover:text-(--accent)">
                    <span class="size-2 rounded-full bg-(--accent)" aria-hidden="true"></span>
                    {{ $page->title }}
                  </a>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection
