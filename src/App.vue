<script setup>
import { ref, onMounted } from 'vue'
import { 
  Zap, 
  Settings, 
  ShieldCheck, 
  Activity, 
  ChevronRight, 
  Menu, 
  X,
  Phone,
  Mail,
  MapPin,
  ArrowUpRight,
  Plus,
  ArrowRight,
  Monitor,
  Cpu,
  Wind
} from 'lucide-vue-next'

const isMenuOpen = ref(false)
const scrolled = ref(false)

const productCategories = [
  { name: 'Transformers', icon: Zap, count: '45+' },
  { name: 'Switchgear', icon: Settings, count: '120+' },
  { name: 'Renewables', icon: Wind, count: '12GW' },
  { name: 'Automation', icon: Cpu, count: '80+' }
]

const products = [
  {
    title: 'High-Voltage Transformer',
    model: 'EP-450 Series',
    desc: 'Core power distribution technology for industrial grids.',
    image: 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-blue'
  },
  {
    title: 'Intelligent Switchgear',
    model: 'JRC-G3 Switch',
    desc: 'Automated circuit protection and load management.',
    image: 'https://images.unsplash.com/photo-1544724569-5f546fa6629c?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-red'
  },
  {
    title: 'Solar Inverters',
    model: 'REX-Solar V2',
    desc: 'High-conversion efficiency for utility-scale solar farms.',
    image: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-blue'
  },
  {
    title: 'Grid Control Unit',
    model: 'TRX-Monitor',
    desc: 'Real-time grid synchronization and performance tracking.',
    image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800',
    color: 'industrial-red'
  }
]

const stats = [
  { value: '45+', label: 'Years Experience' },
  { value: '15GW', label: 'Power Generated' },
  { value: '250+', label: 'Global Clients' },
  { value: '500+', label: 'Technical Staff' }
]

const team = [
  { name: 'Engr. Mahbub Alam', role: 'Chief Technical Officer', expertise: 'Power System Stability', image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400' },
  { name: 'Syeda Mehnaz', role: 'Director - EPC', expertise: 'Renewable Infrastructure', image: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=400' },
  { name: 'Dr. Kabir Hasan', role: 'Head of R&D', expertise: 'Smart Grid Automation', image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=400' }
]

const featuredProjects = [
  { title: 'Matarbari Power Hub', capacity: '1200MW', type: 'Grid Infrastructure', image: 'https://images.unsplash.com/photo-1466611653911-95282fc3656b?auto=format&fit=crop&q=80&w=1200' },
  { title: 'Northern Solar Farm', capacity: '50MW', type: 'Renewable Energy', image: 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?auto=format&fit=crop&q=80&w=1200' }
]

onMounted(() => {
  window.addEventListener('scroll', () => {
    scrolled.value = window.scrollY > 50
  })
})
</script>

<template>
  <div class="min-h-screen bg-industrial-dark text-slate-100 selection:bg-industrial-blue selection:text-white">
    
    <!-- Navbar -->
    <nav 
      class="fixed w-full z-50 transition-all duration-300 py-4"
      :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-xl py-3 border-b-4 border-industrial-blue' : 'bg-transparent'"
    >
      <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
        <div class="flex items-center gap-2 group cursor-pointer">
          <div class="w-12 h-12 bg-industrial-blue flex items-center justify-center rounded-sm transform group-hover:bg-industrial-red transition-all duration-500 shadow-lg">
            <Zap class="text-white w-7 h-7" />
          </div>
          <div class="flex flex-col leading-none">
            <span class="text-2xl font-display font-black tracking-tighter uppercase italic" :class="scrolled ? 'text-industrial-dark' : 'text-white'">
              INFLUX<span class="text-industrial-blue">GROUP</span>
            </span>
            <span class="text-[8px] font-bold uppercase tracking-[0.4em]" :class="scrolled ? 'text-slate-500' : 'text-slate-400'">Engineering the future</span>
          </div>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center gap-12 font-bold uppercase tracking-widest text-[11px]" :class="scrolled ? 'text-industrial-dark' : 'text-white'">
          <a href="#" class="hover:text-industrial-blue transition-colors flex items-center gap-1 group">
            Products <Plus class="w-3 h-3 text-industrial-blue group-hover:rotate-90 transition-transform" />
          </a>
          <a href="#" class="hover:text-industrial-blue transition-colors">EPC Solutions</a>
          <a href="#" class="hover:text-industrial-blue transition-colors">Research</a>
          <a href="#" class="hover:text-industrial-blue transition-colors">Sustainability</a>
          <button class="ml-4 px-6 py-2 rounded-sm transition-all font-black uppercase border-2 flex items-center gap-2 group/btn"
            :class="scrolled ? 'bg-industrial-blue text-white border-industrial-blue hover:bg-industrial-red hover:border-industrial-red' : 'bg-white/10 text-white border-white/30 hover:bg-white hover:text-industrial-dark hover:border-white'"
          >
            Engage <ArrowRight class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" />
          </button>
        </div>

        <!-- Mobile Toggle -->
        <button class="md:hidden" :class="scrolled ? 'text-industrial-dark' : 'text-white'" @click="isMenuOpen = !isMenuOpen">
          <Menu v-if="!isMenuOpen" />
          <X v-else />
        </button>
      </div>
    </nav>

    <!-- Hero Section (Corporate Influence) -->
    <section class="relative min-h-screen flex items-center pt-24 md:pt-20 pb-32 md:pb-40 overflow-hidden">
      <!-- Background Image -->
      <div class="absolute inset-0 z-0">
        <img 
          src="/hero.png" 
          class="w-full h-full object-cover scale-105"
          alt="Power Infrastructure"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-industrial-dark via-industrial-dark/80 to-transparent"></div>
        <div class="absolute inset-0 bg-industrial-dark/40"></div>
      </div>

      <!-- Scroll Indicator -->
      <div class="absolute bottom-40 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50 z-30 hidden lg:flex">
        <div class="w-1 h-12 bg-gradient-to-b from-industrial-blue to-transparent rounded-full animate-bounce"></div>
      </div>

      <div class="relative z-10 max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
        <div 
          v-motion
          :initial="{ opacity: 0, x: -50 }"
          :enter="{ opacity: 1, x: 0 }"
        >
          <div class="flex items-center gap-3 mb-6 md:mb-8">
            <div class="h-px w-8 md:w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.3em] md:tracking-[0.5em] text-[10px] md:text-xs">Leaders in Energy & Infrastructure</span>
          </div>
          <h1 class="text-3xl sm:text-4xl md:text-[4em] font-display font-black uppercase italic leading-[1.1] mb-8 text-white drop-shadow-[0_5px_15px_rgba(0,0,0,0.5)]">
            POWERING <br/>
            <span class="text-industrial-blue">BANGLADESH</span> <br/>
            <span class="text-white/90">SINCE 1980</span>
          </h1>
          <p class="text-sm md:text-base text-slate-200 max-w-lg mb-8 md:mb-10 leading-relaxed font-medium">
            From utility-scale power plants to smart grid automation, Influx Group delivers the technical precision that moves nations.
          </p>
          <div class="flex flex-wrap gap-4 md:gap-5">
            <button class="bg-industrial-blue text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs flex items-center gap-3 hover:bg-industrial-red transition-all shadow-2xl hover:scale-105 active:scale-95">
              EXPLORE CATALOG <ChevronRight class="w-4 h-4" />
            </button>
            <button class="bg-white/5 border-2 border-white/20 text-white px-6 md:px-10 py-3 md:py-5 rounded-sm font-black uppercase tracking-widest text-[10px] md:text-xs backdrop-blur-md hover:bg-white/20 transition-all hover:border-white">
              CORPORATE PROFILE
            </button>
          </div>
        </div>

        <!-- Refined Floating Cards (LG Only to prevent Mobile Overlap) -->
        <div 
          class="hidden lg:grid grid-cols-2 gap-4 relative z-10"
          v-motion
          :initial="{ opacity: 0, scale: 0.8 }"
          :enter="{ opacity: 1, scale: 1 }"
          :delay="400"
        >
          <div class="glass-panel p-6 rounded-xl transform translate-y-8 hover:-translate-y-2 transition-all duration-500 cursor-pointer group">
            <ShieldCheck class="text-industrial-blue mb-4 group-hover:scale-110 transition-transform" />
            <h3 class="font-bold mb-2">Safety Core</h3>
            <p class="text-[10px] text-slate-400">Class 5 risk mitigation integrated.</p>
          </div>
          <div class="glass-panel p-6 rounded-xl hover:-translate-y-2 transition-all duration-500 cursor-pointer group">
            <Settings class="text-industrial-blue mb-4 group-hover:rotate-90 transition-transform duration-700" />
            <h3 class="font-bold mb-2">Turnkey EPC</h3>
            <p class="text-[10px] text-slate-400">End-to-end project management.</p>
          </div>
          <div class="col-span-2 glass-panel p-6 rounded-xl flex items-center justify-between hover:bg-industrial-blue/10 transition-colors">
            <div>
              <h3 class="text-2xl font-display font-black flex items-center gap-2">
                ISO <span class="text-[10px] text-industrial-blue bg-industrial-blue/10 px-2 py-0.5 rounded uppercase">9001:2015</span>
              </h3>
              <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Certified Compliance</p>
            </div>
            <Activity class="w-8 h-8 text-industrial-blue animate-pulse" />
          </div>
        </div>
      </div>

      <!-- Quick Category Bar (JRC/Energypac inspired) -->
      <div class="absolute bottom-0 w-full bg-white/5 backdrop-blur-3xl border-t border-white/10 overflow-x-auto">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 divide-x divide-white/10 min-w-[600px] md:min-w-0">
          <div v-for="cat in productCategories" :key="cat.name" class="py-6 md:py-8 px-0 group cursor-pointer hover:bg-white/5 transition-colors">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 flex items-center justify-center">
                <component :is="cat.icon" class="w-6 h-6 md:w-8 md:h-8 text-industrial-blue group-hover:text-industrial-red transition-colors" />
              </div>
              <div>
                <div class="text-[8px] md:text-[10px] text-slate-500 font-black uppercase tracking-widest">{{ cat.count }} Models</div>
                <div class="font-display font-black uppercase text-base md:text-xl group-hover:text-industrial-blue transition-colors leading-tight">{{ cat.name }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Brand Statement / Trust Section -->
    <section class="py-20 md:py-32 bg-white text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-center">
          <div v-motion-slide-visible-left>
             <h2 class="text-4xl md:text-5xl font-display font-black uppercase leading-[0.9] mb-8">
               ESTABLISHED <br/> <span class="text-industrial-blue">AUTHORITY</span> <br/> IN HEAVY ENGINEERING
             </h2>
             <p class="text-slate-600 text-base md:text-lg leading-relaxed mb-8">
               Following the legacy of JRC and Energypac, Influx Group has evolved into a multi-sector engineering conglomerate. We specialize in EPC contracts, high-capacity switchgears, and power generation maintenance.
             </p>
             <div class="grid grid-cols-2 gap-8 md:gap-12">
               <div v-for="stat in stats" :key="stat.label" class="border-l-4 border-industrial-blue pl-4 md:pl-6 py-2">
                 <div class="text-3xl md:text-4xl font-display font-black text-industrial-blue">{{ stat.value }}</div>
                 <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ stat.label }}</div>
               </div>
             </div>
          </div>
          <div class="relative group overflow-hidden rounded-sm h-[400px] md:h-[500px]" v-motion-slide-visible-right>
            <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200" class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-110" />
            <div class="absolute inset-0 bg-industrial-blue/10 mix-blend-multiply"></div>
            <div class="absolute bottom-6 md:bottom-10 left-6 md:left-10 p-6 md:p-8 bg-industrial-blue text-white shadow-2xl max-w-[200px] md:max-w-xs transition-all opacity-0 md:opacity-100 group-hover:opacity-100">
               <div class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 opacity-70">Core Reliability</div>
               <div class="text-xl md:text-2xl font-display font-bold italic leading-tight">"Zero Downtime Operation Protocols"</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section Pattan (Product Matrix - JRC Inspired) -->
    <section class="py-20 md:py-32 bg-industrial-light text-industrial-dark overflow-hidden">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 md:mb-20 gap-8">
          <div v-motion-slide-visible-left>
            <div class="flex items-center gap-2 mb-4">
              <span class="w-8 h-1 bg-industrial-red"></span>
              <span class="text-industrial-red font-black uppercase tracking-widest text-xs">Section Pattan</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic leading-none">THE PRODUCT <br/> <span class="text-industrial-blue">HIERARCHY</span></h2>
          </div>
          <p class="max-w-md text-slate-500 font-medium leading-relaxed sm:text-lg" v-motion-slide-visible-right>
            Synthesizing industrial-grade reliability with modern engineering standards. All units IEEE and ISO certified.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-0 md:divide-x divide-industrial-blue/10 border border-industrial-blue/10">
          <div 
            v-for="(product, idx) in products" 
            :key="idx"
            class="group relative bg-white p-6 md:p-8 hover:bg-slate-50 transition-all duration-500 cursor-pointer overflow-hidden border-b md:border-b-0 border-industrial-blue/10"
            v-motion-slide-visible-bottom
            :delay="idx * 100"
          >
            <div class="relative z-10">
              <div class="mb-10 aspect-square overflow-hidden rounded-sm bg-slate-100 group-hover:shadow-xl transition-all duration-500">
                <img :src="product.image" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105" />
              </div>
              <div class="flex items-center gap-2 mb-4">
                 <div :class="`w-2 h-2 rounded-full bg-${product.color}`"></div>
                 <span class="text-[10px] font-mono font-bold text-slate-400 group-hover:text-industrial-dark transition-colors">{{ product.model }}</span>
              </div>
              <h3 class="text-2xl font-display font-black uppercase italic mb-4 leading-tight group-hover:text-industrial-blue transition-colors">{{ product.title }}</h3>
              <p class="text-sm text-slate-500 leading-relaxed mb-8 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                {{ product.desc }}
              </p>
              <div class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest" :class="`text-${product.color}`">
                TECHNICAL DATA <ArrowUpRight class="w-3 h-3 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
              </div>
            </div>
            <!-- Decorative background text -->
            <div class="absolute -bottom-4 -right-4 text-8xl font-black text-slate-50 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity select-none pointer-events-none uppercase">
               {{ product.title.split(' ')[0] }}
            </div>
          </div>
        </div>

        <!-- Global Catalogue Button -->
        <div class="mt-20 text-center">
           <button class="group border-b-2 border-industrial-blue text-industrial-blue font-black uppercase tracking-[0.4em] text-xs py-2 hover:border-industrial-red hover:text-industrial-red transition-all">
             BROWSE COMPLETE SOLUTION MATRIX <ChevronRight class="inline w-4 h-4" />
           </button>
        </div>
      </div>
    </section>

    <!-- Success Matrix (Engineering Scale) -->
    <section class="py-20 md:py-32 bg-industrial-dark text-white relative">
      <div class="absolute top-0 right-0 w-1/3 h-full bg-industrial-blue/5 blur-[120px]"></div>
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-12 md:gap-16 items-center">
          <div class="lg:col-span-4" v-motion-slide-visible-left>
             <span class="text-industrial-red font-black uppercase tracking-widest text-[10px] block mb-4 underline decoration-2 underline-offset-8">Featured Deployments</span>
             <h2 class="text-5xl md:text-6xl font-display font-black uppercase italic leading-[0.9] mb-10 text-gradient-blue shadow-white/10 shadow-sm">THE ENERGY <br/> <span class="text-white">MATRIX</span></h2>
             <p class="text-slate-400 leading-relaxed mb-10 text-base md:text-lg">
               Engineering large-scale infrastructure requires more than just parts; it requires a legacy of trust and a vision for long-term sustainability.
             </p>
             <button class="w-full py-4 md:py-5 border-2 border-industrial-blue text-industrial-blue font-black uppercase tracking-[0.3em] text-[10px] hover:bg-industrial-blue hover:text-white transition-all rounded-sm shadow-lg">
                GLOBAL PROJECT REPOSITORY
             </button>
          </div>
          <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-8" v-motion-slide-visible-right>
             <div v-for="(project, idx) in featuredProjects" :key="idx" class="relative group rounded-sm overflow-hidden aspect-[10/12] shadow-2xl">
                <img :src="project.image" class="w-full h-full object-cover grayscale brightness-75 transition-transform duration-[3s] group-hover:scale-110" />
                <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark via-industrial-dark/20 to-transparent"></div>
                <div class="absolute inset-0 border-4 md:border-8 border-transparent group-hover:border-industrial-blue/20 transition-all duration-500"></div>
                <div class="absolute bottom-0 left-0 p-8 md:p-10 w-full transition-transform duration-700 group-hover:-translate-y-2">
                   <div class="text-[10px] text-industrial-blue font-black uppercase tracking-[0.4em] mb-4 drop-shadow-lg">{{ project.type }}</div>
                   <h3 class="text-3xl md:text-4xl font-display font-black uppercase italic mb-4 leading-tight shadow-black shadow-sm">{{ project.title }}</h3>
                   <div class="h-1 w-0 bg-industrial-blue group-hover:w-full transition-all duration-700"></div>
                </div>
             </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Technical Spec / Monitoring (Tech Forward) -->
    <section class="py-32 bg-white text-industrial-dark">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 md:gap-24 items-center">
            <div v-motion-slide-visible-left>
               <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-industrial-blue mb-4">Real-Time Operational Core</h3>
               <h2 class="text-5xl font-display font-black uppercase italic leading-[0.9] mb-8">PRECISION <br/> <span class="text-industrial-red">MONITORING</span> SYSTEM</h2>
               <p class="text-slate-500 mb-10 leading-relaxed font-medium">
                 All our installations come with integrated smart-monitoring. Track load, efficiency, and maintenance cycles from any central location.
               </p>
               <div class="space-y-4">
                  <div v-for="n in 3" :key="n" class="flex items-center justify-between p-4 bg-slate-50 border-r-4 border-industrial-blue rounded-r-sm">
                    <span class="text-xs font-black uppercase tracking-widest">Active System {{ n }}</span>
                    <span class="text-xs text-industrial-blue font-bold">100% OPERATIONAL</span>
                  </div>
               </div>
            </div>
            <div class="relative glass-panel-light p-4 md:p-8 rounded-lg shadow-2xl" v-motion-slide-visible-right>
               <div class="aspect-video lg:aspect-square bg-slate-900 rounded-lg p-1 text-blue-400 font-mono text-[10px] overflow-hidden shadow-2xl">
                  <div class="flex items-center justify-between p-2 bg-slate-800 rounded-t-sm">
                     <span>SYSTEM_LOG: SESSION_45</span>
                     <div class="flex gap-1">
                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                        <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                     </div>
                  </div>
                  <div class="p-4 space-y-2 opacity-70">
                     <div v-for="n in 12" :key="n" class="flex gap-4">
                        <span class="text-slate-600">[{{ 1000 + n }}]</span>
                        <span>0x{{ Math.random().toString(16).slice(2, 10).toUpperCase() }} : SYNC_COMPLETE</span>
                     </div>
                  </div>
                  <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-slate-900/90"></div>
               </div>
               <div class="absolute -bottom-6 -right-6 bg-industrial-blue text-white p-6 shadow-2xl">
                  <div class="text-4xl font-display font-black">99.9%</div>
                  <div class="text-[8px] font-black uppercase tracking-widest">Efficiency Rating</div>
               </div>
            </div>
        </div>
      </div>
    </section>

    <!-- Partners / Network -->
    <section class="py-20 bg-industrial-dark overflow-hidden border-y border-white/5 relative z-10">
       <div class="flex animate-marquee whitespace-nowrap opacity-20 hover:opacity-100 transition-opacity duration-[1s]">
          <div v-for="i in 2" :key="i" class="flex gap-24 items-center justify-around min-w-full grayscale">
             <span v-for="name in ['ENERGYPAC', 'SIEMENS', 'ABB', 'GE POWER', 'JRC GROUP', 'POWERTRAC', 'SCHNEIDER']" :key="name" class="text-6xl font-display font-black text-white px-4 border-l-2 border-industrial-blue">
                {{ name }}
             </span>
          </div>
       </div>
    </section>

    <!-- Final CTA / Contact -->
    <section class="py-32 bg-industrial-light text-industrial-dark relative">
      <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 md:gap-16 items-center">
         <div v-motion-slide-visible-left>
            <h2 class="text-7xl font-display font-black uppercase italic leading-[0.8] mb-8">INITIATE <br/> <span class="text-industrial-blue">ACCESS</span></h2>
            <p class="text-lg text-slate-500 font-medium mb-12">Connect with our corporate engineering team for specialized EPC inquiries and solution architecture.</p>
            <div class="grid grid-cols-2 gap-8">
               <div>
                  <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Corporate HQ</div>
                  <p class="text-sm font-bold leading-relaxed">Level 12, Energy Plaza, <br/> Tejgaon I/A, Dhaka</p>
               </div>
               <div>
                  <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Direct Line</div>
                  <p class="text-sm font-bold leading-relaxed">+880 2 987 6543 <br/> contact@influxgroup.com</p>
               </div>
            </div>
         </div>
         <form @submit.prevent class="bg-white p-8 md:p-12 shadow-2xl border-t-8 border-industrial-blue rounded-sm" v-motion-slide-visible-right>
            <div class="space-y-6">
               <div class="grid grid-cols-2 gap-6">
                  <div class="space-y-1">
                     <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Contact Person</label>
                     <input type="text" placeholder="Full Name" class="w-full border-b-2 border-slate-200 py-3 focus:outline-none focus:border-industrial-blue transition-colors font-bold text-sm" />
                  </div>
                  <div class="space-y-1">
                     <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Email Hub</label>
                     <input type="email" placeholder="Corporate Email" class="w-full border-b-2 border-slate-200 py-3 focus:outline-none focus:border-industrial-blue transition-colors font-bold text-sm" />
                  </div>
               </div>
               <div class="space-y-1">
                  <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Project Protocol</label>
                  <select class="w-full border-b-2 border-slate-200 py-3 focus:outline-none focus:border-industrial-blue transition-colors font-bold text-sm bg-transparent appearance-none">
                     <option>EPC SOLUTIONS</option>
                     <option>PRODUCT PROCUREMENT</option>
                     <option>SYSTEM MAINTENANCE</option>
                  </select>
               </div>
               <div class="space-y-1">
                  <label class="text-[10px] font-black uppercase tracking-widest text-slate-500">Inquiry Data</label>
                  <textarea rows="3" placeholder="Describe requirements..." class="w-full border-b-2 border-slate-200 py-3 focus:outline-none focus:border-industrial-blue transition-colors font-bold text-sm resize-none"></textarea>
               </div>
               <button class="w-full bg-industrial-blue hover:bg-industrial-red text-white py-5 font-black uppercase tracking-[0.5em] text-xs transition-colors rounded-sm shadow-xl flex items-center justify-center gap-3">
                  TRANSMIT DATA <ArrowRight class="w-4 h-4" />
               </button>
            </div>
         </form>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 bg-white border-t border-slate-200 text-industrial-dark">
       <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-12 border-b border-slate-100 pb-16 mb-16">
          <div class="md:col-span-1">
             <div class="flex items-center gap-2 mb-6">
                <Zap class="text-industrial-blue w-6 h-6" />
                <span class="text-xl font-display font-black tracking-tighter uppercase italic">
                  INFLUX<span class="text-industrial-blue">GROUP</span>
                </span>
             </div>
             <p class="text-xs text-slate-500 font-medium leading-relaxed">
               Bangladesh's premier engineering conglomerate specializing in high-voltage infrastructure and renewable grid systems.
             </p>
          </div>
          <div v-for="col in 3" :key="col" class="space-y-6">
             <h4 class="text-xs font-black uppercase tracking-[0.2em] text-industrial-blue">Quick Portal</h4>
             <ul class="space-y-3 text-[11px] font-bold text-slate-400 uppercase">
                <li><a href="#" class="hover:text-industrial-blue transition-colors">Career Opportunities</a></li>
                <li><a href="#" class="hover:text-industrial-blue transition-colors">Investor Relations</a></li>
                <li><a href="#" class="hover:text-industrial-blue transition-colors">Technical Library</a></li>
                <li><a href="#" class="hover:text-industrial-blue transition-colors">Support Hub</a></li>
             </ul>
          </div>
       </div>
       <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
          <div class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-400">
             © 2026 INFLUX GROUP ENGINEERING. ALL RIGHTS RESERVED. ISO 9001:2015 CERTIFIED.
          </div>
          <div class="flex gap-8 text-[9px] font-black uppercase tracking-[0.3em]">
             <a href="#" class="text-slate-400 hover:text-industrial-blue transition-colors">Privacy Protocol</a>
             <a href="#" class="text-slate-400 hover:text-industrial-blue transition-colors">Cyber Security</a>
             <a href="#" class="text-slate-400 hover:text-industrial-blue transition-colors">LinkedIn</a>
          </div>
       </div>
    </footer>

  </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Outfit:wght@700;800;900&display=swap');

html {
  scroll-behavior: smooth;
}
</style>
