{{-- ── FOTO ACHTER DE INHOUD — fotoheaderstijl "achter de inhoud" (veld "Fotoheader", data uit Composers\PageHero).
     De uitgelichte afbeelding ligt schermbreed bovenaan achter de pagina en vervaagt naar beneden in het crème; de
     inhoud staat eroverheen in een wit vlak in het midden (zie .has-hero-achtergrond in css/app.css), zodat de foto
     links en rechts zichtbaar blijft. De header ligt er transparant overheen, met wit logo en witte iconen.
     Puur decoratief: de titel staat in het witte vlak. ── --}}
<div class="pointer-events-none absolute inset-x-0 top-0 h-[60svh] overflow-hidden [mask-image:linear-gradient(to_bottom,#000_40%,transparent)] md:h-[min(100svh,1000px)]" aria-hidden="true">
  {!! wp_get_attachment_image($image, 'full', false, [
    'class' => 'size-full max-w-none object-cover motion-safe:animate-[hero-photo_1.2s_ease-out_both]',
    'style' => "object-position: {$position}",
    'sizes' => '100vw',
    'alt' => '',
    'loading' => 'eager',
    'fetchpriority' => 'high',
  ]) !!}
  {{-- Donker verloop bovenaan: het witte logo en de witte iconen van de header blijven leesbaar op een lichte foto --}}
  <div class="absolute inset-x-0 top-0 h-56 bg-gradient-to-b from-black/60 via-black/25 to-transparent"></div>
</div>
