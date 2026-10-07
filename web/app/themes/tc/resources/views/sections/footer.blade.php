<footer data-slide class="footer group">
  {{-- Foto van de aula. Mobiel: onder de tekst over de volle breedte, loopt bovenaan weg in het nachtblauw.
       Vanaf tablet 50/50: foto op de rechterhelft, loopt naar links weg in het effen nachtblauw. Schuift daar
       van links op zijn plek zodra de footer in beeld is geschoven (js/slide-sections.js zet data-shown). --}}
  <img src="{{ $footer->image }}" alt="" loading="lazy" decoding="async"
    class="pointer-events-none order-last mt-10 w-full aspect-[4/3] object-cover object-center contrast-110 mask-t-from-70% md:absolute md:inset-y-0 md:right-0 md:mt-0 md:h-full md:w-1/2 md:aspect-auto md:mask-t-from-100% md:mask-l-from-60% md:mask-b-from-80% md:-translate-x-1/3 md:opacity-0 md:transition-[translate,opacity] md:duration-1200 md:ease-out md:group-data-shown:translate-x-0 md:group-data-shown:opacity-100 md:motion-reduce:translate-x-0! md:motion-reduce:opacity-100! motion-reduce:transition-none">

  <div class="relative page-container">
    <div class="max-w-xl md:w-1/2 md:pr-12">
      {{-- Titel, tekst en foto uit Trivium Settings > Footer (Composers\Footer), contact uit Contactgegevens --}}
      <div>
        <h2 class="text-5xl xl:text-6xl text-white leading-tight mb-6">{{ $footer->title }}</h2>
        @if($footer->text)
          <p class="text-white">{!! nl2br(e($footer->text)) !!}</p>
        @endif
        @if($contact->adres)
          <p>{!! nl2br(e($contact->adres)) !!}</p>
        @endif
        @if($contact->telefoon || $contact->email)
          <p>
            @if($contact->telefoon)
              {{ $contact->telefoon }}<br/>
              @if($contact->bereikbaar)
                ({{ $contact->bereikbaar }})<br/>
              @endif
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
  <div class="page-container">
    <div class="text-left text-xs md:text-sm text-white/60">
      &copy; {{ date('Y') }} {{ $siteName }}. Alle rechten voorbehouden.
    </div>
  </div>
</div>
