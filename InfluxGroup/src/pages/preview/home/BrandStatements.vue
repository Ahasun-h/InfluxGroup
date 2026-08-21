<template>
  <div class="brand-statements-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading brand statements data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load brand data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchBrandData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Brand Statements Content -->
    <BrandStatementSection
      v-else
      :brand-statements="brandData"
      :homepage-data="null"
      :highlighted-word="'AUTHORITY'"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'
import BrandStatementSection from '@/components/sections/BrandStatementSection.vue'

const brandData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchBrandData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.BRAND_STATEMENTS}`)

    if (response.data && response.data.success) {
      brandData.value = response.data.data || response.data
    } else {
      brandData.value = response.data
    }

    console.log('Brand statements data loaded:', brandData.value)
  } catch (err) {
    console.error('Error fetching brand data:', err)
    error.value = err.message || 'Failed to load brand statements data'
    // Use fallback data for preview
    brandData.value = {
      title: 'ESTABLISHED AUTHORITY IN HEAVY ENGINEERING',
      description: 'Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.',
      image_url: '/brand.png',
      stats: brandStats.value
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchBrandData()
})
</script>

<style scoped>
.brand-statements-preview {
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