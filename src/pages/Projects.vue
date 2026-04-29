<script setup>
import { ref } from 'vue'
import { MapPin, Zap, Building2, Calendar, Filter, ArrowRight } from 'lucide-vue-next'

const activeFilter = ref('all')

const filters = [
  { id: 'all', name: 'All Projects' },
  { id: 'power', name: 'Power Plants' },
  { id: 'transmission', name: 'Transmission' },
  { id: 'renewable', name: 'Renewable Energy' },
  { id: 'industrial', name: 'Industrial' }
]

const projects = [
  {
    id: 1,
    title: 'Matarbari Ultra Mega Power Project',
    location: 'Cox\'s Bazar, Bangladesh',
    capacity: '1200 MW',
    type: 'power',
    category: 'Coal-fired Power Plant',
    completion: '2024',
    client: 'Bangladesh Power Development Board',
    value: 'BDT 40,000 Cr',
    image: 'https://images.unsplash.com/photo-1466611653911-95282fc3656b?auto=format&fit=crop&q=80&w=1200',
    scope: ['Design & Engineering', 'Equipment Supply', 'Installation & Commissioning', 'Operation & Maintenance'],
    highlights: ['First ultra-super critical plant in Bangladesh', '1200MW generation capacity', 'Deep sea water cooling system', 'Environmental compliance systems']
  },
  {
    id: 2,
    title: 'Payra Thermal Power Plant',
    location: 'Patuakhali, Bangladesh',
    capacity: '1320 MW',
    type: 'power',
    category: 'Coal-fired Power Plant',
    completion: '2023',
    client: 'NWPGCL',
    value: 'BDT 35,000 Cr',
    image: 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?auto=format&fit=crop&q=80&w=1200',
    scope: ['Boiler Supply', 'Turbine Generator', 'Switchyard', 'Control Systems'],
    highlights: ['Ultra-super critical technology', '1320MW total capacity', 'Two units of 660MW each', 'Efficiency rate >45%']
  },
  {
    id: 3,
    title: 'National Grid Transmission Upgrade',
    location: 'Nationwide, Bangladesh',
    capacity: '400 kV',
    type: 'transmission',
    category: 'Transmission Network',
    completion: '2024',
    client: 'Power Grid Company of Bangladesh',
    value: 'BDT 8,000 Cr',
    image: 'https://images.unsplash.com/photo-1518709766631-a6a7f45921c3?auto=format&fit=crop&q=80&w=1200',
    scope: ['400kV Transmission Lines', 'Grid Substations', 'Protection Systems', 'Telecommunication'],
    highlights: ['1000+ circuit kilometers', '400kV voltage level', 'National grid integration', 'Smart grid features']
  },
  {
    id: 4,
    title: 'Mongla 50MW Solar Park',
    location: 'Mongla, Bangladesh',
    capacity: '50 MW',
    type: 'renewable',
    category: 'Solar Power Plant',
    completion: '2023',
    client: 'Bangladesh Solar & Renewable Energy',
    value: 'BDT 350 Cr',
    image: 'https://images.unsplash.com/photo-1509391366360-fe5bb658589d?auto=format&fit=crop&q=80&w=1200',
    scope: ['EPC Contract', 'Solar Panels Supply', 'Inverter Systems', 'Grid Integration'],
    highlights: ['50MW generation capacity', '150,000+ solar panels', 'Grid-connected system', 'Annual generation 85GWh']
  },
  {
    id: 5,
    title: 'Karnaphuli Wind Farm',
    location: 'Chittagong Hill Tracts',
    capacity: '120 MW',
    type: 'renewable',
    category: 'Wind Power Plant',
    completion: '2025',
    client: 'Bangladesh Power Development Board',
    value: 'BDT 900 Cr',
    image: 'https://images.unsplash.com/photo-1532601224476-15c79f2f7a51?auto=format&fit=crop&q=80&w=1200',
    scope: ['Wind Turbine Supply', 'Civil Works', 'Transmission Lines', 'Grid Integration'],
    highlights: ['48 wind turbines', '2.5MW each turbine', 'Terrain-optimized layout', 'First major wind farm']
  },
  {
    id: 6,
    title: 'BSRM Steel Plant Electrification',
    location: 'Chittagong, Bangladesh',
    capacity: '100 MVA',
    type: 'industrial',
    category: 'Industrial Power System',
    completion: '2023',
    client: 'BSRM Steel Mills',
    value: 'BDT 250 Cr',
    image: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=1200',
    scope: ['Power Distribution', 'Motor Control Centers', 'Automation Systems', 'Power Factor Correction'],
    highlights: ['100MVA distribution system', 'Complete electrification', 'State-of-the-art automation', '24/7 operation']
  }
]
</script>

<template>
  <div class="min-h-screen bg-industrial-light">
    <!-- Hero Section -->
    <section class="relative py-32 bg-industrial-dark text-white overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-industrial-blue/10 to-transparent"></div>
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div v-motion-slide-visible-left>
          <div class="flex items-center gap-3 mb-6">
            <div class="h-px w-12 bg-industrial-blue"></div>
            <span class="text-industrial-blue font-black uppercase tracking-[0.5em] text-xs">Our Projects</span>
          </div>
          <h1 class="text-5xl md:text-7xl font-display font-black uppercase italic leading-[0.9] mb-8">
            BUILDING <span class="text-industrial-blue">BANGLADESH</span>
          </h1>
          <p class="text-xl text-slate-300 max-w-3xl leading-relaxed">
            From mega power projects to renewable energy installations, we deliver engineering excellence that powers the nation.
          </p>
        </div>
      </div>
    </section>

    <!-- Filter Section -->
    <section class="py-12 bg-white border-b sticky top-20 z-30 shadow-md">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-wrap gap-4 justify-center">
          <button
            v-for="filter in filters"
            :key="filter.id"
            @click="activeFilter = filter.id"
            class="flex items-center gap-2 px-6 py-3 rounded-sm font-bold uppercase text-xs tracking-wider transition-all"
            :class="activeFilter === filter.id ? 'bg-industrial-blue text-white' : 'bg-industrial-light text-industrial-dark hover:bg-industrial-blue/10'"
          >
            <Filter class="w-4 h-4" />
            {{ filter.name }}
          </button>
        </div>
      </div>
    </section>

    <!-- Projects Grid -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="(project, index) in projects.filter(p => activeFilter === 'all' || p.type === activeFilter)"
            :key="project.id"
            class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group"
            v-motion-slide-visible-bottom
            :delay="index * 100"
          >
            <!-- Image -->
            <div class="relative h-64 overflow-hidden">
              <img
                :src="project.image"
                :alt="project.title"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-industrial-dark/80 to-transparent"></div>

              <!-- Capacity Badge -->
              <div class="absolute top-4 right-4 bg-industrial-blue text-white px-4 py-2 rounded-sm">
                <div class="text-xs font-black uppercase tracking-wider">{{ project.capacity }}</div>
              </div>

              <!-- Category Badge -->
              <div class="absolute top-4 left-4 bg-industrial-red text-white px-3 py-1 rounded-full text-xs font-bold uppercase">
                {{ project.category }}
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <h3 class="text-xl font-display font-black uppercase italic mb-4 group-hover:text-industrial-blue transition-colors">
                {{ project.title }}
              </h3>

              <!-- Location -->
              <div class="flex items-center gap-2 text-slate-600 mb-4">
                <MapPin class="w-4 h-4" />
                <span class="text-sm">{{ project.location }}</span>
              </div>

              <!-- Project Details -->
              <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                  <div class="text-xs font-black uppercase tracking-wider text-slate-500 mb-1">Completion</div>
                  <div class="flex items-center gap-2 text-sm font-bold">
                    <Calendar class="w-4 h-4 text-industrial-blue" />
                    {{ project.completion }}
                  </div>
                </div>
                <div>
                  <div class="text-xs font-black uppercase tracking-wider text-slate-500 mb-1">Client</div>
                  <div class="text-sm font-bold">{{ project.client }}</div>
                </div>
              </div>

              <!-- Scope -->
              <div class="mb-6">
                <div class="text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Project Scope</div>
                <div class="flex flex-wrap gap-2">
                  <span
                    v-for="(scope, idx) in project.scope.slice(0, 3)"
                    :key="idx"
                    class="bg-industrial-light text-industrial-dark px-3 py-1 rounded text-xs font-medium"
                  >
                    {{ scope }}
                  </span>
                </div>
              </div>

              <!-- CTA -->
              <button class="w-full bg-industrial-blue text-white py-3 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-red transition-colors flex items-center justify-center gap-2 group-hover:gap-4">
                View Details <ArrowRight class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-32 bg-industrial-dark text-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 text-center">
          <div v-motion-slide-visible-bottom>
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">50+</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Projects Completed</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="100">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">5 GW</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Total Capacity</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="200">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">99.9%</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">On-Time Delivery</div>
          </div>
          <div v-motion-slide-visible-bottom :delay="300">
            <div class="text-5xl font-display font-black text-industrial-blue mb-2">25+</div>
            <div class="text-xs font-black uppercase tracking-widest text-slate-400">Years Experience</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 bg-industrial-blue text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-display font-black uppercase italic mb-8">
          Start Your <span class="text-yellow-400">Project</span>
        </h2>
        <p class="text-xl mb-12 text-industrial-100">
          Let's discuss how we can power your next project
        </p>
        <button class="bg-white text-industrial-blue px-12 py-5 rounded-sm font-black uppercase tracking-widest text-xs hover:bg-industrial-dark hover:text-white transition-all shadow-2xl">
          Get In Touch
        </button>
      </div>
    </section>
  </div>
</template>
