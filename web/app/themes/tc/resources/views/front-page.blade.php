{{-- Voorpagina: hero, Leren met lef, (optionele) pagina-inhoud, nieuws, snelle links en twee fotobanners --}}
@extends('layouts.app')

@section('before-main')
  @include('components.hero')
  {{-- Testversie van Leren met lef via ?lef-test (zie components/leren-met-lef-test) --}}
  @include(request()->has('lef-test') ? 'components.leren-met-lef-test' : 'components.leren-met-lef')
@endsection

@section('content')
  {{-- Alleen bij echte inhoud: op vertaalde pagina's laat TranslatePress anders een lege (witte) .main achter --}}
  @while(have_posts()) @php(the_post())
    @if(trim(get_post_field('post_content')) !== '')
      @include('partials.content-page')
    @endif
  @endwhile
@endsection

@section('after-main')
  @include('components.news')

  <x-quick-links />

  {{-- Fotobanners (bovenste en onderste) uit Trivium Settings > Fotobanner --}}
  @foreach($photoBanners as $photoBanner)
    <x-photo-banner :image="$photoBanner['image']" :title="$photoBanner['title']" :highlight="$photoBanner['highlight']"
      :align="$photoBanner['align']" :accent="$photoBanner['accent']" :animate="$photoBanner['animate']" :mobile-text="$photoBanner['mobileText']" :mobile-focus="$photoBanner['mobileFocus']" :href="$photoBanner['href']" :link-text="$photoBanner['linkText']" :target="$photoBanner['target']">
      {{ $photoBanner['text'] }}
    </x-photo-banner>
  @endforeach
@endsection
