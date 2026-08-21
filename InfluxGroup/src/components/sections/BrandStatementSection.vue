<template>
  <!-- Brand Statement / Trust Section -->
  <section class="py-20 md:py-32 bg-white text-industrial-dark">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center">
        <div v-motion-slide-visible-left>
           <h2 class="text-4xl md:text-5xl font-display font-black uppercase leading-[0.9] mb-8 text-industrial-dark">
             <span v-html="formatBrandTitle(title)"></span>
           </h2>
           <p class="text-slate-600 text-base md:text-lg leading-relaxed mb-8">
             {{ description }}
           </p>
           <div class="grid grid-cols-2 gap-8 md:gap-12">
             <div v-for="stat in stats" :key="stat.label" class="border-l-4 border-industrial-blue pl-4 md:pl-6 py-2">
               <div class="text-3xl md:text-4xl font-display font-black text-industrial-blue">{{ stat.value }}</div>
               <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ stat.label }}</div>
             </div>
           </div>
        </div>
        <div class="relative group overflow-hidden rounded-sm h-[400px] md:h-[500px]" v-motion-slide-visible-right>
          <img :src="getImageUrl(image)" class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110" />
          <div class="absolute inset-0 bg-industrial-blue/10 mix-blend-multiply"></div>
          <div class="absolute bottom-6 md:bottom-10 left-6 md:left-10 p-6 md:p-8 bg-industrial-blue text-white shadow-2xl max-w-[200px] md:max-w-xs transition-all opacity-0 md:opacity-100 group-hover:opacity-100">
             <div class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 opacity-70">{{ overlayTitle }}</div>
             <div class="text-xl md:text-2xl font-display font-bold italic leading-tight">"{{ overlayText }}"</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { API_CONFIG } from '@/config/api'

const props = defineProps({
  brandStatements: {
    type: Object,
    default: null
  },
  homepageData: {
    type: Object,
    default: null
  },
  highlightedWord: {
    type: String,
    default: 'AUTHORITY'
  }
})

// Computed properties for data with fallbacks
const title = computed(() => {
  return props.brandStatements?.title ||
         props.homepageData?.brand_statement?.title ||
         'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING'
})

const description = computed(() => {
  return props.brandStatements?.description ||
         props.homepageData?.brand_statement?.description ||
         'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.'
})

const image = computed(() => {
  return props.brandStatements?.image ||
         props.homepageData?.brand_statement?.image_url ||
         '/brand.png'
})

const overlayTitle = computed(() => {
  return props.brandStatements?.overlay_title ||
         props.homepageData?.brand_statement?.overlay_title ||
         'Core Reliability'
})

const overlayText = computed(() => {
  return props.brandStatements?.overlay_text ||
         props.homepageData?.brand_statement?.overlay_text ||
         'Zero Downtime Operation Protocols'
})

const stats = computed(() => {
  // Use brandStatements stats if available
  if (props.brandStatements?.stats && props.brandStatements.stats.length > 0) {
    return props.brandStatements.stats.map(stat => ({
      value: stat.value || stat.number || '0',
      label: stat.label || stat.title || 'N/A'
    }))
  }

  // Fallback to homepageData stats
  if (props.homepageData?.stats) {
    const s = props.homepageData.stats
    return [
      { value: s.years_experience + '+', label: 'Years Experience' },
      { value: s.projects_completed + '+', label: 'Projects Completed' },
      { value: s.happy_clients + '+', label: 'Happy Clients' },
      { value: s.awards_won + '+', label: 'Awards Won' }
    ]
  }

  // Default fallback
  return [
    { value: '45+', label: 'Years Experience' },
    { value: '15GW', label: 'Power Generated' },
    { value: '250+', label: 'Global Clients' },
    { value: '500+', label: 'Technical Staff' }
  ]
})

const getImageUrl = (path) => {
  if (!path) return 'https://images.unsplash.com/photo-1466611653911-95282fc3656b?auto=format&fit=crop&q=80&w=1200'
  if (path.startsWith('http')) return path
  // Handle emoji/logos that are just text
  if (isEmoji(path)) return path
  // Fix incorrect storage paths by removing /app/public if present and using new storage route
  let cleanPath = path.replace('/storage/app/public/', '/storage-files/')
  cleanPath = cleanPath.replace('/storage/', '/storage-files/')
  return `${API_CONFIG.baseURL.replace('/api', '')}${cleanPath}`
}

const isEmoji = (str) => {
  if (!str) return false
  // Simple emoji detection - check if the string is short and contains emoji-like characters
  const hasEmoji = /[\u2600-\u26FF\u2700-\u27BF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDEFF]/.test(str)
  return str.length <= 10 && hasEmoji
}

// Helper function to format brand title with highlighted word
const formatBrandTitle = (title) => {
  if (!title) return ''

  // Get the highlighted word from props or use default
  const highlightedWord = props.highlightedWord || props.homepageData?.brand_statement?.highlighted_word || 'AUTHORITY'

  // Split the title and wrap the highlighted word with span
  const parts = title.split(highlightedWord)
  return parts.join(`<span class="text-industrial-blue">${highlightedWord}</span>`)
}
</script>

<style scoped>
/* Add any specific styles here if needed */
</style>
