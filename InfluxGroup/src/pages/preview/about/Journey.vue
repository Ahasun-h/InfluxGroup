<template>
  <div class="journey-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading journey timeline data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load journey data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchJourneyData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Journey Section Content -->
    <JourneySection
      v-else
      :journey-data="journeyData"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'
import JourneySection from '@/components/sections/JourneySection.vue'

const journeyData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchJourneyData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.ABOUT_JOURNEY}`)

    if (response.data && response.data.success) {
      journeyData.value = response.data.data || response.data
    } else {
      journeyData.value = response.data
    }

    console.log('About Journey data loaded:', journeyData.value)
  } catch (err) {
    console.error('Error fetching journey data:', err)
    error.value = err.message || 'Failed to load journey timeline data'
    journeyData.value = {
      title: 'Our Journey',
      subtitle: 'Four decades of excellence in powering Bangladesh\'s development',
      milestones: [
        { year: '1980', title: 'Foundation', description: 'Influx Group established as a small electrical contractor in Dhaka' },
        { year: '1995', title: 'Expansion', description: 'Entered power transmission and distribution sector' },
        { year: '2005', title: 'Manufacturing', description: 'Started manufacturing transformers and switchgear' },
        { year: '2015', title: 'Renewables', description: 'Diversified into solar and wind energy solutions' },
        { year: '2020', title: 'EPC Leadership', description: 'Became leading EPC contractor for mega projects' },
        { year: '2026', title: 'Regional Hub', description: 'Expanded operations across South Asia' }
      ]
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchJourneyData()
})
</script>

<style scoped>
.journey-preview {
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
  color: #1e293b;
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
  color: #1e293b;
}
</style>
