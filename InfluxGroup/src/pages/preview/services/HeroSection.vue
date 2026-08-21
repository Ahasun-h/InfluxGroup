<template>
  <div class="preview-root">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading services &amp; solutions hero section...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="err-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3>Failed to load services hero data</h3>
      <p>{{ error }}</p>
      <button @click="fetchData">Retry</button>
    </div>

    <!-- Hero Content -->
    <section v-else class="relative py-32 bg-industrial-dark text-white overflow-hidden">
      <div class="absolute inset-0 gradient-overlay"></div>
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">
              {{ heroData.badge }}
            </span>
          </div>
          <h1
            class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8"
            v-html="heroData.title"
          ></h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            {{ heroData.description }}
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

const heroData = ref({
  badge: 'What We Offer',
  title: 'SERVICES &amp; <span class="text-industrial-blue">SOLUTIONS</span>',
  description: 'Comprehensive engineering services and tailored solutions from concept to commissioning, ensuring your power infrastructure operates at peak performance.'
})
const loading = ref(true)
const error = ref(null)

const fetchData = async () => {
  try {
    loading.value = true
    error.value = null
    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.SERVICES_HERO}`)
    if (response.data && response.data.success && response.data.data) {
      heroData.value = response.data.data
    }
  } catch (err) {
    console.warn('Services hero API error, using defaults:', err.message)
    // Keep default values silently
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.preview-root {
  min-height: 100vh;
  background: #0f172a;
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
  gap: 1rem;
}

.err-icon {
  width: 4rem;
  height: 4rem;
  color: #ef4444;
}

.error-container button {
  margin-top: 1rem;
  padding: 0.5rem 1.25rem;
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 0.5rem;
  cursor: pointer;
  font-weight: 600;
}

.bg-industrial-dark { background-color: #0f172a; }
.bg-industrial-blue { background-color: #3b82f6; }
.text-industrial-blue { color: #3b82f6; }

.gradient-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, rgba(59, 130, 246, 0.1), transparent);
}

:deep(.text-industrial-blue) {
  color: #3b82f6;
}
</style>
