import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../pages/Home.vue'),
    meta: {
      title: 'Home | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('../pages/About.vue'),
    meta: {
      title: 'About Us | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/products',
    name: 'Products',
    component: () => import('../pages/Products.vue'),
    meta: {
      title: 'Products | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/products/category/:category',
    name: 'ProductCategory',
    component: () => import('../pages/ProductCategory.vue'),
    meta: {
      title: 'Product Category | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/products/:slug',
    name: 'ProductDetail',
    component: () => import('../pages/ProductDetail.vue'),
    meta: {
      title: 'Product Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/projects',
    name: 'Projects',
    component: () => import('../pages/Projects.vue'),
    meta: {
      title: 'Projects | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/projects/:slug',
    name: 'ProjectDetail',
    component: () => import('../pages/ProjectDetail.vue'),
    meta: {
      title: 'Project Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/services-and-solutions',
    name: 'ServicesAndSolutions',
    component: () => import('../pages/ServicesAndSolutions.vue'),
    meta: {
      title: 'Services & Solutions | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/services/:slug',
    name: 'ServiceDetail',
    component: () => import('../pages/ServiceAndSolutionDetail.vue'),
    meta: {
      title: 'Service Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/solutions/:slug',
    name: 'SolutionDetail',
    component: () => import('../pages/ServiceAndSolutionDetail.vue'),
    meta: {
      title: 'Solution Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/news',
    name: 'News',
    component: () => import('../pages/News.vue'),
    meta: {
      title: 'News | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/news/:slug',
    name: 'NewsDetail',
    component: () => import('../pages/NewsDetail.vue'),
    meta: {
      title: 'News Details | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('../pages/Contact.vue'),
    meta: {
      title: 'Contact | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/pages/:slug',
    name: 'Page',
    component: () => import('../pages/Page.vue'),
    meta: {
      title: 'Page | Influx Group',
      transition: 'fade'
    }
  },
  {
    path: '/gallery',
    name: 'Gallery',
    component: () => import('../pages/Gallery.vue'),
    meta: {
      title: 'Gallery | Influx Group',
      transition: 'scale'
    }
  },
  {
    path: '/career-opportunities',
    name: 'CareerOpportunities',
    component: () => import('../pages/CareerOpportunities.vue'),
    meta: {
      title: 'Career Opportunities | Influx Group',
      transition: 'slide'
    }
  },
  {
    path: '/preview',
    component: () => import('../pages/preview/Preview.vue'),
    meta: {
      title: 'CMS Preview | Influx Group',
      transition: 'fade',
      noLayout: true // Bypass MainLayout
    },
    children: [
      {
        path: '',
        name: 'PreviewIndex',
        redirect: { name: 'PreviewHeroSection' }
      },
      {
        path: 'hero-section',
        alias: ['hero', '/preview/home/hero', '/preview/home/hero-section'],
        name: 'PreviewHeroSection',
        component: () => import('../pages/preview/home/HeroSection.vue'),
        meta: {
          title: 'Hero Section Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'brand-statements',
        alias: ['brand-statement', '/preview/home/brand-statements', '/preview/home/brand-statement'],
        name: 'PreviewBrandStatements',
        component: () => import('../pages/preview/home/BrandStatements.vue'),
        meta: {
          title: 'Brand Statements Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'mission-vision',
        alias: ['mission-and-vision', '/preview/home/mission-vision', '/preview/home/mission-and-vision'],
        name: 'PreviewMissionVision',
        component: () => import('../pages/preview/home/MissionVision.vue'),
        meta: {
          title: 'Mission & Vision Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'core-values',
        alias: ['core-value', '/preview/home/core-values', '/preview/home/core-value'],
        name: 'PreviewCoreValues',
        component: () => import('../pages/preview/home/CoreValues.vue'),
        meta: {
          title: 'Core Values Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'partners',
        alias: ['partner', '/preview/home/partners', '/preview/home/partner'],
        name: 'PreviewPartners',
        component: () => import('../pages/preview/home/Partners.vue'),
        meta: {
          title: 'Partners Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'home-subscription-section',
        alias: ['subscription', 'subscription-section', '/preview/home/subscription', '/preview/home/subscription-section'],
        name: 'PreviewHomeSubscriptionSection',
        component: () => import('../pages/preview/home/HomeSubscriptionSection.vue'),
        meta: {
          title: 'Home Subscription Section Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'about',
        name: 'PreviewAboutIndex',
        redirect: { name: 'PreviewAboutHeroSection' }
      },
      {
        path: 'about-hero-section',
        alias: ['about-hero', '/preview/about/hero', '/preview/about/hero-section'],
        name: 'PreviewAboutHeroSection',
        component: () => import('../pages/preview/about/HeroSection.vue'),
        meta: {
          title: 'About Hero Section Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'about-mission-vision',
        alias: ['about-mission-vision', '/preview/about/mission-vision', '/preview/about/mission-vision-section'],
        name: 'PreviewAboutMissionVision',
        component: () => import('../pages/preview/about/MissionVision.vue'),
        meta: {
          title: 'About Mission & Vision Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'about-journey',
        alias: ['about-journey', '/preview/about/journey', '/preview/about/journey-section', '/preview/about/timeline'],
        name: 'PreviewAboutJourney',
        component: () => import('../pages/preview/about/Journey.vue'),
        meta: {
          title: 'About Journey Timeline Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'about-core-values',
        alias: ['about-core-values', '/preview/about/core-values', '/preview/about/core-values-section'],
        name: 'PreviewAboutCoreValues',
        component: () => import('../pages/preview/about/CoreValues.vue'),
        meta: {
          title: 'About Core Values Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'about-certifications',
        alias: ['about-certifications', '/preview/about/certifications', '/preview/about/certifications-section'],
        name: 'PreviewAboutCertifications',
        component: () => import('../pages/preview/about/Certifications.vue'),
        meta: {
          title: 'About Certifications Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'about-career-cta',
        alias: ['about-career-cta', '/preview/about/career-cta', '/preview/about/cta', '/preview/about/career-cta-section'],
        name: 'PreviewAboutCareerCta',
        component: () => import('../pages/preview/about/CareerCta.vue'),
        meta: {
          title: 'About Career CTA Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'contact',
        name: 'PreviewContactIndex',
        redirect: { name: 'PreviewContactHeroSection' }
      },
      {
        path: 'contact-hero-section',
        alias: ['contact-hero', '/preview/contact/hero-section', '/preview/contact/hero'],
        name: 'PreviewContactHeroSection',
        component: () => import('../pages/preview/contact/HeroSection.vue'),
        meta: {
          title: 'Contact Hero Section Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'contact-info',
        alias: ['contact-info', '/preview/contact/info', '/preview/contact/info-section'],
        name: 'PreviewContactInfo',
        component: () => import('../pages/preview/contact/ContactInfo.vue'),
        meta: {
          title: 'Contact Info Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'contact-form',
        alias: ['contact-form', '/preview/contact/form', '/preview/contact/form-section'],
        name: 'PreviewContactForm',
        component: () => import('../pages/preview/contact/ContactForm.vue'),
        meta: {
          title: 'Contact Form Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'contact-offices',
        alias: ['contact-offices', '/preview/contact/offices', '/preview/contact/offices-section'],
        name: 'PreviewContactOffices',
        component: () => import('../pages/preview/contact/OfficesSection.vue'),
        meta: {
          title: 'Contact Offices Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'contact-map',
        alias: ['contact-map', '/preview/contact/map', '/preview/contact/map-section'],
        name: 'PreviewContactMap',
        component: () => import('../pages/preview/contact/MapSection.vue'),
        meta: {
          title: 'Contact Map Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },
      {
        path: 'contact-emergency',
        alias: ['contact-emergency', '/preview/contact/emergency', '/preview/contact/emergency-section'],
        name: 'PreviewContactEmergency',
        component: () => import('../pages/preview/contact/EmergencySection.vue'),
        meta: {
          title: 'Contact Emergency Preview | Influx Group',
          transition: 'fade',
          noLayout: true // Bypass MainLayout
        }
      },

      // ── Products Preview ──────────────────────────────────────────────
      {
        path: 'products',
        name: 'PreviewProductsIndex',
        redirect: { name: 'PreviewProductsHeroSection' }
      },
      {
        path: 'products-hero-section',
        alias: ['products-hero', '/preview/products/hero-section', '/preview/products/hero'],
        name: 'PreviewProductsHeroSection',
        component: () => import('../pages/preview/products/HeroSection.vue'),
        meta: {
          title: 'Products Hero Section Preview | Influx Group',
          transition: 'fade',
          noLayout: true
        }
      },

      // ── Projects Preview ──────────────────────────────────────────────
      {
        path: 'projects',
        name: 'PreviewProjectsIndex',
        redirect: { name: 'PreviewProjectsHeroSection' }
      },
      {
        path: 'projects-hero-section',
        alias: ['projects-hero', '/preview/projects/hero-section', '/preview/projects/hero'],
        name: 'PreviewProjectsHeroSection',
        component: () => import('../pages/preview/projects/HeroSection.vue'),
        meta: {
          title: 'Projects Hero Section Preview | Influx Group',
          transition: 'fade',
          noLayout: true
        }
      },

      // ── Services & Solutions Preview ──────────────────────────────────
      {
        path: 'services',
        name: 'PreviewServicesIndex',
        redirect: { name: 'PreviewServicesHeroSection' }
      },
      {
        path: 'services-hero-section',
        alias: [
          'services-hero',
          '/preview/services/hero-section',
          '/preview/services/hero',
          '/preview/services-and-solutions/hero-section',
          '/preview/services-and-solutions/hero'
        ],
        name: 'PreviewServicesHeroSection',
        component: () => import('../pages/preview/services/HeroSection.vue'),
        meta: {
          title: 'Services & Solutions Hero Section Preview | Influx Group',
          transition: 'fade',
          noLayout: true
        }
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0, behavior: 'smooth' }
    }
  }
})

// Update page title
router.beforeEach((to, from, next) => {
  let title = to.meta.title || 'Influx Group'

  // Dynamic title for product category
  if (to.name === 'ProductCategory' && to.params.category) {
    const categoryName = to.params.category
      .split('-')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join(' ')
    title = `${categoryName} | Influx Group`
  }

  document.title = title
  next()
})

export default router
