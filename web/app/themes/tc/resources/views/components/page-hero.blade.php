{{-- ── FOTOHEADER — gewone pagina met uitgelichte afbeelding (data uit Composers\PageHero). Schermbrede foto met de titel
     in een witte kaart die half over de onderrand valt: vanaf md rechts (zodat de kaart niet over de mensen links/midden
     valt), op mobiel over de volle breedte. Het focuspunt komt uit het veld "Fotoheader" van de pagina. ── --}}
<div class="relative">
  <div class="h-[50svh] min-h-80 md:h-[62svh] max-h-[720px] overflow-hidden bg-triv-cream">
    {!! wp_get_attachment_image($image, 'full', false, [
      'class' => 'size-full max-w-none object-cover',
      'style' => "object-position: {$position}",
      'sizes' => '100vw',
      'loading' => 'eager',
      'fetchpriority' => 'high',
    ]) !!}
  </div>

  <div class="page-container">
    <div class="relative -mt-16 md:-mt-28 md:ml-auto md:max-w-xl rounded-2xl bg-white p-6 md:p-10 shadow-[0_20px_50px_-20px_rgb(11_31_58/0.35)]">
      @if($parent)
        <a href="{{ $parent['url'] }}" class="mb-2 inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-wider text-triv-pink no-underline hover:text-triv-navy">
          <span class="size-1.5 rounded-full bg-current" aria-hidden="true"></span>
          {{ $parent['title'] }}
        </a>
      @endif
      <h1 class="mb-0 text-4xl md:text-5xl">{!! $title !!}</h1>
    </div>
  </div>
</div>
