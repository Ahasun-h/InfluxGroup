<template>
  <div class="mission-vision-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading mission & vision data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchMissionVisionData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Mission & Vision Content -->
    <MissionVisionSection
      v-else
      :mission-vision-data="mvData"
      :homepage-data="null"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'
import MissionVisionSection from '@/components/sections/MissionVisionSection.vue'

const mvData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchMissionVisionData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.MISSION_VISION}`)

    if (response.data && response.data.success) {
      mvData.value = response.data.data || response.data
    } else {
      mvData.value = response.data
    }

    console.log('Mission & Vision data loaded:', mvData.value)
  } catch (err) {
    console.error('Error fetching mission & vision data:', err)
    error.value = err.message || 'Failed to load mission & vision data'
    // Use fallback data for preview
    mvData.value = {
      mission: {
        title: 'OUR MISSION',
        description: 'To deliver excellence in engineering solutions that power progress and transform communities.',
        points: [
          'Deliver world-class engineering solutions',
          'Foster sustainable development practices',
          'Build lasting partnerships with clients',
          'Innovate for future generations'
        ]
      },
      vision: {
        title: 'OUR VISION',
        description: 'To be the leading force in sustainable infrastructure development, setting new standards in engineering excellence across Asia.',
        points: [
          'Expand regional presence across Asia',
          'Lead in renewable energy solutions',
          'Pioneer smart grid technologies',
          'Cultivate engineering excellence'
        ]
      }
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchMissionVisionData()
})
</script>

<style scoped>
.mission-vision-preview {
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