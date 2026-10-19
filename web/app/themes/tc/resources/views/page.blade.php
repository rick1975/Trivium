@extends('layouts.app')

{{-- Met een uitgelichte afbeelding: fotoheader met de titel erin (components/page-hero), anders de gewone paginakop.
     Stijl "achter de inhoud": de foto ligt achter de pagina (components/page-backdrop) en de gewone paginakop staat
     in het witte vlak. --}}
@php($backdrop = has_post_thumbnail(get_queried_object_id()) && function_exists('get_field') && get_field('foto_stijl', get_queried_object_id()) === 'achtergrond')

@section('before-main')
  @if($backdrop)
    <x-page-backdrop />
  @elseif(has_post_thumbnail(get_queried_object_id()))
    <x-page-hero />
  @endif
@endsection

{{-- Rubriekpagina zonder eigen uitgewerkte inhoud: kaarten naar de onderliggende pagina's (components/subpages) --}}
@section('after-main')
  <x-subpages />
@endsection

@section('content')
  @while(have_posts()) @php(the_post())
    @if($backdrop || ! has_post_thumbnail())
      @include('partials.page-header')
    @endif
    @includeFirst(['partials.content-page', 'partials.content'])
  @endwhile
@endsection
