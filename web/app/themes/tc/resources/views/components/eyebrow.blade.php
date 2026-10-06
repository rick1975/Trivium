{{-- Klein kopje boven een titel, met geel streepje ervoor. Gebruik: <x-eyebrow>Actueel</x-eyebrow> --}}
<div {{ $attributes->merge(['class' => "flex items-center gap-2 text-[.68rem] font-bold tracking-[.18em] uppercase text-triv-blue mb-2 before:content-[''] before:w-[18px] before:h-[3px] before:bg-triv-yellow before:rounded-full"]) }}>
  {{ $slot }}
</div>
