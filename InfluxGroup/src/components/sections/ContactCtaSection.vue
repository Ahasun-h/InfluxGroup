<template>
  <section class="py-20 md:py-32 bg-industrial-blue text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark/20 to-transparent"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
      <div v-motion-slide-visible-bottom>
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8" v-html="ctaData.title">
        </h2>
        <p class="text-lg md:text-xl mb-12 text-industrial-100 max-w-3xl mx-auto">
          {{ ctaData.description }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a :href="ctaData.button_link || '/contact'" class="inline-flex items-center justify-center gap-3 bg-white text-industrial-blue px-8 md:px-12 py-4 md:py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
            {{ ctaData.button_text || 'Get Started' }} <Briefcase class="w-5 h-5" />
          </a>
          <a href="/contact" class="inline-flex items-center justify-center gap-3 bg-transparent border-2 border-white text-white px-8 md:px-12 py-4 md:py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-white hover:text-industrial-blue transition-all">
            Contact Us <Phone class="w-5 h-5" />
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Briefcase, Phone } from 'lucide-vue-next'

const props = defineProps({
  contactCta: {
    type: Object,
    default: null
  },
  contactCtaData: {
    type: Object,
    default: null
  },
  homepageData: {
    type: Object,
    default: null
  }
})

const defaultCta = {
  title: 'Ready to Power Your Success?',
  description: 'Discover how our innovative solutions can transform your business and drive sustainable growth.',
  button_text: 'Get Started',
  button_link: '/contact'
}

const ctaData = computed(() => {
  const data = props.contactCta || props.contactCtaData || props.homepageData?.contact_cta
  if (!data) return defaultCta
  return {
    title: data.title || defaultCta.title,
    description: data.description || defaultCta.description,
    button_text: data.button_text || data.buttonText || defaultCta.button_text,
    button_link: data.button_link || data.buttonLink || defaultCta.button_link
  }
})
</script>

<style scoped>
.bg-industrial-blue {
  background-color: #1e3a8a;
}

.text-industrial-blue {
  color: #1e3a8a;
}

.from-industrial-dark\/20 {
  --tw-gradient-from: rgba(15, 23, 42, 0.2);
}

.bg-industrial-dark {
  background-color: #0f172a;
}

.text-industrial-100 {
  color: rgba(255, 255, 255, 0.9);
}

.rounded-sm {
  border-radius: 0.25rem;
}

.tracking-widest {
  letter-spacing: 0.1em;
}

@media (min-width: 768px) {
  .md\:py-32 {
    padding-top: 8rem;
    padding-bottom: 8rem;
  }

  .md\:text-5xl {
    font-size: 3rem;
    line-height: 1;
  }

  .md\:px-12 {
    padding-left: 3rem;
    padding-right: 3rem;
  }

  .md\:py-5 {
    padding-top: 1.25rem;
    padding-bottom: 1.25rem;
  }
}
</style>
