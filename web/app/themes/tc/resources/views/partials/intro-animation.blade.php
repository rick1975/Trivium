{{-- resources/views/partials/intro-animation.blade.php --}}
{{-- Gebruik: @include('partials.intro-animation') --}}

<div class="tc-intro">
  <style>
    .tc-intro { width: min(92%, 760px); margin-inline: auto; }
    .tc-intro svg { width: 100%; height: auto; display: block; }

    .tc-intro__stroke {
      stroke-dasharray: 100;
      stroke-dashoffset: 100;
      animation: tcIntroDraw 6s ease-in-out infinite;
    }
    .tc-intro__stroke.s1 { stroke: #5597ce; --d: 0s;   }
    .tc-intro__stroke.s2 { stroke: #4dadaa; --d: 0.5s; }
    .tc-intro__stroke.s3 { stroke: #f3dc4a; --d: 1.0s; }
    .tc-intro__stroke.s4 { stroke: #e69c3f; --d: 1.5s; }
    .tc-intro__stroke.s5 { stroke: #d93386; --d: 2.0s; }
    .tc-intro__stroke.s6 { stroke: #ffffff; --d: 2.5s; }

    .tc-intro__row--1 .tc-intro__stroke { animation-delay: var(--d); }
    .tc-intro__row--2 .tc-intro__stroke { animation-delay: calc(var(--d) + 0.35s); }
    .tc-intro__row--3 .tc-intro__stroke { animation-delay: calc(var(--d) + 0.70s); }

    @keyframes tcIntroDraw {
      0%   { stroke-dashoffset: 100; }
      18%  { stroke-dashoffset: 0;   }
      72%  { stroke-dashoffset: 0;   }
      82%  { stroke-dashoffset: -100;}
      100% { stroke-dashoffset: -100;}
    }

    @media (prefers-reduced-motion: reduce) {
      .tc-intro__stroke { animation: none; stroke-dashoffset: 0; }
      .tc-intro__stroke.s1,
      .tc-intro__stroke.s2,
      .tc-intro__stroke.s3,
      .tc-intro__stroke.s4,
      .tc-intro__stroke.s5 { display: none; }
    }
  </style>

  <svg viewBox="0 0 760 420" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Maak jouw toekomst">
    <defs>
      <clipPath id="tcIntroR1"><text x="380" y="130" text-anchor="middle" font-weight="800" font-size="120">Maak</text></clipPath>
      <clipPath id="tcIntroR2"><text x="380" y="255" text-anchor="middle" font-weight="800" font-size="120">jouw</text></clipPath>
      <clipPath id="tcIntroR3"><text x="380" y="385" text-anchor="middle" font-weight="800" font-size="120">toekomst!</text></clipPath>
    </defs>

    <g class="tc-intro__row tc-intro__row--1" clip-path="url(#tcIntroR1)" fill="none" stroke-width="150" stroke-linecap="round">
      <path class="tc-intro__stroke s1" pathLength="100" d="M -60 60 C 180 -40 320 200 500 70 S 780 200 900 60"/>
      <path class="tc-intro__stroke s2" pathLength="100" d="M -60 90 C 200 220 320 -30 520 90 S 760 -20 900 90"/>
      <path class="tc-intro__stroke s3" pathLength="100" d="M -60 60 C 180 -40 320 200 500 70 S 780 200 900 60"/>
      <path class="tc-intro__stroke s4" pathLength="100" d="M -60 90 C 200 220 320 -30 520 90 S 760 -20 900 90"/>
      <path class="tc-intro__stroke s5" pathLength="100" d="M -60 60 C 180 -40 320 200 500 70 S 780 200 900 60"/>
      <path class="tc-intro__stroke s6" pathLength="100" d="M -60 80 C 200 220 320 -30 520 90 S 760 -20 900 80"/>
    </g>

    <g class="tc-intro__row tc-intro__row--2" clip-path="url(#tcIntroR2)" fill="none" stroke-width="150" stroke-linecap="round">
      <path class="tc-intro__stroke s1" pathLength="100" d="M -60 185 C 180 85 320 325 500 195 S 780 325 900 185"/>
      <path class="tc-intro__stroke s2" pathLength="100" d="M -60 215 C 200 345 320 95 520 215 S 760 105 900 215"/>
      <path class="tc-intro__stroke s3" pathLength="100" d="M -60 185 C 180 85 320 325 500 195 S 780 325 900 185"/>
      <path class="tc-intro__stroke s4" pathLength="100" d="M -60 215 C 200 345 320 95 520 215 S 760 105 900 215"/>
      <path class="tc-intro__stroke s5" pathLength="100" d="M -60 185 C 180 85 320 325 500 195 S 780 325 900 185"/>
      <path class="tc-intro__stroke s6" pathLength="100" d="M -60 205 C 200 345 320 95 520 215 S 760 105 900 205"/>
    </g>

    <g class="tc-intro__row tc-intro__row--3" clip-path="url(#tcIntroR3)" fill="none" stroke-width="150" stroke-linecap="round">
      <path class="tc-intro__stroke s1" pathLength="100" d="M -60 315 C 180 215 320 455 500 325 S 780 455 900 315"/>
      <path class="tc-intro__stroke s2" pathLength="100" d="M -60 345 C 200 475 320 225 520 345 S 760 235 900 345"/>
      <path class="tc-intro__stroke s3" pathLength="100" d="M -60 315 C 180 215 320 455 500 325 S 780 455 900 315"/>
      <path class="tc-intro__stroke s4" pathLength="100" d="M -60 345 C 200 475 320 225 520 345 S 760 235 900 345"/>
      <path class="tc-intro__stroke s5" pathLength="100" d="M -60 315 C 180 215 320 455 500 325 S 780 455 900 315"/>
      <path class="tc-intro__stroke s6" pathLength="100" d="M -60 335 C 200 475 320 225 520 345 S 760 235 900 335"/>
    </g>
  </svg>
</div>