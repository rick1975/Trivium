{{-- ── FOTOHEADER — gewone pagina met uitgelichte afbeelding (data uit Composers\PageHero). Stijl per pagina (veld "Fotoheader"):
     - breed: schermbrede foto met de titel in een witte kaart die half over de onderrand valt; vanaf md rechts (zodat de
       kaart niet over de mensen links/midden valt), op mobiel over de volle breedte.
     - half: vanaf md staat de foto rechts op 55% van de breedte en loopt naar links en onderen uit in het wit (hero-fade-mask);
       de titel staat groot links (2rem ingesprongen, op de lijn van de kaarttekst eronder) met de intro (eerste alinea
       van de inhoud) eronder, alles op crème. Achter de foto komen de rimpelcirkels van Snelle links vandaan,
       zichtbaar in het uitgelopen deel. De kenmerken-labels uit de inhoud staan onderaan over de foto (en zijn dan in de
       inhoud verborgen, zie .has-hero-half in css/app.css). Op mobiel (onder md) gelijk aan "breed"; op tablet
       (md tot lg) is de titel kleiner en de fotoheader minder hoog.
     Op mobiel staat de titel zonder wit vlak op het crème onder de foto, met de rimpelcirkels licht erachter (onderaan
       vervagend, zodat ze niet hard afgesneden worden).
     Vanaf md ligt de header (80px) transparant over deze variant (zie .has-hero-half .banner in css/app.css): de foto
     loopt door tot de bovenrand van het scherm en de inhoud links schuift 5rem omlaag.
     Bij het laden komt de foto zacht in beeld en schuiven label en titel omhoog (niet bij "minder beweging"). ── --}}
@php($half = $layout === 'half')
<div @class(['relative', 'bg-triv-cream md:flex md:min-h-[calc(min(70svh,960px)+5rem)] md:items-center md:overflow-hidden md:bg-triv-cream md:pt-20 lg:min-h-[calc(min(90svh,960px)+5rem)]' => $half])>
  @if($half)
    <div class="pointer-events-none absolute inset-0 overflow-hidden opacity-40 [mask-image:linear-gradient(to_bottom,#000_60%,transparent)] md:opacity-100 md:[mask-image:none]" aria-hidden="true">
      <img src="{{ Vite::asset('resources/images/shape-ripples.svg') }}" alt="" decoding="async"
        class="absolute left-[85%] top-[clamp(20rem,50svh,720px)] w-[800px] max-w-none -translate-x-1/2 -translate-y-1/2 select-none md:left-[62%] md:top-[42%] md:w-[1500px] motion-safe:animate-[hero-photo_1.6s_ease-out_both]">
    </div>
  @endif

  <div @class([
    'h-[50svh] min-h-80 max-h-[720px] overflow-hidden bg-triv-cream',
    'md:h-[62svh]' => ! $half,
    'relative md:absolute md:inset-y-0 md:right-0 md:h-auto md:max-h-none md:w-[55%] md:bg-transparent md:hero-fade-mask' => $half,
  ])>
    {!! wp_get_attachment_image($image, 'full', false, [
      'class' => 'size-full max-w-none object-cover motion-safe:animate-[hero-photo_1.2s_ease-out_both]',
      'style' => "object-position: {$position}",
      'sizes' => $half ? '(min-width: 768px) 55vw, 100vw' : '100vw',
      'loading' => 'eager',
      'fetchpriority' => 'high',
    ]) !!}
  </div>

  {{-- In de stijl "half" even breed als de brede inhoud eronder (--inhoud-breed in css/app.css) --}}
  <div @class(['page-container', 'relative md:max-w-[calc(var(--inhoud-breed)+3rem)]' => $half])>
    <div @class([
      'relative',
      '-mt-16 rounded-2xl bg-white p-6 shadow-[0_20px_50px_-20px_rgb(11_31_58/0.35)] md:-mt-28 md:ml-auto md:max-w-xl md:p-10' => ! $half,
      'pt-8 md:my-0 md:mr-0 md:ml-8 md:max-w-[42%] md:p-0' => $half,
    ])>
      @if($parent)
        {{-- In de stijl "half" iets naar rechts: de grote titel eronder begint optisch iets later (witruimte vóór de letter) --}}
        <a href="{{ $parent['url'] }}" @class([
          'mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest no-underline motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.15s_both]',
          'text-triv-pink hover:text-triv-navy' => ! $half,
          'text-triv-navy/55 hover:text-triv-pink md:ml-1' => $half,
        ])>
          <span class="size-1.5 rounded-full bg-current" aria-hidden="true"></span>
          {!! $parent['title'] !!}
        </a>
      @endif
      {{-- Stijl "half": titel in oudroze (#c25e78, contrast op crème ca. 3,9:1), het label erboven zacht navy --}}
      <h1 @class([
        'mb-0 text-4xl font-semibold md:text-5xl motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.3s_both]',
        'text-[#c25e78] md:leading-[1.05] lg:text-6xl' => $half,
      ])>{!! $title !!}</h1>

      @if($half && $intro)
        <p class="mt-6 mb-0 hidden text-xl leading-relaxed text-triv-navy md:block md:text-lg lg:text-xl xl:text-[1.375rem] motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.45s_both]">{!! $intro !!}</p>
      @endif
    </div>
  </div>

  @if($half && $features)
    <ul class="absolute bottom-10 right-0 mb-0 hidden w-[55%] flex-wrap justify-center gap-2 px-4 md:flex lg:px-8 motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.5s_both]">
      @foreach($features as $feature)
        <li class="mb-0 inline-flex items-center gap-2 rounded-full border border-[#ddd8cc] bg-white px-4 py-2 font-semibold text-triv-navy shadow-[0_8px_20px_-12px_rgb(11_31_58/0.4)]">
          <span class="size-2 rounded-full bg-triv-pink" aria-hidden="true"></span>
          {{ $feature }}
        </li>
      @endforeach
    </ul>
  @endif
</div>
