// Live zoeken in het zoekpaneel (components/search-panel.blade.php). Staat in JS en niet inline in x-data omdat
// TranslatePress op vertaalde pagina's de regeleinden in attributen platslaat, waardoor inline code breekt.
export function registerSearchPanel(Alpine) {
  Alpine.data('searchPanel', () => ({
    query: '',
    results: [],
    loading: false,
    searchTimer: null,
    abortController: null,

    onInput() {
      clearTimeout(this.searchTimer)
      if (this.abortController) this.abortController.abort()
      if (this.query.trim().length < 2) {
        this.results = []
        this.loading = false
        return
      }
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

    // De REST-titel bevat entiteiten (&#038;): eerst naar platte tekst, dan zelf veilig escapen
    highlight(text) {
      const plainText = new DOMParser().parseFromString(text, 'text/html').body.textContent
      const safeText = this.escapeHtml(plainText)
      const term = this.escapeHtml(this.query.trim()).replace(/[.*+?^${}()|[\]\\]/g, '\\$&')
      if (!term) return safeText
      return safeText.replace(new RegExp('(' + term + ')', 'ig'), "<mark class='bg-triv-yellow/60 rounded-sm'>$1</mark>")
    },
  }))
}
