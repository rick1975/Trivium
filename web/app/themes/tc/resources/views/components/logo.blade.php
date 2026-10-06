{{-- Inline SVG-logo (zodat het met CSS te stylen is). Gebruik: <x-logo class="w-44" /> --}}
<div {{ $attributes->merge(['class' => '[&>svg]:w-full [&>svg]:h-auto']) }}>
  {!! file_get_contents(get_theme_file_path('resources/images/VMBO-Trivium-college.svg')) !!}
</div>
