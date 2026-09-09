{{-- Zoekpaneel: volledig-scherm overlay met live zoekresultaten --}}
<div x-show="searchOpen"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 -translate-y-full"
  x-transition:enter-end="opacity-100 translate-y-0"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100 translate-y-0"
  x-transition:leave-end="opacity-0 -translate-y-full"
  x-init="$watch('searchOpen', open => { if (open) $nextTick(() => $refs.searchInput.focus()) })"
  class="search-overlay fixed inset-0 z-50 bg-[rgb(242_242_238/0.9)] backdrop-blur-xl flex flex-col"
  style="display: none;">

  {{-- Balk met logo en sluitknop --}}
  <div class="flex items-center justify-between px-6 xl:px-20 min-h-[80px] shrink-0">
    <div class="w-44 [&>svg]:w-full [&>svg]:h-auto">
      {!! file_get_contents(get_template_directory() . '/resources/images/VMBO-Trivium-college.svg') !!}
    </div>
    <button type="button" @click="searchOpen = false"
      class="mr-8 w-9 h-9 rounded-full flex items-center justify-center border border-[#ddd8cc] bg-white text-[#1a1612] hover:bg-[#e56b6f] hover:border-[#e56b6f] hover:text-white transition-all duration-300" aria-label="Zoeken sluiten">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <line x1="4" y1="4" x2="20" y2="20"/>
        <line x1="20" y1="4" x2="4" y2="20"/>
      </svg>
    </button>
  </div>

  {{-- Zoekveld en resultaten --}}
  <div class="flex-1 overflow-y-auto px-6 xl:px-20 py-6"
    x-data="{
      query: '',
      results: [],
      loading: false,
      searchTimer: null,
      abortController: null,
      onInput() {
        clearTimeout(this.searchTimer)
        if (this.abortController) this.abortController.abort()
        if (this.query.trim().length < 2) { this.results = []; this.loading = false; return }
        this.searchTimer = setTimeout(() => this.fetchResults(), 200)
      },
      async fetchResults() {
        const term = this.query.trim()
        this.abortController = new AbortController()
        this.loading = true
        try {
          const response = await fetch('/wp-json/wp/v2/search?search=' + encodeURIComponent(term) + '&per_page=5', { signal: this.abortController.signal })
          this.results = response.ok ? await response.json() : []
        } catch (e) {
          if (e.name !== 'AbortError') this.results = []
        }
        this.loading = false
      },
      escapeHtml(text) {
        return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
      },
      highlight(text) {
        const safeText = this.escapeHtml(text)
        const term = this.query.trim().replace(/[.*+?^${}()|[\]\\]/g, '\\$&')
        if (!term) return safeText
        return safeText.replace(new RegExp('(' + term + ')', 'ig'), `<mark class='bg-triv-yellow/60 rounded-sm'>$1</mark>`)
      }
    }"
    x-effect="if (!searchOpen) { query = ''; results = [] }">
    <div class="max-w-lg mx-auto w-full">
      <form method="GET" action="{{ home_url('/') }}" x-ref="searchForm" class="flex items-center gap-3 bg-white border border-[#ddd8cc] rounded-full px-5 py-3 focus-within:border-[#004289] focus-within:shadow-[0_6px_28px_rgba(0,66,137,.12)] transition-all duration-200">
        <button type="submit" class="text-[#7a7060] hover:text-triv-blue transition-colors shrink-0" aria-label="Zoeken uitvoeren">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
            <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.4"/>
            <path d="M11 11l2.5 2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
          </svg>
        </button>
        <input x-ref="searchInput" type="search" name="s" placeholder="Waar ben je naar op zoek?" aria-label="Zoeken" required
          x-model="query" @input="onInput()" autocomplete="off"
          class="border-none outline-none bg-transparent text-sm text-[#1a1612] placeholder:text-[#7a7060] w-full font-['DM_Sans']" />
        <button type="button" x-show="query.length > 0" style="display: none;"
          @click="query = ''; results = []; $refs.searchInput.focus()"
          class="text-[#8b9098] hover:text-[#d14d51] transition-colors shrink-0" aria-label="Zoekopdracht wissen">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="4" y1="4" x2="20" y2="20"/>
            <line x1="20" y1="4" x2="4" y2="20"/>
          </svg>
        </button>
      </form>

      {{-- Live zoekresultaten tijdens het typen --}}
      <div x-show="query.trim().length >= 2" class="mt-4" style="display: none;">
        <p x-show="loading" class="text-white/70 text-xs px-1">Zoeken...</p>
        <p x-show="!loading && results.length === 0" class="text-white/70 text-xs px-1">Geen resultaten gevonden.</p>
        <ul x-show="!loading && results.length > 0" class="flex flex-col gap-1">
          <template x-for="result in results" :key="result.id">
            <li>
              <a :href="result.url"
                class="flex items-center justify-between gap-2 px-4 py-2 bg-white border border-[#ddd8cc] rounded-xl text-sm text-[#1a1612] hover:border-[#e56b6f] hover:text-[#d14d51] transition-colors">
                <span x-html="highlight(result.title)"></span>
                <span class="shrink-0 text-[#8b9098]">&rarr;</span>
              </a>
            </li>
          </template>
        </ul>
      </div>

      {{-- Populaire pagina's: eenvoudige tekstlinks, geen buttons --}}
      <div x-show="query.trim().length < 2" class="mt-12" style="display: none;">
        <p class="text-neutral-800 text-xs font-semibold uppercase tracking-widest px-1 mb-2">Populaire pagina's</p>
        <ul class="flex flex-col">
          @foreach(['Aanmelden', 'Open dag', 'Rooster', 'Contact', 'Vakanties'] as $suggestion)
            <li class="border-b border-stone-300 last:border-b-0">
              <button type="button"
                @click="$refs.searchInput.value = '{{ $suggestion }}'; $refs.searchForm.requestSubmit()"
                class="w-full flex items-center justify-between gap-2 px-1 py-2.5 text-sm text-stone-500 hover:text-triv-pink transition-colors text-left">
                {{ $suggestion }}
                <span class="shrink-0">&rarr;</span>
              </button>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
