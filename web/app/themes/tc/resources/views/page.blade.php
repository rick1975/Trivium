@extends('layouts.app')

{{-- Met een uitgelichte afbeelding: fotoheader met de titel erin (components/page-hero), anders de gewone paginakop --}}
@section('before-main')
  @if(has_post_thumbnail(get_queried_object_id()))
    <x-page-hero />
  @endif
@endsection

@section('content')
  @while(have_posts()) @php(the_post())
    @unless(has_post_thumbnail())
      @include('partials.page-header')
    @endunless
    @includeFirst(['partials.content-page', 'partials.content'])
  @endwhile
@endsection
