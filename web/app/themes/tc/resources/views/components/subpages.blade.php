{{-- ── ONDERLIGGENDE PAGINA'S — op een rubriekpagina (Leerlingen & ouders, Ons onderwijs, ...) een kaart per onderdeel uit
     het hoofdmenu (Composers\Subpages): foto (de uitgelichte afbeelding, anders een vlak in de tint van de rubriek),
     titel en het begin van de eerste alinea. Mobiel onder elkaar, vanaf sm twee en vanaf lg drie naast elkaar.
     Titel en pijltje kleuren bij hover in de rubriekskleur (--accent); de foto zoomt iets in, zoals bij de snelle links. ── --}}
@if($items)
  <section aria-labelledby="subpages-titel" class="page-container pb-20 md:pb-28 md:max-w-[calc(var(--inhoud-breed)+3rem)]">
    <h2 id="subpages-titel" class="sr-only">In deze rubriek</h2>
    <ul class="mb-0 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
      @foreach($items as $item)
        <li class="mb-0">
          <a href="{{ $item['url'] }}" @if($item['extern']) target="_blank" rel="noopener" @endif
            class="group flex h-full flex-col overflow-hidden rounded-2xl bg-white no-underline shadow-[0_12px_30px_-20px_rgb(120_70_40/0.1)]">
            <span class="block aspect-[3/2] overflow-hidden bg-[color-mix(in_oklab,var(--accent-vlak,var(--color-triv-vlak))_60%,white)]">
              @if($item['image'])
                {!! wp_get_attachment_image($item['image'], 'medium_large', false, [
                  'alt' => '',
                  'loading' => 'lazy',
                  'sizes' => '(min-width: 1024px) 400px, (min-width: 640px) 50vw, 100vw',
                  'class' => 'size-full max-w-none object-cover transition-transform duration-500 group-hover:scale-105',
                ]) !!}
              @endif
            </span>
            <span class="flex flex-1 flex-col p-6">
              <span class="flex items-center justify-between gap-3 text-xl font-bold leading-snug text-triv-navy transition-colors group-hover:text-(--accent)">
                {{ $item['title'] }}
                <x-icon name="chevron-right" class="size-3.5 shrink-0 stroke-[2.5] text-(--accent) transition-transform duration-200 group-hover:translate-x-1" />
              </span>
              @if($item['excerpt'])
                <span class="mt-2 block text-base leading-relaxed text-stone-600">{{ $item['excerpt'] }}</span>
              @endif
              @if($item['extern'])<span class="sr-only">(opent in een nieuw tabblad)</span>@endif
            </span>
          </a>
        </li>
      @endforeach
    </ul>
  </section>
@endif
