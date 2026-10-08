{{-- Eén <footer> (contentinfo) om het slide-deel, de sitemap en de copyright heen --}}
<footer>
<div data-slide class="footer group">
  {{-- Fotoslider: aula en fruitkrat; wisselt met een crossfade en een trage zoom.
       Navigatie: voortgangsstreepjes rechtsonder. Het actieve streepje loopt in 6 s vol (CSS-animatie footer-progress);
       aan het eind daarvan (animationend) volgt de volgende foto, dus pauzeren is de animatie stilzetten:
       buiten beeld en bij hover. Klik op een streepje: naar die foto en het wisselen stopt (zo is het stil te zetten).
       Bij "minder beweging" wisselt hij niet vanzelf; de streepjes werken dan als gewone knoppen.
       Mobiel: onder de tekst over de volle breedte, loopt bovenaan weg in het nachtblauw.
       Vanaf tablet 50/50: slider op de rechterhelft, loopt naar links weg in het effen nachtblauw. Schuift daar
       van links op zijn plek zodra de footer in beeld is geschoven (js/slide-sections.js zet data-shown).
       Het verloop zit op de foto's zelf zodat de streepjes scherp blijven. --}}
  <div x-data="{
      current: 0,
      count: {{ count($footer->slides) }},
      stopped: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
      inView: false,
      hover: false,
      get running() { return this.inView && ! this.hover && ! this.stopped },
      next() { this.current = (this.current + 1) % this.count },
      go(i) { this.current = i; this.stopped = true },
    }"
    x-intersect:enter="inView = true" x-intersect:leave="inView = false"
    @mouseenter="hover = true" @mouseleave="hover = false"
    class="relative order-last mt-10 w-full aspect-4/3 md:absolute md:inset-y-0 md:right-0 md:mt-0 md:h-full md:w-1/2 md:aspect-auto md:-translate-x-1/3 md:opacity-0 md:transition-[translate,opacity] md:duration-1200 md:ease-out md:group-data-shown:translate-x-0 md:group-data-shown:opacity-100 md:motion-reduce:translate-x-0! md:motion-reduce:opacity-100! motion-reduce:transition-none">
    @foreach($footer->slides as $slide)
      {{-- Actieve slide via data-active (Alpine haalt het attribuut weg bij false), zodat er nooit twee
           tegenstrijdige opacity/scale-classes tegelijk op staan --}}
      <figure aria-hidden="true" :data-active="current === {{ $loop->index }}" @if($loop->first) data-active @endif
        class="group/slide absolute inset-0 m-0 overflow-hidden opacity-0 transition-opacity duration-1500 ease-in-out data-active:opacity-100 motion-reduce:transition-none">
        <img src="{{ $slide->image }}" alt="" loading="lazy" decoding="async"
          class="pointer-events-none size-full object-cover object-center contrast-110 mask-t-from-70% md:mask-t-from-100% md:mask-l-from-60% md:mask-b-from-80% scale-108 transition-transform duration-7500 ease-out group-data-active/slide:scale-100 motion-reduce:scale-100! motion-reduce:transition-none">
      </figure>
    @endforeach

    {{-- Voortgangsstreepjes: eerdere foto's vol, actieve loopt vol (of staat vol als het wisselen stopt), latere leeg --}}
    <div class="absolute bottom-3 right-4 md:bottom-7 md:right-8 flex gap-1">
      @foreach($footer->slides as $slide)
        <button type="button" @click="go({{ $loop->index }})" :aria-current="current === {{ $loop->index }}"
          :data-state="current > {{ $loop->index }} || (stopped && current === {{ $loop->index }}) ? 'done' : (current === {{ $loop->index }} ? 'active' : null)"
          @if($loop->first) data-state="active" @endif
          class="group/bar py-3 px-0.5 cursor-pointer">
          <span class="sr-only">Toon foto {{ $loop->iteration }}</span>
          <span class="block h-0.5 w-10 md:w-12 overflow-hidden rounded-full bg-white/35 transition-colors group-hover/bar:bg-white/55">
            <span @animationend="next()" :style="{ animationPlayState: running ? 'running' : 'paused' }"
              class="block size-full origin-left scale-x-0 bg-white group-data-[state=done]/bar:scale-x-100 group-data-[state=active]/bar:animate-[footer-progress_6s_linear_forwards]"></span>
          </span>
        </button>
      @endforeach
    </div>
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
