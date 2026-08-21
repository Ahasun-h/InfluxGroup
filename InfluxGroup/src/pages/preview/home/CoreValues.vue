<template>
  <div class="core-values-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading core values data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load core values</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchCoreValuesData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Core Values Content -->
    <CoreValuesSection
      v-else
      :core-values-data="coreValuesData"
      :homepage-data="null"
      :highlighted-word="'VALUES'"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'
import CoreValuesSection from '@/components/sections/CoreValuesSection.vue'

const coreValuesData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchCoreValuesData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.CORE_VALUES}`, {
      params: {
        page: 'home_page'
      }
    })

    if (response.data && response.data.success) {
      coreValuesData.value = response.data.data || response.data
    } else {
      coreValuesData.value = response.data
    }

    console.log('Core Values data loaded:', coreValuesData.value)
  } catch (err) {
    console.error('Error fetching core values data:', err)
    error.value = err.message || 'Failed to load core values data'
    // Use fallback data for preview
    coreValuesData.value = {
      title: 'CORE VALUES',
      subtitle: 'The principles that guide everything we do',
      values: [
        {
          title: 'Excellence',
          description: 'We strive for the highest standards in everything we do, from engineering precision to client relationships.',
          icon: '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>'
        },
        {
          title: 'Integrity',
          description: 'We believe in transparency, honesty, and ethical practices in all our business dealings.',
          icon: '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>'
        },
        {
          title: 'Innovation',
          description: 'We constantly seek new technologies and methods to deliver cutting-edge solutions.',
          icon: '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'
        },
        {
          title: 'Sustainability',
          description: 'We are committed to environmentally responsible practices that benefit future generations.',
          icon: '<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        }
      ]
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCoreValuesData()
})
</script>

<style scoped>
.core-values-preview {
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