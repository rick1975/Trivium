{{-- Eén <footer> (contentinfo) om het slide-deel, de sitemap en de copyright heen --}}
<footer>
<div data-slide class="footer group">
  {{-- Fotoslider: aula en fruitkrat; wisselt elke 6 s met een crossfade en een trage zoom.
       Draait alleen in beeld, pauzeert bij hover en via de knop; bij "minder beweging" blijft de eerste foto staan.
       Mobiel: onder de tekst over de volle breedte, loopt bovenaan weg in het nachtblauw.
       Vanaf tablet 50/50: slider op de rechterhelft, loopt naar links weg in het effen nachtblauw. Schuift daar
       van links op zijn plek zodra de footer in beeld is geschoven (js/slide-sections.js zet data-shown).
       Het verloop zit op de foto's zelf zodat de pauzeknop scherp blijft. --}}
  <div x-data="{
      current: 0,
      count: {{ count($footer->slides) }},
      paused: false,
      hover: false,
      timer: null,
      start() {
        if (this.timer || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        this.timer = setInterval(() => { if (! this.paused && ! this.hover) this.current = (this.current + 1) % this.count }, 6000);
      },
      stop() { clearInterval(this.timer); this.timer = null },
    }"
    x-intersect:enter="start()" x-intersect:leave="stop()"
    @mouseenter="hover = true" @mouseleave="hover = false"
    class="relative order-last mt-10 w-full aspect-4/3 md:absolute md:inset-y-0 md:right-0 md:mt-0 md:h-full md:w-1/2 md:aspect-auto md:-translate-x-1/3 md:opacity-0 md:transition-[translate,opacity] md:duration-1200 md:ease-out md:group-data-shown:translate-x-0 md:group-data-shown:opacity-100 md:motion-reduce:translate-x-0! md:motion-reduce:opacity-100! motion-reduce:transition-none">
    @foreach($footer->slides as $slide)
      <figure aria-hidden="true" :class="current === {{ $loop->index }} ? 'opacity-100' : 'opacity-0'"
        class="absolute inset-0 m-0 overflow-hidden transition-opacity duration-1500 ease-in-out motion-reduce:transition-none {{ $loop->first ? 'opacity-100' : 'opacity-0' }}">
        <img src="{{ $slide->image }}" alt="" loading="lazy" decoding="async"
          :class="current === {{ $loop->index }} ? 'scale-100' : 'scale-108'"
          class="pointer-events-none size-full object-cover object-center contrast-110 mask-t-from-70% md:mask-t-from-100% md:mask-l-from-60% md:mask-b-from-80% transition-transform duration-7500 ease-out motion-reduce:scale-100! motion-reduce:transition-none {{ $loop->first ? 'scale-100' : 'scale-108' }}">
      </figure>
    @endforeach

    {{-- Pauzeknop (bewegende inhoud moet stil te zetten zijn); niet nodig bij "minder beweging" --}}
    <button type="button" @click="paused = ! paused" :aria-pressed="paused.toString()"
      class="absolute bottom-4 right-4 md:bottom-8 md:right-8 grid size-10 place-items-center rounded-full border border-white/15 bg-triv-navy/70 text-white backdrop-blur-sm transition-colors hover:bg-triv-navy motion-reduce:hidden">
      <span class="sr-only">Fotowisseling pauzeren</span>
      <svg x-show="! paused" width="14" height="14" viewBox="0 0 14 14" fill="currentColor" aria-hidden="true"><rect x="2" y="1" width="3.5" height="12" rx="1"/><rect x="8.5" y="1" width="3.5" height="12" rx="1"/></svg>
      <svg x-show="paused" style="display: none" width="14" height="14" viewBox="0 0 14 14" fill="currentColor" aria-hidden="true"><path d="M3 1.5v11a1 1 0 0 0 1.5.86l9-5.5a1 1 0 0 0 0-1.72l-9-5.5A1 1 0 0 0 3 1.5Z"/></svg>
    </button>
  </div>

  <div class="relative page-container">
    <div class="max-w-xl md:w-1/2 md:pr-12">
      {{-- Titel, tekst en foto uit Trivium Settings > Footer (Composers\Footer), contact uit Contactgegevens --}}
      <div>
        <h2 class="text-5xl xl:text-6xl text-white leading-tight mb-6">{{ $footer->title }}</h2>
        @if($footer->text)
          <p class="text-white">{!! nl2br(e($footer->text)) !!}</p>
        @endif
        @if($contact->adres || $contact->telefoon || $contact->email)
          <address class="not-italic">
            @if($contact->adres)
              <p>{!! nl2br(e($contact->adres)) !!}</p>
            @endif
            @if($contact->telefoon || $contact->email)
              <p>
                @if($contact->telefoon)
                  <a href="tel:{{ $contact->telefoonLink }}">{{ $contact->telefoon }}</a><br/>
                  @if($contact->bereikbaar)
                    ({{ $contact->bereikbaar }})<br/>
                  @endif
                @endif
                @if($contact->email)
                  <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                @endif
              </p>
            @endif
          </address>
        @endif
      </div>
    </div>
  </div>
</div>

@include('components.sitemap')

{{-- Copyright: zelfde nachtblauw als footer en sitemap, op dezelfde lijn --}}
<div class="py-6 bg-triv-navy border-t border-white/10">
  <div class="page-container">
    <p class="mb-0 text-left text-xs md:text-sm text-white/60">
      &copy; {{ date('Y') }} {{ $siteName }}. Alle rechten voorbehouden.
    </p>
  </div>
</div>
</footer>
