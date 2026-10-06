<footer class="footer">
  <div class="container">
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

      {{-- Footer Column 2 --}}
      <div>
        <h3 class="text-lg font-semibold mb-4 text-white">Contact</h3>
        <p class="text-sm text-white">
          @if($contact->email)
            Email: {{ $contact->email }}<br>
          @endif
          @if($contact->telefoon)
            Tel: {{ $contact->telefoon }}
          @endif
        </p>
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
