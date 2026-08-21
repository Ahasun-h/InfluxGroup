<template>
  <div class="about-hero-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading about hero section data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load about hero data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchHeroData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- About Hero Content -->
    <AboutHeroSection
      v-else
      :hero-data="heroData"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'
import AboutHeroSection from '@/components/sections/AboutHeroSection.vue'

const heroData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchHeroData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.ABOUT_HERO}`)

    if (response.data && response.data.success) {
      heroData.value = response.data.data || response.data
    } else {
      heroData.value = response.data
    }

    console.log('About hero data loaded:', heroData.value)
  } catch (err) {
    console.error('Error fetching about hero data:', err)
    error.value = err.message || 'Failed to load hero section data'
    heroData.value = {
      badge: 'About Us',
      title: 'POWERING PROGRESS SINCE 1980',
      description: 'From humble beginnings to becoming Bangladesh\'s premier engineering conglomerate, our journey reflects four decades of excellence, innovation, and unwavering commitment to national development.'
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
.about-hero-preview {
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
  background: #0f172a;
  color: white;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid rgba(255, 255, 255, 0.2);
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
  background: #0f172a;
  color: white;
}
</style>