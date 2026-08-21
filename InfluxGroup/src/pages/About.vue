<script setup>
import { ref, computed, onMounted } from 'vue'
import {
  aboutHeroService,
  aboutMissionVisionService,
  aboutCoreValuesService,
  aboutJourneyService,
  aboutCertificationsService,
  aboutCareerCtaService
} from '../services/content'
import AboutHeroSection from '@/components/sections/AboutHeroSection.vue'
import MissionVisionSection from '@/components/sections/MissionVisionSection.vue'
import JourneySection from '@/components/sections/JourneySection.vue'
import CoreValuesSection from '@/components/sections/CoreValuesSection.vue'
import CertificationsSection from '@/components/sections/CertificationsSection.vue'
import ContactCtaSection from '@/components/sections/ContactCtaSection.vue'

const certifications = ref([
  'ISO 9001:2015',
  'ISO 14001:2015',
  'ISO 45001:2018',
  'IEC 60076',
  'IEEE Standards',
  'BPDB Approved'
])

// Hero data from API
const heroData = ref(null)

// Mission & Vision data from API
const missionVisionData = ref(null)

// Core Values data from API
const coreValuesData = ref(null)

// Journey data from API
const journeyData = ref(null)

// Career CTA data from API
const careerCtaData = ref(null)

const fetchHeroData = async () => {
  try {
    const response = await aboutHeroService.getHeroData()
    if (response && response.data) {
      heroData.value = response.data
    } else if (response) {
      heroData.value = response
    }
  } catch (error) {
    console.error('Failed to fetch hero data:', error)
  }
}

const fetchMissionVisionData = async () => {
  try {
    const response = await aboutMissionVisionService.getMissionVisionData()
    if (response && response.data) {
      missionVisionData.value = response.data
    } else if (response) {
      missionVisionData.value = response
    }
  } catch (error) {
    console.error('Failed to fetch mission & vision data:', error)
  }
}

const fetchCoreValuesData = async () => {
  try {
    const response = await aboutCoreValuesService.getCoreValuesData()
    if (response?.data) {
      coreValuesData.value = response.data
    } else if (response) {
      coreValuesData.value = response
    }
  } catch (error) {
    console.error('Failed to fetch core values data:', error)
  }
}

const fetchJourneyData = async () => {
  try {
    const response = await aboutJourneyService.getJourneyData()
    if (response && response.data) {
      journeyData.value = response.data
    } else if (response) {
      journeyData.value = response
    }
  } catch (error) {
    console.error('Failed to fetch journey data:', error)
  }
}

const fetchCertificationsData = async () => {
  try {
    const response = await aboutCertificationsService.getCertificationsData()
    if (response && response.data && Array.isArray(response.data.list) && response.data.list.length > 0) {
      certifications.value = response.data.list
    }
  } catch (error) {
    console.error('Failed to fetch certifications data:', error)
  }
}

const journey = computed(() => {
  if (journeyData.value?.milestones) {
    return journeyData.value
  }
  return {
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
})

const fetchCareerCtaData = async () => {
  try {
    const response = await aboutCareerCtaService.getCareerCtaData()
    if (response && response.data) {
      careerCtaData.value = response.data
    } else if (response) {
      careerCtaData.value = response
    }
  } catch (error) {
    console.error('Failed to fetch career CTA data:', error)
  }
}

onMounted(() => {
  fetchHeroData()
  fetchMissionVisionData()
  fetchCoreValuesData()
  fetchJourneyData()
  fetchCertificationsData()
  fetchCareerCtaData()
})
</script>

<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <AboutHeroSection :hero-data="heroData" />

    <!-- Mission & Vision -->
    <MissionVisionSection :mission-vision-data="missionVisionData" />

    <!-- Timeline -->
    <JourneySection :journey-data="journeyData" />

    <!-- Core Values -->
    <CoreValuesSection :core-values-data="coreValuesData" />

    <!-- Certifications -->
    <CertificationsSection :certifications="certifications" />

    <!-- CTA Section -->
    <ContactCtaSection :contact-cta="careerCtaData" />
  </div>
</template>
