<template>
  <!-- Partners/Clients Section -->
  <section class="py-16 md:py-24 bg-industrial-light">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-12" v-motion-slide-visible-bottom>
        <h2 class="text-3xl md:text-4xl font-display font-black uppercase italic mb-6 text-industrial-dark">
          {{ partners.title || 'Trusted by' }} <span class="text-industrial-blue">Industry Leaders</span>
        </h2>
        <p class="text-slate-600 text-base md:text-lg max-w-2xl mx-auto">
          {{ partners.subtitle || 'Proud partner to government agencies, multinational corporations, and leading enterprises' }}
        </p>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 md:gap-8">
        <div
          v-for="(partner, index) in partners.list"
          :key="index"
          class="bg-white p-6 md:p-8 rounded-lg flex flex-col items-center justify-center shadow-lg hover:shadow-xl transition-all group"
          v-motion-slide-visible-bottom
          :delay="index * 100"
        >
          <!-- Display emoji logo if it's an emoji -->
          <div
            v-if="isEmoji(partner.logo)"
            class="text-4xl md:text-5xl mb-3 group-hover:scale-110 transition-transform"
          >
            {{ partner.logo }}
          </div>
          <!-- Display image logo if it's an image URL -->
          <img
            v-else
            :src="getImageUrl(partner.logo)"
            :alt="partner.name"
            class="h-12 md:h-16 w-auto object-contain mb-3 group-hover:scale-110 transition-transform"
            @error="handleImageError($event, partner)"
          />
          <div class="font-black uppercase text-xs md:text-sm tracking-wider text-slate-700 group-hover:text-industrial-blue transition-colors">{{ partner.name }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { API_CONFIG } from '@/config/api'

const props = defineProps({
  partnersData: {
    type: Object,
    default: null
  },
  homepageData: {
    type: Object,
    default: null
  }
})

// Partners computed property
const partners = computed(() => {
  // Use dedicated API data if available
  if (props.partnersData?.list) {
    console.log('Using partners API data:', props.partnersData)
    return {
      title: props.partnersData.title || 'Trusted by Industry Leaders',
      subtitle: props.partnersData.subtitle || 'Proud partner to government agencies, multinational corporations, and leading enterprises',
      list: props.partnersData.list
    }
  }

  // Fallback to homepageData for backwards compatibility
  if (props.homepageData?.partners?.list) {
    console.log('Using homepageData partners as fallback:', props.homepageData.partners)
    const p = props.homepageData.partners
    return {
      title: p.title || 'Trusted by Industry Leaders',
      subtitle: p.subtitle || 'Proud partner to government agencies, multinational corporations, and leading enterprises',
      list: p.list
    }
  }

  // Default values if no data
  console.log('Using default partners values')
  return {
    title: 'Trusted by Industry Leaders',
    subtitle: 'Proud partner to government agencies, multinational corporations, and leading enterprises',
    list: [
      { name: 'BPDB', logo: '🏭' },
      { name: 'ADB', logo: '🏦' },
      { name: 'World Bank', logo: '🌐' },
      { name: 'BERC', logo: '⚡' },
      { name: 'IEC', logo: '🔌' },
      { name: 'IEEE', logo: '📡' }
    ]
  }
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

const handleImageError = (event, partner) => {
  console.warn(`Partner logo failed to load: ${partner.logo}`)
  // Replace broken image with company name as fallback
  const imgElement = event.target
  const container = imgElement.parentElement
  if (container && imgElement) {
    // Create a text fallback
    const textFallback = document.createElement('div')
    textFallback.className = 'text-2xl md:text-3xl mb-3 group-hover:scale-110 transition-transform font-bold text-industrial-blue'
    textFallback.textContent = partner.name.charAt(0) + (partner.name.split(' ').length > 1 ? partner.name.split(' ').pop().charAt(0) : '')
    imgElement.style.display = 'none'
    container.insertBefore(textFallback, imgElement)
  }
}
</script>

<style scoped>
/* Add any specific styles here if needed */
</style>
