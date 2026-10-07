<footer class="footer group" x-data x-intersect.once.threshold.30="$el.dataset.shown = ''">
  {{-- Foto van de aula. Mobiel: met multiply door het nachtblauw gemengd als achtergrond, boven en onder
       zacht weglopend. Vanaf tablet 50/50: foto in eigen kleuren op de rechterhelft, loopt naar links
       weg in het effen nachtblauw. Schuift daar eenmalig van links op zijn plek zodra de footer in beeld komt
       (x-intersect zet data-shown op de footer). --}}
  <img src="{{ Vite::asset('resources/images/trivium-aula-trappen.avif') }}" alt="" loading="lazy" decoding="async"
    class="pointer-events-none absolute inset-0 size-full object-cover object-center contrast-110 mix-blend-multiply opacity-60 max-md:mask-t-from-80% max-md:mask-b-from-60% md:left-auto md:w-1/2 md:mix-blend-normal md:mask-l-from-60% md:mask-b-from-80% md:-translate-x-1/3 md:opacity-0 md:transition-[translate,opacity] md:duration-1200 md:ease-out md:group-data-shown:translate-x-0 md:group-data-shown:opacity-100 md:motion-reduce:translate-x-0! md:motion-reduce:opacity-100! motion-reduce:transition-none">

  <div class="relative w-full max-w-[1280px] mx-auto px-6">
    <div class="max-w-xl mx-auto text-center md:mx-0 md:w-1/2 md:pr-12 md:text-left">
      {{-- Footer Column 1 --}}
      <div>
        <h2 class="text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight mb-6">{{ $siteName }}</h2>
        <p class="text-white">
          Maak jouw toekomst bij Trivium College in Gorinchem. Praktijkgericht onderwijs dat écht bij jou past.</p>
        @if($contact->adres)
          <p>{!! nl2br(e($contact->adres)) !!}</p>
        @endif
        @if($contact->telefoon || $contact->email)
          <p>
            @if($contact->telefoon)
              {{ $contact->telefoon }}<br/>
              (bereikbaar van 08.00 - 16.30u)<br/>
            @endif
            @if($contact->email)
              {{ $contact->email }}
            @endif
          </p>
        @endif
      </div>
    </div>
  </div>
</footer>

@include('components.sitemap')

{{-- Copyright: zelfde nachtblauw als footer en sitemap, op dezelfde lijn --}}
<div class="py-6 bg-triv-navy border-t border-white/10">
  <div class="max-w-[1280px] mx-auto px-6">
    <div class="text-left text-xs md:text-sm text-white/60">
      &copy; {{ date('Y') }} {{ $siteName }}. Alle rechten voorbehouden.
    </div>
  </div>
</div>
