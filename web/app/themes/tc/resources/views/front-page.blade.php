{{-- Voorpagina: hero, Leren met lef, (optionele) pagina-inhoud, nieuws en quick-links --}}
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

  <x-parallax-banner :image="Vite::asset('resources/images/Jongen-achter-microfoon.avif')" title="Bij ons word je" highlight="gehoord" :href="App\page_url('over-de-school')">
    Het VMBO Trivium College is een kleine school met ongeveer 300 leerlingen. In klassen van meestal niet meer dan 22 leerlingen kennen we elkaar en krijg je de ruimte om te laten horen wie je bent.
  </x-parallax-banner>
@endsection
