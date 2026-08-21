<template>
  <div class="hero-section-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading hero section data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load hero data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchHeroData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Hero Section Content -->
    <HeroSectionComponent
      v-else
      :hero-data="heroData"
      :product-categories="productCategories"
      :api-config="API_CONFIG"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'
import HeroSectionComponent from '@/components/sections/HeroSection.vue'

const heroData = ref(null)
const loading = ref(true)
const error = ref(null)
const productCategories = ref([])

const fetchHeroData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.HERO}`)

    if (response.data && response.data.success) {
      heroData.value = response.data.data || response.data
    } else {
      heroData.value = response.data
    }

    if (heroData.value && heroData.value.categories && heroData.value.categories.length) {
      productCategories.value = heroData.value.categories.map(cat => ({
        ...cat,
        isSvg: true
      }))
    } else {
      productCategories.value = [
        { name: 'Transformers', count: '45+', icon: '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>', isSvg: true },
        { name: 'Switchgear', count: '120+', icon: '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"></path><circle cx="12" cy="12" r="3"></circle></svg>', isSvg: true },
        { name: 'Renewables', count: '12GW', icon: '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.8 19.6A2 2 0 1 0 14 16H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 8a2.5 2.5 0 1 1 2 4H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.8 4.4A2 2 0 1 1 11 8H2"></path></svg>', isSvg: true },
        { name: 'Automation', count: '80+', icon: '<svg class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 2v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 17h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>', isSvg: true }
      ]
    }

    console.log('Hero data loaded:', heroData.value)
  } catch (err) {
    console.error('Error fetching hero data:', err)
    error.value = err.message || 'Failed to load hero section data'
    // Use fallback data for preview
    heroData.value = {
      badge: 'Leaders in Energy',
      title: 'POWERING BANGLADESH',
      description: 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.',
      cta_text: 'EXPLORE CATALOG',
      cta_link: '/projects',
      secondary_cta_text: 'CORPORATE PROFILE',
      secondary_cta_link: '/about',
      background_image: '/hero.png'
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchHeroData()
})
</script>

<style scoped>
.hero-section-preview {
  min-height: 100vh;
  background: transparent;
}

.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  gap: 1rem;
  background: #f8fafc;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #e2e8f0;
  border-top: 3px solid #3b82f6;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.error-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 2rem;
  text-align: center;
  background: #f8fafc;
}
</style>