{{-- Alleen de datum; geen auteur ("Door …"): de auteurspagina's zijn afgeschermd (zie app/filters.php) --}}
<time class="dt-published" datetime="{{ get_post_time('c', true) }}">
  {{ get_the_date() }}
</time>
