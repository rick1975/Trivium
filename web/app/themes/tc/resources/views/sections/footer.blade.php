<footer class="footer">
  <div class="container">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      {{-- Footer Column 1 --}}
      <div>
        <h3 class="text-lg font-semibold mb-4 text-white">{{ get_bloginfo('name') }}</h3>
        <p class="text-sm text-white">
          {{ get_bloginfo('description') }}
        </p>
      </div>

      {{-- Footer Column 2 - Primary Menu --}}
      <div>
        <h3 class="text-lg font-semibold mb-4 text-white">Menu</h3>
        @if($navigation)
          <ul class="space-y-2 text-sm mb-0">
            @foreach($navigation as $item)
              <li>
                <a href="{{ $item->url }}" 
                   class="text-white hover:text-gray-100"
                   @if($item->target) target="{{ $item->target }}" @endif>
                  {{ $item->label }}
                </a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>

      {{-- Footer Column 3 --}}
      <div>
        <h3 class="text-lg font-semibold mb-4 text-white">Contact</h3>
        <p class="text-sm text-white">
          Email: info@example.com<br>
          Tel: 012-3456789
        </p>
      </div>
    </div>
  </div>
</footer>

{{-- Copyright Section (Outside primary color background) --}}
<div class="bg-white py-6">
  <div class="container">
    <div class="text-center text-xs md:text-sm text-gray-600">
      &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. Alle rechten voorbehouden.
    </div>
  </div>
</div>
