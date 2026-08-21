<template>
  <!-- Mission & Vision Section -->
  <section class="py-20 md:py-32 bg-white text-industrial-dark">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-2 gap-16">
        <div v-for="(item, index) in missionVision" :key="index" v-motion-slide-visible :class="index % 2 === 0 ? 'left' : 'right'">
          <div class="flex items-center gap-3 mb-6">
            <component :is="item.icon" class="w-8 h-8 text-industrial-blue" />
            <h2 class="text-3xl md:text-4xl font-display font-black uppercase italic text-industrial-dark">{{ item.title }}</h2>
          </div>
          <p class="text-base md:text-lg text-slate-600 leading-relaxed mb-6">
            {{ item.description }}
          </p>
          <ul class="space-y-4">
            <li v-for="(point, idx) in item.points" :key="idx" class="flex items-start gap-3">
              <CheckCircle class="w-6 h-6 text-industrial-blue flex-shrink-0 mt-1" />
              <span class="text-slate-700">{{ point }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Zap, Target, CheckCircle } from 'lucide-vue-next'

const props = defineProps({
  missionVisionData: {
    type: Object,
    default: null
  },
  homepageData: {
    type: Object,
    default: null
  }
})

// Icon mapping for backwards compatibility
const iconMap = {
  Zap,
  Target
}

// Mission & Vision computed property
const missionVision = computed(() => {
  // Use dedicated API data if available
  if (props.missionVisionData) {
    const mv = props.missionVisionData
    console.log('Using dedicated mission-vision API data:', mv)

    return [
      {
        icon: iconMap[mv.mission?.icon] || Zap,
        title: mv.mission?.title || 'Our Mission',
        description: mv.mission?.description || 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
        points: mv.mission?.points || [
          'Powering Bangladesh\'s development through innovative energy solutions',
          'Ensuring energy security for future generations',
          'Building sustainable infrastructure nationwide'
        ]
      },
      {
        icon: iconMap[mv.vision?.icon] || Target,
        title: mv.vision?.title || 'Our Vision',
        description: mv.vision?.description || 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
        points: mv.vision?.points || [
          'Regional leadership in sustainable infrastructure development',
          'Global recognition for engineering excellence',
          'Pioneering renewable energy adoption'
        ]
      }
    ]
  }

  // Fallback to homepageData for backwards compatibility
  if (props.homepageData?.mission_vision) {
    const mv = props.homepageData.mission_vision
    console.log('Using homepageData mission_vision as fallback:', mv)

    return [
      {
        icon: iconMap[mv.mission?.icon] || Zap,
        title: mv.mission?.title || 'Our Mission',
        description: mv.mission?.description || 'To deliver reliable, efficient, and sustainable power solutions...',
        points: mv.mission?.points || []
      },
      {
        icon: iconMap[mv.vision?.icon] || Target,
        title: mv.vision?.title || 'Our Vision',
        description: mv.vision?.description || 'To be the leading engineering conglomerate...',
        points: mv.vision?.points || []
      }
    ]
  }

  // Default values if no data
  console.log('Using default mission & vision values')
  return [
    {
      icon: Zap,
      title: 'Our Mission',
      description: 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
      points: [
        'Powering Bangladesh\'s development through innovative energy solutions',
        'Ensuring energy security for future generations',
        'Building sustainable infrastructure nationwide'
      ]
    },
    {
      icon: Target,
      title: 'Our Vision',
      description: 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
      points: [
        'Regional leadership in sustainable infrastructure development',
        'Global recognition for engineering excellence',
        'Pioneering renewable energy adoption'
      ]
    }
  ]
})
</script>

<style scoped>
/* Add any specific styles here if needed */
</style>
