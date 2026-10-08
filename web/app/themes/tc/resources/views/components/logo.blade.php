{{-- Inline SVG-logo (zodat het met CSS te stylen is). Gebruik: <x-logo class="w-44" />
     Het logo staat meerdere keren op een pagina (header, zoekpaneel): id's krijgen daarom per keer een uniek achtervoegsel. --}}
@php
  $suffix = '-' . uniqid();
  $svg = file_get_contents(get_theme_file_path('resources/images/VMBO-Trivium-college.svg'));
  $svg = preg_replace('/\bid="([^"]+)"/', 'id="$1' . $suffix . '"', $svg);
  $svg = preg_replace('/(url\(#|href="#)([^)"]+)/', '$1$2' . $suffix, $svg);
@endphp
<div {{ $attributes->merge(['class' => '[&>svg]:w-full [&>svg]:h-auto']) }}>
  {!! $svg !!}
</div>
