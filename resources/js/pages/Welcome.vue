<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';
import { Button } from '@/components/ui/button';
import {
    Zap,
    Settings,
    Shield,
    Activity,
    ArrowRight,
    CheckCircle2,
    Users,
    Trophy,
    Phone,
    Mail,
    MapPin,
    BarChart3,
    Cpu,
    Globe,
    Menu,
    X,
    Lightbulb,
    Lock,
    Timer,
    ZapOff
} from 'lucide-vue-next';
import { ref, onMounted, nextTick } from 'vue';
import { useIntersectionObserver } from '@vueuse/core';

defineProps<{
    canRegister: boolean;
}>();

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

// Animation logic
const revealRefs = ref<HTMLElement[]>([]);
const setRevealRef = (el: any) => {
    if (el && !revealRefs.value.includes(el)) {
        revealRefs.value.push(el);
    }
};

const initAnimations = () => {
    revealRefs.value.forEach((el) => {
        const delay = el.getAttribute('data-delay') || '0';
        const transition = el.getAttribute('data-transition') || 'fade-up';
        
        useIntersectionObserver(
            el,
            ([{ isIntersecting }]) => {
                if (isIntersecting) {
                    setTimeout(() => {
                        el.classList.add('reveal-active');
                        el.classList.remove('reveal-hidden');
                    }, parseInt(delay));
                }
            },
            { threshold: 0.1 }
        );
    });
};

onMounted(() => {
    nextTick(() => {
        initAnimations();
    });
});

const stats = [
    { label: 'Market Experience', value: '25+', icon: Trophy, delay: 0 },
    { label: 'Global Projects', value: '1.2k', icon: CheckCircle2, delay: 100 },
    { label: 'Certified Staff', value: '150+', icon: Users, delay: 200 },
    { label: 'Trust Rating', value: '99%', icon: Shield, delay: 300 },
];

const technicalSpecs = [
    { feature: 'Voltage Capacity', spec: 'Up to 500kV', detail: 'High-tension industrial distribution' },
    { feature: 'Response Time', spec: '< 50ms', detail: 'Advanced automated grid switching' },
    { label: 'System Up-time', spec: '99.99%', detail: 'Redundant power backup infrastructure' },
    { label: 'Efficiency Rating', spec: 'IE4 Class', detail: 'Premium efficiency motors & drives' },
];

const projects = [
    {
        title: 'Project CP-019-B',
        category: 'Control Systems',
        image: '/images/project_1.png',
        location: 'Industrial Zone A',
        desc: 'Integrated control matrix for automated manufacturing.'
    },
    {
        title: 'Grid Node Substation',
        category: 'Power Grid',
        image: '/images/project_2.png',
        location: 'Metropolitan Grid',
        desc: '500kV substation upgrade with smart monitoring.'
    }
];

const mainServices = [
    { title: 'Smart Grid Solutions', icon: Zap, text: 'Next-generation power distribution with real-time analytics.' },
    { title: 'Critical Infrastructure', icon: Lock, text: 'Fortified power systems for mission-critical facilities.' },
    { title: 'Automation Matrix', icon: Cpu, text: 'Custom PLC and SCADA systems for industrial control.' },
];
</script>

<template>
    <Head title="InfluxGroup | Engineering Excellence" />

    <div class="min-h-screen bg-slate-50 font-sans selection:bg-industrial-orange selection:text-white dark:bg-[#020617] text-slate-900 dark:text-slate-100 overflow-x-hidden">
        
        <!-- Navigation -->
        <nav 
            :class="[
                'fixed top-0 z-[100] w-full transition-all duration-700 ease-out border-b border-transparent',
                isScrolled ? 'glass-dark py-3 !border-white/10 shadow-2xl backdrop-blur-2xl' : 'bg-transparent py-8'
            ]"
        >
            <div class="container mx-auto flex items-center justify-between px-6 lg:px-12">
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-industrial-orange transition-transform duration-500 group-hover:rotate-[360deg]">
                        <Zap class="h-7 w-7 text-white" />
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-2xl font-black tracking-tighter text-white">
                            INFLUX<span class="text-industrial-orange">GROUP</span>
                        </span>
                        <span class="text-[10px] font-bold tracking-[0.3em] text-white/50 uppercase">Engineering Matrix</span>
                    </div>
                </div>

                <div class="hidden items-center gap-10 lg:flex">
                    <a v-for="item in ['Services', 'Technical', 'Projects', 'Contact']" :key="item" :href="'#' + item.toLowerCase()" class="relative text-sm font-bold tracking-widest text-white/70 uppercase transition-all hover:text-white hover:tracking-[0.2em] after:absolute after:-bottom-1 after:left-0 after:h-[2px] after:w-0 after:bg-industrial-orange after:transition-all hover:after:w-full">
                        {{ item }}
                    </a>
                    
                    <div class="h-8 w-[1px] bg-white/10 mx-2"></div>

                    <template v-if="!$page.props.auth.user">
                        <Link :href="login()" class="text-sm font-bold text-white hover:text-industrial-orange transition-colors">LOGIN</Link>
                        <Button as-child class="h-11 bg-industrial-orange px-6 text-xs font-black tracking-widest hover:bg-industrial-orange/80 transition-all hover:scale-105 shadow-lg shadow-industrial-orange/20">
                            <Link :href="register()">PARTNER WITH US</Link>
                        </Button>
                    </template>
                    <Link v-else :href="dashboard()" class="text-sm font-bold text-white hover:text-industrial-orange">DASHBOARD</Link>
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white lg:hidden">
                    <Menu v-if="!mobileMenuOpen" class="h-8 w-8" />
                    <X v-else class="h-8 w-8" />
                </button>
            </div>
            
            <!-- Mobile Drawer -->
            <transition name="fade">
                <div v-if="mobileMenuOpen" class="fixed inset-0 top-[72px] z-50 bg-[#020617]/95 backdrop-blur-xl lg:hidden">
                    <div class="flex flex-col items-center justify-center h-full gap-8 p-12 text-center">
                        <a v-for="item in ['Services', 'Technical', 'Projects', 'Contact']" :key="item" @click="mobileMenuOpen = false" :href="'#' + item.toLowerCase()" class="text-3xl font-black text-white hover:text-industrial-orange uppercase tracking-tighter">{{ item }}</a>
                        <div class="w-full h-[1px] bg-white/10 my-4"></div>
                        <Button as-child size="lg" class="w-full h-16 bg-industrial-orange text-xl font-black">
                            <Link :href="register()">GET STARTED</Link>
                        </Button>
                    </div>
                </div>
            </transition>
        </nav>

        <!-- Hero: Industrial Matrix -->
        <section class="relative flex min-h-screen items-center justify-center overflow-hidden">
            <!-- Background Image with Parallax-like effect -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="/images/hero_bg.png" 
                    alt="Industrial Facility" 
                    class="h-full w-full object-cover scale-110 motion-safe:animate-slow-zoom brightness-[0.25]"
                />
                <div class="absolute inset-0 bg-gradient-to-tr from-[#020617] via-transparent to-industrial-navy/30"></div>
                <!-- Technical Overlay Grid -->
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
            </div>

            <div class="container relative z-10 mx-auto px-6 py-32 text-left lg:px-12">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div 
                        ref="setRevealRef"
                        class="reveal-hidden transition-all duration-1000 transform lg:max-w-3xl"
                    >
                        <div class="flex items-center gap-4 mb-8">
                            <div class="h-[2px] w-12 bg-industrial-orange"></div>
                            <span class="text-sm font-black tracking-[0.5em] text-industrial-orange uppercase">Industrial Strength Solution</span>
                        </div>
                        
                        <h1 class="text-6xl font-black leading-[0.9] text-white md:text-8xl lg:text-9xl mb-8 tracking-tighter">
                            CORE<br />
                            <span class="text-industrial-orange">ENERGY</span><br />
                            MATRIX.
                        </h1>
                        
                        <p class="mt-6 max-w-xl text-lg md:text-xl leading-relaxed text-slate-400 font-medium">
                            Redefining power infrastructure through precision engineering. Our systems provide a 99.9% reliability threshold for global industrial hubs.
                        </p>

                        <div class="mt-12 flex flex-col sm:flex-row items-center gap-6">
                            <Button size="lg" class="h-16 bg-industrial-orange px-10 text-lg font-black tracking-widest hover:bg-industrial-orange/90 transition-all hover:px-12 group shadow-2xl shadow-industrial-orange/30">
                                INITIALIZE PROTOCOL <ArrowRight class="ml-3 h-6 w-6 transition-transform group-hover:translate-x-2" />
                            </Button>
                            <a href="#technical" class="flex items-center gap-3 text-sm font-bold tracking-widest text-white hover:text-industrial-orange transition-all group">
                                VIEW SPECS <div class="h-10 w-10 flex items-center justify-center rounded-full border border-white/20 group-hover:border-industrial-orange transition-all"><BarChart3 class="h-4 w-4" /></div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="hidden lg:block">
                        <!-- Floating Tech Cards -->
                        <div class="relative h-[600px] w-full">
                            <div 
                                v-for="(card, i) in mainServices" :key="i"
                                ref="setRevealRef"
                                :data-delay="400 + (i * 150)"
                                class="reveal-hidden absolute frosted dark:frosted-dark p-6 rounded-2xl w-64 transition-all duration-1000 border border-white/10 backdrop-blur-2xl"
                                :style="{ 
                                    top: `${20 + (i * 120)}px`, 
                                    left: `${i * 80}px`,
                                    zIndex: 3 - i
                                }"
                            >
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-industrial-orange/20 text-industrial-orange mb-4">
                                    <component :is="card.icon" class="h-6 w-6" />
                                </div>
                                <h3 class="text-white font-bold text-lg mb-2">{{ card.title }}</h3>
                                <p class="text-xs text-slate-400 leading-normal">{{ card.text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Nav Markers -->
            <div class="absolute right-10 top-1/2 -translate-y-1/2 flex flex-col gap-6 hidden xl:flex">
                <div v-for="i in 4" :key="i" class="h-2 w-2 rounded-full bg-white/20 hover:bg-industrial-orange transition-all cursor-pointer"></div>
            </div>
        </section>

        <!-- Stats Matrix -->
        <section class="relative bg-[#020617] py-20 border-y border-white/5">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12">
                    <div 
                        v-for="(stat, i) in stats" :key="i"
                        ref="setRevealRef"
                        :data-delay="stat.delay"
                        class="reveal-hidden group text-center"
                    >
                        <div class="text-5xl md:text-7xl font-black text-white mb-2 tracking-tighter group-hover:text-industrial-orange transition-colors">
                            {{ stat.value }}
                        </div>
                        <div class="text-[10px] uppercase tracking-[0.4em] font-black text-slate-500 group-hover:text-slate-300 transition-colors">
                            {{ stat.label }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Technical Specifications Table Section -->
        <section id="technical" class="py-32 bg-slate-50 dark:bg-[#020617] relative">
            <div class="container mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-20 items-center">
                    <div ref="setRevealRef" class="reveal-hidden">
                        <label class="text-industrial-orange font-black tracking-[0.4em] text-xs uppercase mb-4 block">System Performance</label>
                        <h2 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tighter mb-8 italic">TECHNICAL<br />SPECS.</h2>
                        
                        <div class="space-y-4">
                            <div 
                                v-for="(spec, i) in technicalSpecs" :key="i"
                                class="flex items-center justify-between p-6 rounded-2xl bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 hover:border-industrial-orange transition-all group"
                            >
                                <div>
                                    <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">{{ spec.feature || spec.label }}</h4>
                                    <p class="text-slate-900 dark:text-white font-bold">{{ spec.spec }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-500 max-w-[150px] leading-tight">{{ spec.detail }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <Button size="lg" variant="outline" class="mt-12 h-14 border-2 border-industrial-navy/10 dark:border-white/10 dark:text-white hover:border-industrial-orange transition-all">
                            DOWNLOAD DATASHEET
                        </Button>
                    </div>

                    <div class="relative group">
                        <div class="absolute -inset-4 bg-industrial-orange/20 blur-3xl rounded-full opacity-30 group-hover:opacity-50 transition-all duration-1000"></div>
                        <div class="relative rounded-3xl overflow-hidden glass p-1 transform skew-y-2 group-hover:skew-y-0 transition-all duration-700">
                             <img src="/images/project_2.png" class="rounded-2xl" alt="Technical Spec" />
                             <!-- Floating UI Overlay -->
                             <div class="absolute bottom-10 left-10 right-10 frosted p-6 rounded-2xl border border-white/20 backdrop-blur-3xl">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-white font-black tracking-widest text-[10px]">LIVE GRID STATUS</span>
                                    <div class="h-2 w-2 rounded-full bg-green-400 animate-pulse"></div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="h-10 w-full bg-white/5 rounded-lg flex items-center px-4"><div class="h-1 w-full bg-industrial-orange rounded-full"></div></div>
                                    <div class="text-white font-black text-xl">98%</div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Portfolio -->
        <section id="projects" class="py-32 bg-white dark:bg-[#020617] overflow-hidden">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
                    <div ref="setRevealRef" class="reveal-hidden">
                        <label class="text-industrial-orange font-black tracking-[0.4em] text-xs uppercase mb-4 block">Our Work</label>
                        <h2 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tighter">PROJECT<br />PORTFOLIO.</h2>
                    </div>
                    <p class="max-w-sm text-slate-500 dark:text-slate-400 font-medium">Selected deployments showcasing our range in high-tension power and automated control systems.</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12">
                    <div 
                        v-for="(project, i) in projects" :key="i"
                        ref="setRevealRef"
                        :data-delay="i * 200"
                        class="reveal-hidden group relative h-[500px] rounded-[40px] overflow-hidden cursor-pointer"
                    >
                        <img 
                            :src="project.image" 
                            class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110" 
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-industrial-navy via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-10 transform translate-y-6 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="inline-block px-4 py-1.5 rounded-full bg-industrial-orange text-[10px] font-black text-white uppercase tracking-widest mb-4">{{ project.category }}</span>
                            <h3 class="text-4xl font-black text-white mb-2">{{ project.title }}</h3>
                            <p class="text-white/60 mb-6 max-w-sm">{{ project.desc }}</p>
                            <div class="flex items-center gap-6">
                                <div class="flex items-center gap-2 text-white/40 text-xs font-bold uppercase tracking-widest"><MapPin class="h-4 w-4" /> {{ project.location }}</div>
                                <div class="h-10 w-10 flex items-center justify-center rounded-full bg-white/10 text-white group-hover:bg-industrial-orange transition-colors"><ArrowRight class="h-5 w-5" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners Marquee (Technical Style) -->
        <section class="bg-industrial-navy py-12 border-y border-white/5">
             <div class="container mx-auto px-6 mb-8 text-center">
                <span class="text-[10px] font-black tracking-[1em] text-white/30 uppercase">Operational Partnerships</span>
            </div>
            <div class="flex overflow-hidden opacity-40 hover:opacity-100 transition-opacity duration-1000">
                <div class="flex min-w-full animate-marquee items-center justify-around gap-20 py-4">
                    <span v-for="partner in partners" :key="partner" class="text-3xl font-black tracking-widest text-white italic transition-all hover:text-industrial-orange cursor-crosshair">/{{ partner.toUpperCase() }}/</span>
                </div>
                <div class="flex min-w-full animate-marquee items-center justify-around gap-20 py-4">
                    <span v-for="partner in partners" :key="partner + '2'" class="text-3xl font-black tracking-widest text-white italic transition-all hover:text-industrial-orange cursor-crosshair">/{{ partner.toUpperCase() }}/</span>
                </div>
            </div>
        </section>

        <!-- Contact Matrix -->
        <section id="contact" class="py-32 bg-slate-50 dark:bg-[#020617] relative">
            <div class="container mx-auto px-6 lg:px-12">
                <div class="max-w-6xl mx-auto rounded-[60px] bg-industrial-navy overflow-hidden relative border border-white/5">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10"></div>
                    
                    <div class="grid lg:grid-cols-2 relative z-10">
                        <div class="p-12 md:p-20 text-white">
                             <h2 class="text-5xl md:text-7xl font-black tracking-tighter mb-8 italic">SECURE<br />CONSULTATION.</h2>
                             <p class="text-slate-400 text-lg mb-12">Submit your facility specifications for a comprehensive node-reliability analysis.</p>
                             
                             <div class="space-y-8">
                                <div v-for="contact in [{icon: Phone, val: '+1 800 INFLUX'}, {icon: Mail, val: 'hq@influxgroup.io'}]" :key="contact.val" class="flex items-center gap-6 group">
                                    <div class="h-14 w-14 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 group-hover:border-industrial-orange transition-all"><component :is="contact.icon" class="h-6 w-6 text-industrial-orange" /></div>
                                    <span class="text-xl font-bold tracking-tight">{{ contact.val }}</span>
                                </div>
                             </div>

                             <div class="mt-12 overflow-hidden rounded-3xl border border-white/10 grayscale contrast-125 opacity-30">
                                <iframe src="https://www.google.com/maps/embed?..." width="100%" height="200" style="border:0;" loading="lazy"></iframe>
                             </div>
                        </div>

                        <div class="p-12 md:p-20 bg-white/5 backdrop-blur-2xl border-l border-white/5">
                            <form class="space-y-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Operator Name</label>
                                        <input class="w-full h-14 bg-white/5 border border-white/10 rounded-xl px-6 text-white focus:border-industrial-orange outline-none transition-all" />
                                    </div>
                                    <div class="space-y-4">
                                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Secure Email</label>
                                        <input class="w-full h-14 bg-white/5 border border-white/10 rounded-xl px-6 text-white focus:border-industrial-orange outline-none transition-all" />
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Protocol Type</label>
                                    <select class="w-full h-14 bg-white/5 border border-white/10 rounded-xl px-6 text-white focus:border-industrial-orange outline-none transition-all">
                                        <option>High Tension Grid Deployment</option>
                                        <option>Automated Matrix Integration</option>
                                    </select>
                                </div>
                                <div class="space-y-4">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Transmission</label>
                                    <textarea rows="4" class="w-full bg-white/5 border border-white/10 rounded-xl p-6 text-white focus:border-industrial-orange outline-none transition-all"></textarea>
                                </div>
                                <Button class="w-full h-16 bg-industrial-orange text-lg font-black tracking-widest group">
                                    ENGAGE PROJECT LINK <ArrowRight class="ml-4 h-6 w-6 transition-transform group-hover:translate-x-2" />
                                </Button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Footer -->
        <footer class="bg-[#020617] py-20 text-slate-500">
            <div class="container mx-auto px-6 lg:px-12 flex flex-col md:flex-row justify-between items-center gap-12">
                <div class="flex items-center gap-3 grayscale opacity-30">
                    <Zap class="h-6 w-6 text-white" />
                    <span class="text-xl font-black tracking-tighter text-white uppercase">INFLUX<span class="text-industrial-orange">GROUP</span></span>
                </div>
                <div class="flex gap-12 text-[10px] font-black tracking-widest uppercase">
                    <a href="#" class="hover:text-white transition-colors">Safety Protocols</a>
                    <a href="#" class="hover:text-white transition-colors">Privacy Encryption</a>
                    <a href="#" class="hover:text-white transition-colors">Legal Matrix</a>
                </div>
                <div class="text-[10px] font-bold">BY BD-CALLING • POWERED BY CORE MATRIX V4</div>
            </div>
        </footer>

    </div>
</template>

<style scoped>
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-marquee {
    animation: marquee 40s linear infinite;
    display: flex;
    width: 200%;
}

@keyframes slow-zoom {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
.animate-slow-zoom {
    animation: slow-zoom 20s ease-in-out infinite;
}

/* Scroll Animation Classes */
.reveal-hidden {
    opacity: 0;
    transform: translateY(40px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.reveal-active {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
