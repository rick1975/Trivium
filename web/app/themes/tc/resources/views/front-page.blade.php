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

  <x-parallax-banner :image="Vite::asset('resources/images/Jongen-achter-microfoon.avif')" :href="App\page_url('over-de-school')">
    <x-slot:title>Kleine school <br><span class="text-triv-yellow">grote betrokkenheid</span></x-slot:title>
    Het VMBO Trivium College is een kleine school met ongeveer 300 leerlingen en grote betrokkenheid bij haar leerlingen. De klassen zijn klein, meestal niet groter dan 22 leerlingen.
  </x-parallax-banner>
@endsection
