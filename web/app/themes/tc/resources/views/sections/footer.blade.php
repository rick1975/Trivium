<footer class="footer">
  {{-- Foto die in het blauw opgaat: grijs gemaakt en met multiply door het footer-blauw gemengd;
       loopt via maskers onderaan (en vanaf tablet naar links) zacht weg in het effen blauw --}}
  <img src="{{ Vite::asset('resources/images/trivium-gebouw-buiten.avif') }}" alt="" loading="lazy" decoding="async"
    class="pointer-events-none absolute inset-0 size-full object-cover object-[center_40%] grayscale contrast-110 brightness-110 mix-blend-multiply opacity-60 mask-b-from-45% md:left-auto md:w-[65%] md:opacity-85 md:mask-b-from-40% md:mask-l-from-55%">

  <div class="container relative">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      {{-- Footer Column 1 --}}
      <div>
        <h3 class="text-lg font-semibold mb-4 text-white">{{ $siteName }}</h3>
        <p class="text-sm text-white">
          Maak jouw toekomst bij Trivium College in Gorinchem. Praktijkgericht onderwijs dat écht bij jou past.</p>
        @if($contact->adres)
          <p class="text-sm">{!! nl2br(e($contact->adres)) !!}</p>
        @endif
        @if($contact->telefoon || $contact->email)
          <p class="text-sm">
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
