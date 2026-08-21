<template>
  <!-- Timeline / Journey Section -->
  <section class="py-32 bg-industrial-light">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16" v-motion-slide-visible-bottom>
        <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic mb-6">
          {{ firstWord }} <span class="text-industrial-blue">{{ restTitle }}</span>
        </h2>
        <p class="text-slate-600 text-lg max-w-2xl mx-auto">
          {{ subtitle }}
        </p>
      </div>

      <div class="relative">
        <!-- Timeline Line -->
        <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-industrial-blue/20"></div>

        <!-- Timeline Items -->
        <div class="space-y-16">
          <div
            v-for="(item, index) in milestones"
            :key="index"
            class="relative flex items-center"
            :class="index % 2 === 0 ? 'flex-row' : 'flex-row-reverse'"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <!-- Content -->
            <div class="w-5/12" :class="index % 2 === 0 ? 'text-right pr-12' : 'text-left pl-12'">
              <div class="bg-white p-8 rounded-lg shadow-xl hover:shadow-2xl transition-shadow">
                <div class="text-industrial-blue font-black text-2xl mb-2">{{ item.year }}</div>
                <h3 class="text-lg md:text-xl font-bold mb-3 text-industrial-dark">{{ item.title }}</h3>
                <p class="text-slate-600">{{ item.description }}</p>
              </div>
            </div>

            <!-- Center Dot -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-6 h-6 bg-industrial-blue rounded-full border-4 border-white shadow-lg"></div>

            <!-- Empty Space -->
            <div class="w-5/12"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  journeyData: {
    type: Object,
    default: null
  },
  homepageData: {
    type: Object,
    default: null
  }
})

const defaultJourney = {
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

const journey = computed(() => {
  const data = props.journeyData || props.homepageData?.journey
  if (data && data.milestones && Array.isArray(data.milestones) && data.milestones.length > 0) {
    return data
  }
  return defaultJourney
})

const title = computed(() => journey.value?.title || defaultJourney.title)
const subtitle = computed(() => journey.value?.subtitle || defaultJourney.subtitle)
const milestones = computed(() => journey.value?.milestones || defaultJourney.milestones)

const firstWord = computed(() => {
  const parts = title.value.trim().split(' ')
  return parts[0] || 'Our'
})

const restTitle = computed(() => {
  const parts = title.value.trim().split(' ')
  return parts.slice(1).join(' ') || 'Journey'
})
</script>

<style scoped>
</style>
