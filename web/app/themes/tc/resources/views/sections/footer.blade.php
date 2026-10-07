<footer class="footer">
  {{-- Foto van de aula die in het blauw opgaat: met multiply door het footer-blauw gemengd;
       loopt via maskers boven en onder zacht weg in het effen blauw --}}
  <img src="{{ Vite::asset('resources/images/trivium-aula-trappen.avif') }}" alt="" loading="lazy" decoding="async"
    class="pointer-events-none absolute inset-0 size-full object-cover object-center contrast-110 mix-blend-multiply opacity-60 mask-t-from-80% mask-b-from-60% lg:opacity-75">

  <div class="container relative w-full">
    <div class="max-w-xl mx-auto text-center">
      {{-- Footer Column 1 --}}
      <div>
        <h3 class="text-lg font-semibold mb-4 text-white">{{ $siteName }}</h3>
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

{{-- Copyright Section (Outside primary color background) --}}
<div class="bg-white py-6">
  <div class="container">
    <div class="text-center text-xs md:text-sm text-gray-600">
      &copy; {{ date('Y') }} {{ $siteName }}. Alle rechten voorbehouden.
    </div>
  </div>
</div>
