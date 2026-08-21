<template>
  <section class="hero-section relative min-h-screen flex items-center pt-24 md:pt-20 pb-32 md:pb-40 overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
      <img
        :src="heroBgImage"
        class="w-full h-full object-cover scale-105"
        alt="Power Infrastructure"
      />
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark via-industrial-dark/80 to-transparent"></div>
      <div class="absolute inset-0 bg-industrial-dark/40"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
      <div v-motion :initial="{ opacity: 0, x: -50 }" :enter="{ opacity: 1, x: 0 }">
        <div class="flex items-center gap-3 mb-6 md:mb-8">
          <div class="h-px w-8 md:w-12 bg-industrial-blue"></div>
          <span class="text-industrial-blue font-black uppercase tracking-[0.3em] md:tracking-[0.5em] text-[10px] md:text-xs">
            {{ heroData?.badge || homepageData?.hero?.subtitle || 'Leaders in Energy' }}
          </span>
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-[4em] font-display font-black uppercase italic leading-[1.1] mb-8 text-white drop-shadow-[0_5px_15px_rgba(0,0,0,0.5)]">
          {{ heroData?.title || homepageData?.hero?.title || 'POWERING BANGLADESH' }}
        </h1>
        <p class="text-sm md:text-base text-slate-200 max-w-lg mb-8 md:mb-10 leading-relaxed font-medium">
          {{ heroData?.description || homepageData?.hero?.description || 'From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.' }}
        </p>
        <div class="flex flex-wrap gap-4 md:gap-5">
          <a :href="heroData?.primary_cta?.link || heroData?.cta_link || homepageData?.hero?.cta_link || '/projects'" class="bg-industrial-blue text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs flex items-center gap-3 hover:bg-industrial-red transition-all shadow-2xl hover:scale-105 active:scale-95">
            {{ heroData?.primary_cta?.text || heroData?.cta_text || homepageData?.hero?.cta_text || 'EXPLORE CATALOG' }} <ChevronRight class="w-4 h-4" />
          </a>
          <a :href="heroData?.secondary_cta?.link || '/about'" class="bg-white/5 border-2 border-white/20 text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs backdrop-blur-md hover:bg-white/20 transition-all hover:border-white">
            {{ heroData?.secondary_cta?.text || 'CORPORATE PROFILE' }}
          </a>
        </div>
      </div>

      <!-- Floating Cards -->
      <div
        class="hidden lg:grid grid-cols-2 gap-4 relative z-10"
        v-motion
        :initial="{ opacity: 0, scale: 0.8 }"
        :enter="{ opacity: 1, scale: 1 }"
        :delay="400"
      >
        <div class="glass-panel p-6 rounded-xl hover:-translate-y-2 transition-all duration-500 cursor-pointer group flex items-center gap-4">
          <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center">
            <Settings class="w-12 h-12 text-industrial-blue group-hover:rotate-90 transition-transform duration-700" />
          </div>
          <div>
            <h3 class="font-bold mb-1">Turnkey EPC</h3>
            <p class="text-[10px] text-slate-400">End-to-end project management.</p>
          </div>
        </div>
        <div class="glass-panel p-6 rounded-xl hover:-translate-y-2 transition-all duration-500 cursor-pointer group flex items-center gap-4">
          <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center">
            <ShieldCheck class="w-12 h-12 text-industrial-blue group-hover:scale-110 transition-transform" />
          </div>
          <div>
            <h3 class="font-bold mb-1">Smart Grid</h3>
            <p class="text-[10px] text-slate-400">Class 5 risk mitigation integrated.</p>
          </div>
        </div>
        <div class="col-span-2 glass-panel p-6 rounded-xl flex items-center justify-between hover:bg-industrial-blue/10 transition-colors">
          <div class="flex items-center gap-4">
            <div class="w-16 h-16 flex-shrink-0 flex items-center justify-center">
              <Activity class="w-12 h-12 text-industrial-blue animate-pulse" />
            </div>
            <div>
              <h3 class="text-2xl font-display font-black flex items-center gap-2">
                ISO <span class="text-[10px] text-industrial-blue bg-industrial-blue/10 px-2 py-0.5 rounded uppercase">9001:2015</span>
              </h3>
              <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Certified Compliance</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Category Bar -->
    <div class="absolute bottom-0 w-full bg-white/5 backdrop-blur-3xl border-t border-white/10 overflow-x-auto">
      <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 divide-x divide-white/10 min-w-[600px] md:min-w-0">
        <div v-for="cat in productCategories" :key="cat.name || cat.order" class="py-6 md:py-8 px-4 group cursor-pointer hover:bg-white/5 transition-colors">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
              <!-- Render SVG if icon contains HTML, otherwise use component -->
              <div v-if="cat.isSvg || (typeof cat.icon === 'string' && cat.icon.includes('<svg'))" v-html="cat.icon" class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors flex items-center justify-center"></div>
              <component v-else :is="cat.icon" class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" />
            </div>
            <div>
              <div class="text-[8px] md:text-[10px] text-slate-500 font-black uppercase tracking-widest">{{ cat.count }}</div>
              <div class="font-display font-black uppercase text-base md:text-xl group-hover:text-industrial-blue transition-colors leading-tight">{{ cat.name }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Settings, ShieldCheck, Activity, ChevronRight } from 'lucide-vue-next'
import { API_CONFIG } from '@/config/api'

const props = defineProps({
  heroData: {
    type: Object,
    default: () => null
  },
  homepageData: {
    type: Object,
    default: () => null
  },
  productCategories: {
    type: Array,
    default: () => []
  },
  apiConfig: {
    type: Object,
    default: () => ({ baseURL: '' })
  }
})

const getImageUrl = (imagePath) => {
  if (!imagePath) return '/hero.png'
  if (typeof imagePath === 'string' && (imagePath.startsWith('http://') || imagePath.startsWith('https://') || imagePath.startsWith('data:'))) return imagePath

  let cleanPath = String(imagePath)
  cleanPath = cleanPath.replace('/storage/app/public/', '/storage/')
  if (!cleanPath.startsWith('/')) {
    cleanPath = '/' + cleanPath
  }

  const rawBaseURL = props.apiConfig?.baseURL || API_CONFIG.baseURL || ''
  const domain = rawBaseURL.replace(/\/api\/?$/, '')
  return `${domain}${cleanPath}`
}

const heroBgImage = computed(() => {
  let img = props.heroData?.background_image || props.heroData?.media_files || props.heroData?.seo_attributes?.src || props.homepageData?.hero?.background_image
  if (typeof img === 'object' && img !== null) {
    img = img.source_file || img.url || img.path
  }
  if (typeof img === 'string' && (img.startsWith('{') || img.startsWith('['))) {
    try {
      const parsed = JSON.parse(img)
      img = parsed.source_file || parsed.url || parsed.path || img
    } catch (e) {}
  }
  return getImageUrl(img || '/hero.png')
})
</script>

<style scoped>
.glass-panel {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.hero-section {
  position: relative;
}

@media (prefers-color-scheme: dark) {
  .hero-section h1 {
    color: rgb(244, 244, 245);
  }
}
</style>