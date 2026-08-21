<template>
  <section class="relative py-32 bg-industrial-dark text-white overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-industrial-blue/10 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
      <div v-motion-slide-visible-left>
        <div class="flex items-center gap-3 mb-6">
          <div class="h-px w-12 bg-industrial-blue"></div>
          <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">
            {{ heroData?.badge || heroData?.subtitle || 'About Us' }}
          </span>
        </div>
        <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8" v-html="formattedTitle">
        </h1>
        <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
          {{ heroData?.description || 'From humble beginnings to becoming Bangladesh\'s premier engineering conglomerate, our journey reflects four decades of excellence, innovation, and unwavering commitment to national development.' }}
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  heroData: {
    type: Object,
    default: () => null
  }
})

const defaultTitle = 'POWERING <span class="text-industrial-blue">PROGRESS</span><br/><span class="text-white/90">SINCE 1980</span>'

const formattedTitle = computed(() => {
  if (!props.heroData?.title) return defaultTitle
  let t = props.heroData.title
  if (t.includes('PROGRESS') && !t.includes('<span')) {
    t = t.replace('PROGRESS', '<span class="text-industrial-blue">PROGRESS</span>')
  }
  return t
})
</script>

<style scoped>
</style>
