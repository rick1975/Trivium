@php(the_content())

@if ($pagination())
  <nav class="page-nav" aria-label="Paginanavigatie">
    {!! $pagination !!}
  </nav>
@endif
