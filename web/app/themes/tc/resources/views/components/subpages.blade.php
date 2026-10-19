{{-- ── ONDERLIGGENDE PAGINA'S — op een rubriekpagina (Leerlingen & ouders, Ons onderwijs, ...) een pil per onderdeel uit
     het hoofdmenu (Composers\Subpages), zodat je in één oogopslag ziet wat er in de rubriek staat. Zelfde pillen als de
     springlinks op Documenten: wit met een lichte rand, bij hover in de rubriekskleur (--accent).
     Twee plekken (prop "plek"): in de fotoheader "half" onder de intro (vanaf md, components/page-hero) en in de inhoud
     direct na de intro (op mobiel, en altijd bij een pagina zonder fotoheader "half"; zie .subpages-inhoud in css/app.css). ── --}}
@props(['plek' => 'inhoud'])

@if($items)
  <nav aria-label="In deze rubriek" @class([
    'subpages-inhoud mt-6 mb-0' => $plek === 'inhoud',
    'mt-8 hidden md:block motion-safe:animate-[hero-rise_.9s_cubic-bezier(.2,.8,.2,1)_.5s_both]' => $plek === 'hero',
  ])>
    <ul class="mb-0 flex flex-wrap gap-2">
      @foreach($items as $item)
        <li class="mb-0"><a href="{{ $item['url'] }}" @if($item['extern']) target="_blank" rel="noopener" @endif
          class="inline-flex items-center gap-2 rounded-full border border-[#ddd8cc] bg-white px-4 py-2 text-sm font-semibold text-triv-navy no-underline transition-colors hover:border-(--accent) hover:bg-(--accent) hover:text-white lg:text-base">{{ $item['title'] }}@if($item['extern'])<span class="sr-only"> (opent in een nieuw tabblad)</span>@endif</a></li>
      @endforeach
    </ul>
  </nav>
@endif
