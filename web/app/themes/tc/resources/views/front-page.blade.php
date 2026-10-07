{{-- Voorpagina: hero, Leren met lef, (optionele) pagina-inhoud, nieuws, snelle links en fotobanner --}}
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

  @if($photoBanner)
    <x-photo-banner :image="$photoBanner['image']" :title="$photoBanner['title']" :highlight="$photoBanner['highlight']"
      :href="$photoBanner['href']" :link-text="$photoBanner['linkText']" :target="$photoBanner['target']">
      {{ $photoBanner['text'] }}
    </x-photo-banner>
  @endif
@endsection
