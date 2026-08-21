<template>
  <div class="contact-info-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading contact information data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <svg class="w-16 h-16 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load contact info</h3>
      <p class="text-gray-500">{{ error }}</p>
      <button @click="fetchData" class="mt-4 px-4 py-2 bg-industrial-blue text-white rounded-lg hover:bg-industrial-dark transition-colors">
        Retry
      </button>
    </div>

    <!-- Contact Information Content -->
    <section v-else class="py-20 bg-white">
      <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-display text-industrial-dark uppercase italic mb-8">
          Contact <span class="text-industrial-blue">Information</span>
        </h2>

        <div class="space-y-8 mb-12">
          <!-- Phone -->
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
              <Phone class="w-6 h-6 text-white" />
            </div>
            <div>
              <h3 class="font-bold text-lg text-industrial-dark mb-2">Phone</h3>
              <p v-for="(phone, index) in contactData?.phones" :key="index" class="text-slate-600">
                {{ phone }}
              </p>
            </div>
          </div>

          <!-- Email -->
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
              <Mail class="w-6 h-6 text-white" />
            </div>
            <div>
              <h3 class="font-bold text-industrial-dark text-lg mb-2">Email</h3>
              <p v-for="(email, index) in contactData?.emails" :key="index" class="text-slate-600">
                {{ email }}
              </p>
            </div>
          </div>

          <!-- Office Hours -->
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-industrial-blue rounded-lg flex items-center justify-center flex-shrink-0">
              <Clock class="w-6 h-6 text-white" />
            </div>
            <div>
              <h3 class="font-bold text-industrial-dark text-lg mb-2">Office Hours</h3>
              <p class="text-slate-600">{{ contactData?.office_hours?.weekdays }}</p>
              <p class="text-slate-600">{{ contactData?.office_hours?.friday }}</p>
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
import { Phone, Mail, Clock } from 'lucide-vue-next'
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
    error.value = err.message || 'Failed to load contact information'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.contact-info-preview {
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
