{{-- Voorpagina: hero, Leren met lef, (optionele) pagina-inhoud, nieuws, snelle links en twee fotobanners --}}
@extends('layouts.app')

@section('before-main')
  @include('components.hero')
  @include('components.leren-met-lef')
@endsection

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.content-page')
  @endwhile
@endsection

@section('after-main')
  @include('components.news')

  <x-quick-links />

  {{-- Fotobanners (bovenste en onderste) uit Trivium Settings > Fotobanner --}}
  @foreach($photoBanners as $photoBanner)
    <x-photo-banner :image="$photoBanner['image']" :title="$photoBanner['title']" :highlight="$photoBanner['highlight']"
      :align="$photoBanner['align']" :accent="$photoBanner['accent']" :animate="$photoBanner['animate']" :href="$photoBanner['href']" :link-text="$photoBanner['linkText']" :target="$photoBanner['target']">
      {{ $photoBanner['text'] }}
    </x-photo-banner>
  @endforeach
@endsection
