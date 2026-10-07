<footer class="footer">
  {{-- Foto die in het blauw opgaat (zie resources/css/components/footer.css) --}}
  <img src="{{ Vite::asset('resources/images/trivium-gebouw-buiten.avif') }}" alt="" class="footer__photo" loading="lazy" decoding="async">

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
