<template>
  <!-- Core Values Section -->
  <section class="py-20 md:py-32 bg-industrial-dark text-white">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16" v-motion-slide-visible-bottom>
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-6 text-white" v-html="formatBrandTitle(coreValues.title)">
        </h2>
        <p class="text-slate-400 text-lg max-w-2xl mx-auto">
          {{ coreValues.subtitle }}
        </p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
        <div
          v-for="(value, index) in coreValues.list"
          :key="index"
          class="glass-panel core-value p-6 md:p-8 rounded-lg hover:bg-industrial-blue/10 transition-colors group"
          v-motion-slide-visible-bottom
          :delay="index * 100"
        >
          <!-- Icon - SVG template or component -->
          <div v-if="value.icon?.template" v-html="value.icon.template" class="w-10 h-10 md:w-12 md:h-12 text-industrial-blue mb-4 md:mb-6 group-hover:scale-110 transition-transform glass-panel-icon"></div>
          <component v-else :is="value.icon" class="w-10 h-10 md:w-12 md:h-12 text-industrial-blue mb-4 md:mb-6 group-hover:scale-110 transition-transform" />
          <h3 class="text-lg md:text-xl font-bold mb-3 md:mb-4 text-white">{{ value.title }}</h3>
          <p class="text-slate-400 text-xs md:text-sm leading-relaxed">{{ value.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { ShieldCheck, Award, Users, TrendingUp, Activity, Settings, Building2, Cog, Wrench } from 'lucide-vue-next'

const props = defineProps({
  coreValuesData: {
    type: Object,
    default: null
  },
  homepageData: {
    type: Object,
    default: null
  },
  highlightedWord: {
    type: String,
    default: 'VALUES'
  }
})

// Icon mapping for backwards compatibility
const iconMap = {
  ShieldCheck,
  Award,
  Users,
  TrendingUp,
  Activity,
  Settings,
  Building2,
  Cog,
  Wrench
}

// Core Values computed property
const coreValues = computed(() => {
  // Use dedicated API data if available
  if (props.coreValuesData?.values) {
    console.log('Using core values API data:', props.coreValuesData)
    const cv = props.coreValuesData
    return {
      title: cv.title || 'Core Values',
      subtitle: cv.subtitle || 'The principles that guide everything we do',
      list: cv.values.map(v => ({
        title: v.title || '',
        description: v.description || '',
        // If icon contains SVG, use it as component, otherwise map icon names
        icon: (typeof v.icon === 'string' && v.icon.includes('<svg')) ? {
          template: v.icon
        } : (iconMap[v.icon] || ShieldCheck)
      }))
    }
  }

  // Fallback to homepageData for backwards compatibility
  if (props.homepageData?.core_values) {
    console.log('Using homepageData core values as fallback:', props.homepageData.core_values)
    const cv = props.homepageData.core_values
    return {
      title: cv.title || 'Core Values',
      subtitle: cv.subtitle || 'The principles that guide everything we do',
      list: cv.list.map(v => ({
        title: v.title || '',
        description: v.description || '',
        // If icon contains SVG, use it as component, otherwise map icon names
        icon: (typeof v.icon === 'string' && v.icon.includes('<svg')) ? {
          template: v.icon
        } : (iconMap[v.icon] || ShieldCheck)
      }))
    }
  }

  // Default values if no data
  console.log('Using default core values')
  return {
    title: 'Core Values',
    subtitle: 'The principles that guide everything we do',
    list: [
      { icon: ShieldCheck, title: 'Safety First', description: 'Zero-compromise approach to workplace and operational safety' },
      { icon: Award, title: 'Quality Excellence', description: 'ISO 9001:2015 certified processes and international standards' },
      { icon: Users, title: 'Customer Focus', description: 'Dedicated to delivering beyond client expectations' },
      { icon: TrendingUp, title: 'Innovation Driven', description: 'Continuous investment in R&D and cutting-edge technology' }
    ]
  }
})

// Helper function to format title with highlighted word
const formatBrandTitle = (title) => {
  if (!title) return ''

  // Get the highlighted word from props or use default
  const highlightedWord = props.highlightedWord || 'VALUES'

  // Split the title and wrap the highlighted word with span
  const parts = title.split(highlightedWord)
  return parts.join(`<span class="text-industrial-blue">${highlightedWord}</span>`)
}
</script>

<style scoped>
/* Core values SVG styling */
:deep(.core-value svg) {
    width: 65px !important;
    height: 65px !important;
}

:deep(.glass-panel svg) {
  width: 100%;
  height: 100%;
  display: block;
}

:deep(.glass-panel-icon svg) {
  width: 100%;
  height: 100%;
  display: block;
}
</style>
