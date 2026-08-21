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
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load core values data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchCoreValuesData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Core Values Content -->
    <CoreValuesSection
      v-else
      :core-values-data="coreValuesData"
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

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.ABOUT_CORE_VALUES}`)

    if (response.data && response.data.success) {
      coreValuesData.value = response.data.data || response.data
    } else {
      coreValuesData.value = response.data
    }

    console.log('About Core Values data loaded:', coreValuesData.value)
  } catch (err) {
    console.error('Error fetching core values data:', err)
    error.value = err.message || 'Failed to load core values data'
    coreValuesData.value = {
      title: 'Our Core Values',
      subtitle: 'The principles that guide everything we do',
      values: [
        { title: 'Quality Excellence', description: 'Uncompromising commitment to quality across all engineering solutions.', icon: 'ShieldCheck' },
        { title: 'Innovation', description: 'Pioneering modern technology to deliver efficient power infrastructure.', icon: 'Award' },
        { title: 'Integrity', description: 'Building trust through honest relationships and ethical business practices.', icon: 'Users' },
        { title: 'Sustainability', description: 'Driving green energy adoption for a cleaner environment.', icon: 'TrendingUp' }
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
