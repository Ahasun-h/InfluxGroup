<template>
  <!-- Certifications & Standards Section -->
  <section class="py-32 bg-white text-industrial-dark">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16" v-motion-slide-visible-bottom>
        <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6">
          {{ titleFirst }} <span class="text-industrial-blue">{{ titleRest }}</span>
        </h2>
        <p class="text-slate-600 text-lg max-w-2xl mx-auto">
          {{ subtitle }}
        </p>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
        <div
          v-for="(cert, index) in list"
          :key="index"
          class="bg-industrial-light p-6 rounded-lg text-center hover:bg-industrial-blue hover:text-white transition-all group cursor-pointer"
          v-motion-slide-visible-bottom
          :delay="index * 100"
        >
          <div class="font-black uppercase text-xs tracking-wider">{{ typeof cert === 'string' ? cert : (cert.name || cert.title) }}</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  certificationsData: {
    type: Object,
    default: null
  },
  certifications: {
    type: Array,
    default: null
  }
})

const defaultData = {
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

const data = computed(() => {
  if (props.certificationsData) {
    return {
      title: props.certificationsData.title || defaultData.title,
      subtitle: props.certificationsData.subtitle || defaultData.subtitle,
      list: props.certificationsData.list || props.certificationsData.certifications || defaultData.list
    }
  }
  if (props.certifications && Array.isArray(props.certifications)) {
    return {
      title: defaultData.title,
      subtitle: defaultData.subtitle,
      list: props.certifications
    }
  }
  return defaultData
})

const titleFirst = computed(() => {
  const t = data.value.title || defaultData.title
  if (t.includes('&')) {
    return t.split('&')[0] + '&'
  }
  return t.split(' ')[0] || 'Certifications &'
})

const titleRest = computed(() => {
  const t = data.value.title || defaultData.title
  if (t.includes('&')) {
    return t.split('&').slice(1).join('&').trim()
  }
  return t.split(' ').slice(1).join(' ') || 'Standards'
})

const subtitle = computed(() => data.value.subtitle || defaultData.subtitle)
const list = computed(() => data.value.list || defaultData.list)
</script>

<style scoped>
</style>
