{{-- ── FOTOHEADER "KADER" — variant van de fotoheader (veld "Fotoheader", data uit Composers\PageHero, ingevoegd vanuit
     components/page-hero). Op crème: links het label (zacht navy), de titel in de rubriekskleur (--accent), de intro
     (eerste alinea van de inhoud) en de kenmerken-labels; rechts de foto in een afgerond kader, met daarachter een
     verschoven vlak in de tint van de rubriek (--accent-vlak). Geen vervaging en geen rimpelcirkels; de header blijft
     gewoon boven de foto. Op mobiel de foto bovenaan, titel eronder (intro en labels staan dan in de inhoud, zie
     .has-hero-kader in css/app.css). ── --}}
<div class="bg-triv-cream">
  <div class="page-container pt-6 pb-2 md:max-w-[calc(var(--inhoud-breed)+3rem)] md:grid md:grid-cols-2 md:items-center md:gap-12 md:py-12 lg:gap-20 lg:py-16">
    <div class="relative mr-3 mb-3 md:order-last md:mr-5 md:mb-5">
      <div class="absolute inset-0 translate-x-3 translate-y-3 rounded-[2rem] bg-(--accent-vlak) md:translate-x-5 md:translate-y-5" aria-hidden="true"></div>
      <div class="relative aspect-4/3 overflow-hidden rounded-[2rem] md:aspect-4/5 lg:aspect-5/4">
        {!! wp_get_attachment_image($image, 'full', false, [
          'class' => 'size-full max-w-none object-cover motion-safe:animate-[hero-photo_1.2s_ease-out_both]',
          'style' => "object-position: {$position}",
          'sizes' => '(min-width: 768px) 50vw, 100vw',
          'loading' => 'eager',
          'fetchpriority' => 'high',
        ]) !!}
      </div>
    </div>

    <div class="mt-8 md:mt-0 md:pl-8">
      @if($parent)
        <a href="{{ $parent['url'] }}" class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-triv-navy/55 no-underline hover:text-(--accent) motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.15s_both]">
          <span class="size-1.5 rounded-full bg-(--accent)" aria-hidden="true"></span>
          {!! $parent['title'] !!}
        </a>
      @endif
      <h1 class="mb-0 text-4xl font-semibold text-(--accent) md:text-5xl md:leading-[1.05] lg:text-6xl motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.3s_both]">{!! $title !!}</h1>

      @if($intro)
        <p class="hero-intro mt-6 mb-0 hidden text-lg leading-relaxed text-triv-navy md:block lg:text-xl motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.45s_both]">{!! $intro !!}</p>
      @endif

      @if($features)
        <ul class="mt-8 mb-0 hidden flex-wrap gap-2 pl-0 md:flex motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.5s_both]">
          @foreach($features as $feature)
            <li class="mb-0 inline-flex items-center gap-2 rounded-full border border-[#ddd8cc] bg-white px-4 py-2 font-semibold text-triv-navy shadow-[0_8px_20px_-12px_rgb(11_31_58/0.4)]">
              <span class="size-2 rounded-full bg-(--accent)" aria-hidden="true"></span>
              {{ $feature }}
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</div>
