{{--
  Herbruikbare boog-divider tussen secties.
  Gebruik: @include('components.wave-divider', ['fill' => '#fbfaf4'])
  Optioneel:
    'edge' => 'top' (default) of 'bottom' — bepaalt spiegelrichting en of de boog naar boven of onder overlapt.
    'flip' => true forceert handmatig spiegelen, los van 'edge'.
--}}
@php
  $fill = $fill ?? '#fbfaf4';
  $edge = $edge ?? 'top';
  $isBottom = $edge === 'bottom';
  $flip = $flip ?? $isBottom;
  $margin = $isBottom ? '0 0 -54px' : '-54px 0 0';
@endphp
<div aria-hidden="true" style="margin: {{ $margin }}; position: relative; background: transparent;">
  {{-- display:block: anders laat de inline-svg een kier (ruimte voor onderstokken) waardoor de foto erdoor schijnt;
       −1px aan de aansluitkant dekt het afrondingsnaadje bij het meeschalen --}}
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none" style="display: block; {{ $flip ? 'transform: scaleY(-1); margin-top: -1px;' : 'margin-bottom: -1px;' }}">
    <path d="M0,0 Q720,80 1440,0 L1440,80 L0,80 Z" fill="{{ $fill }}"/>
  </svg>
</div>
