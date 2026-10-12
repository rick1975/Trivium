{{-- ── FOTOHEADER — gewone pagina met uitgelichte afbeelding (data uit Composers\PageHero). Stijl per pagina (veld "Fotoheader"):
     - breed: schermbrede foto met de titel in een witte kaart die half over de onderrand valt; vanaf md rechts (zodat de
       kaart niet over de mensen links/midden valt), op mobiel over de volle breedte.
     - half: vanaf lg staat de foto rechts op 55% van de breedte en loopt naar links en onderen uit in het wit (hero-fade-mask);
       de titel staat groot links (2rem ingesprongen, op de lijn van de kaarttekst eronder) met de intro (eerste alinea
       van de inhoud) eronder, alles op crème. Achter de foto komen de rimpelcirkels van Snelle links vandaan,
       zichtbaar in het uitgelopen deel. De kenmerken-labels uit de inhoud staan onderaan over de foto (en zijn dan in de
       inhoud verborgen, zie .has-hero-half in css/app.css). Onder lg gelijk aan "breed".
     Vanaf lg ligt de header (80px) transparant over deze variant (zie .has-hero-half .banner in css/app.css): de foto
     loopt door tot de bovenrand van het scherm en de inhoud links schuift 5rem omlaag.
     Bij het laden komt de foto zacht in beeld en schuiven label en titel omhoog (niet bij "minder beweging"). ── --}}
@php($half = $layout === 'half')
<div @class(['relative', 'lg:flex lg:min-h-[calc(min(84svh,900px)+5rem)] lg:items-center lg:overflow-hidden lg:bg-triv-cream lg:pt-20' => $half])>
  @if($half)
    <img src="{{ Vite::asset('resources/images/shape-ripples.svg') }}" alt="" aria-hidden="true" decoding="async"
      class="pointer-events-none absolute left-[62%] top-[42%] hidden w-[1500px] max-w-none -translate-x-1/2 -translate-y-1/2 select-none lg:block motion-safe:animate-[hero-photo_1.6s_ease-out_both]">
  @endif

  <div @class([
    'h-[50svh] min-h-80 md:h-[62svh] max-h-[720px] overflow-hidden bg-triv-cream',
    'lg:absolute lg:inset-y-0 lg:right-0 lg:h-auto lg:max-h-none lg:w-[55%] lg:bg-transparent lg:hero-fade-mask' => $half,
  ])>
    {!! wp_get_attachment_image($image, 'full', false, [
      'class' => 'size-full max-w-none object-cover motion-safe:animate-[hero-photo_1.2s_ease-out_both]',
      'style' => "object-position: {$position}",
      'sizes' => $half ? '(min-width: 1024px) 55vw, 100vw' : '100vw',
      'loading' => 'eager',
      'fetchpriority' => 'high',
    ]) !!}
  </div>

  {{-- In de stijl "half" even breed als de brede inhoud eronder (--inhoud-breed in css/app.css) --}}
  <div @class(['page-container', 'lg:relative lg:max-w-[calc(var(--inhoud-breed)+3rem)]' => $half])>
    <div @class([
      'relative -mt-16 md:-mt-28 md:ml-auto md:max-w-xl rounded-2xl bg-white p-6 md:p-10 shadow-[0_20px_50px_-20px_rgb(11_31_58/0.35)]',
      'lg:my-0 lg:mr-0 lg:ml-8 lg:max-w-[42%] lg:rounded-none lg:bg-transparent lg:p-0 lg:shadow-none' => $half,
    ])>
      @if($parent)
        {{-- In de stijl "half" iets naar rechts: de grote titel eronder begint optisch iets later (witruimte vóór de letter) --}}
        <a href="{{ $parent['url'] }}" @class([
          'mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-triv-pink no-underline hover:text-triv-navy motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.15s_both]',
          'lg:ml-1' => $half,
        ])>
          <span class="size-1.5 rounded-full bg-current" aria-hidden="true"></span>
          {!! $parent['title'] !!}
        </a>
      @endif
      <h1 @class([
        'mb-0 text-4xl font-semibold md:text-5xl motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.3s_both]',
        'lg:text-6xl lg:leading-[1.05]' => $half,
      ])>{!! $title !!}</h1>

      @if($half && $intro)
        <p class="mt-6 mb-0 hidden text-xl leading-relaxed text-triv-navy lg:block xl:text-[1.375rem] motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.45s_both]">{!! $intro !!}</p>
      @endif
    </div>
  </div>

  @if($half && $features)
    <ul class="absolute bottom-10 right-0 mb-0 hidden w-[55%] flex-wrap justify-center gap-2 px-8 lg:flex motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.5s_both]">
      @foreach($features as $feature)
        <li class="mb-0 inline-flex items-center gap-2 rounded-full border border-[#ddd8cc] bg-white px-4 py-2 font-semibold text-triv-navy shadow-[0_8px_20px_-12px_rgb(11_31_58/0.4)]">
          <span class="size-2 rounded-full bg-triv-pink" aria-hidden="true"></span>
          {{ $feature }}
        </li>
      @endforeach
    </ul>
  @endif
</div>
