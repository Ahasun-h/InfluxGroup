<template>
  <div class="map-preview">
    <section class="h-screen bg-slate-200">
      <iframe
        :src="mapUrl"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
      ></iframe>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { API_CONFIG, API_ENDPOINTS } from '@/config/api'

const mapUrl = ref('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.3832277878897!2d90.4125!3d23.8104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzM3LjQiTiA5MMKwMjQnNDUuMCJF!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd')

const fetchData = async () => {
  try {
    const response = await axios.get(`${API_CONFIG.baseURL}${API_ENDPOINTS.CONTACT_SECTION}`)
    if (response.data && response.data.success && response.data.data?.map_embed_url) {
      mapUrl.value = response.data.data.map_embed_url
    }
  } catch (err) {
    console.error('Error fetching map URL:', err)
  }
}

onMounted(() => {
  fetchData()
})
</script>

<style scoped>
.map-preview {
  height: 100vh;
}
</style>
