<template>
  <div class="emergency-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading emergency section data...</p>
    </div>

    <!-- Emergency Support Section -->
    <section v-else class="py-32 bg-industrial-dark text-white min-h-screen flex items-center justify-center">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8" v-html="emergencyData?.title || 'Emergency <span class=\'text-industrial-red\'>Support</span>'">
        </h2>
        <p class="text-xl mb-12 text-slate-300">
          {{ emergencyData?.description || '24/7 emergency support available for critical power infrastructure issues' }}
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
          <a :href="emergencyData?.primary_button?.link || 'tel:+88029876543'" class="bg-industrial-red hover:bg-red-700 text-white px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3">
            <Phone class="w-5 h-5" />
            {{ emergencyData?.primary_button?.text || 'Emergency Line' }}
          </a>
          <a :href="emergencyData?.secondary_button?.link || 'mailto:support@influxgroup.com'" class="bg-white text-industrial-dark hover:bg-industrial-light px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3">
            <Mail class="w-5 h-5" />
            {{ emergencyData?.secondary_button?.text || 'Email Support' }}
          </a>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Phone, Mail } from 'lucide-vue-next'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'

const emergencyData = ref(null)
const loading = ref(true)

const fetchData = async () => {
  try {
    loading.value = true
    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.CONTACT_SECTION}`)
    if (response.data && response.data.success && response.data.data?.emergency) {
      emergencyData.value = response.data.data.emergency
    }
  } catch (err) {
    console.error('Error fetching emergency data:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.emergency-preview {
  min-height: 100vh;
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
</style>
