{{-- Groot bericht links; vanaf lg rechts daarnaast, achter een verticale lijn, de volgende berichten als lijst met een
     kleine foto (op mobiel eronder, achter een horizontale lijn). Onder de lijst optioneel een slot (bv. de knop
     "Alle berichten" op de voorpagina). Gebruikt op de voorpagina (components/news) en in het nieuwsoverzicht (home). --}}
@props(['items'])

<div class="grid grid-cols-1 gap-8 lg:grid-cols-[1.5fr_1fr] lg:gap-0">
  <x-news-card :item="$items[0]" size="large" />
  @if(count($items) > 1 || $slot->isNotEmpty())
    <div class="border-t border-[#ddd8cc] pt-8 lg:ml-10 lg:border-t-0 lg:border-l lg:pt-0 lg:pl-10">
      @if(count($items) > 1)
        <ul @class(['flex flex-col gap-6', 'mb-8' => $slot->isNotEmpty(), 'mb-0' => $slot->isEmpty()])>
          @foreach(array_slice($items, 1) as $item)
            <li class="mb-0">
              <x-news-card :item="$item" size="row" />
            </li>
          @endforeach
        </ul>
      @endif
      {{ $slot }}
    </div>
  @endif
</div>
