<template>
  <div class="offices-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading office locations data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load offices</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Offices Content -->
    <section v-else class="py-20 bg-white">
      <div class="max-w-4xl mx-auto px-6">
        <h3 class="text-2xl font-bold text-industrial-dark mb-6">Our Offices</h3>
        <div class="space-y-6">
          <div
            v-for="(office, index) in contactData?.offices"
            :key="index"
            class="bg-industrial-light p-6 rounded-lg border border-slate-200"
          >
            <div class="flex items-start gap-4">
              <Building2 class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" />
              <div>
                <h4 class="font-bold text-industrial-dark text-lg mb-1">{{ office.city }}</h4>
                <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">{{ office.type }}</p>
                <p class="text-slate-600 text-sm mb-2">{{ office.address }}</p>
                <p class="text-slate-600 text-sm">{{ office.phone }}</p>
                <p class="text-slate-600 text-sm">{{ office.email }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Building2 } from 'lucide-vue-next'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'

const contactData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchData = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.CONTACT_SECTION}`)
    if (response.data && response.data.success) {
      contactData.value = response.data.data
    } else {
      contactData.value = response.data
    }
  } catch (err) {
    console.error('Error fetching contact section:', err)
    error.value = err.message || 'Failed to load offices'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.offices-preview {
  min-height: 100vh;
  background: white;
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
