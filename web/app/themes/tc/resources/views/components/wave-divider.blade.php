{{--
  Herbruikbare boog-divider tussen secties.
  Gebruik: @include('components.wave-divider', ['fill' => '#fbfaf4'])
  Optioneel: 'flip' => true om de boog verticaal te spiegelen.
--}}
@php
  $fill = $fill ?? '#fbfaf4';
  $flip = $flip ?? false;
@endphp
<div style="margin: -54px 0 0; position: relative; background: transparent;">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" preserveAspectRatio="none" style="{{ $flip ? 'transform: scaleY(-1);' : '' }}">
    <path d="M0,0 Q720,80 1440,0 L1440,80 L0,80 Z" fill="{{ $fill }}"/>
  </svg>
</div>
