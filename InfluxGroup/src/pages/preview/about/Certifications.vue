<template>
  <div class="certifications-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading certifications data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load certifications data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchCertificationsData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Certifications Content -->
    <CertificationsSection
      v-else
      :certifications-data="certificationsData"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'
import CertificationsSection from '@/components/sections/CertificationsSection.vue'

const certificationsData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchCertificationsData = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.ABOUT_CERTIFICATIONS}`)

    if (response.data && response.data.success) {
      certificationsData.value = response.data.data || response.data
    } else {
      certificationsData.value = response.data
    }

    console.log('About Certifications data loaded:', certificationsData.value)
  } catch (err) {
    console.error('Error fetching certifications data:', err)
    error.value = err.message || 'Failed to load certifications data'
    certificationsData.value = {
      title: 'Certifications & Standards',
      subtitle: 'Internationally recognized certifications ensuring quality and safety',
      list: [
        'ISO 9001:2015',
        'ISO 14001:2015',
        'ISO 45001:2018',
        'IEC 60076',
        'IEEE Standards',
        'BPDB Approved'
      ]
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCertificationsData()
})
</script>

<style scoped>
.certifications-preview {
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
