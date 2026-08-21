<template>
  <div class="contact-hero-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading contact hero section data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load contact hero data</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Hero Content -->
    <section v-else class="relative py-32 bg-industrial-dark text-white overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-blue/10 to-transparent"></div>
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Contact Us</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            GET IN <span class="text-industrial-blue">TOUCH</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            Ready to discuss your next project? Contact our team for expert consultation and solutions.
          </p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
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
    error.value = err.message || 'Failed to load contact hero data'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.contact-hero-preview {
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
