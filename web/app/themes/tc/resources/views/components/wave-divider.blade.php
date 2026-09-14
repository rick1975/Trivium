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
<div style="margin: {{ $margin }}; position: relative; background: transparent;">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none" style="{{ $flip ? 'transform: scaleY(-1);' : '' }}">
    <path d="M0,0 Q720,80 1440,0 L1440,80 L0,80 Z" fill="{{ $fill }}"/>
  </svg>
</div>
