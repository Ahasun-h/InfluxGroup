<template>
  <div class="contact-form-preview">
    <section class="py-20 bg-white">
      <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl font-display text-industrial-dark uppercase italic mb-8">
          Send Us a <span class="text-industrial-blue">Message</span>
        </h2>

        <form @submit.prevent="submitForm" class="space-y-6">
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-black uppercase tracking-wider text-gray-900 mb-2">Full Name *</label>
              <input
                v-model="contactForm.name"
                type="text"
                required
                class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors text-black placeholder:text-gray-400"
                placeholder="John Doe"
              />
            </div>
            <div>
              <label class="block text-xs font-black uppercase tracking-wider text-gray-900 mb-2">Email Address *</label>
              <input
                v-model="contactForm.email"
                type="email"
                required
                class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors text-black placeholder:text-gray-400"
                placeholder="john@example.com"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-black uppercase tracking-wider text-gray-900 mb-2">Phone Number</label>
            <input
              v-model="contactForm.phone"
              type="tel"
              class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors text-black"
              placeholder="+880 1XXX-XXXXXX"
            />
          </div>

          <div>
            <label class="block text-xs font-black uppercase tracking-wider text-gray-900 mb-2">Subject *</label>
            <select
              v-model="contactForm.subject"
              required
              class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors bg-white text-black"
            >
              <option value="">Select a subject</option>
              <option value="general">General Inquiry</option>
              <option value="projects">Project Inquiry</option>
              <option value="products">Product Information</option>
              <option value="support">Technical Support</option>
              <option value="careers">Career Opportunities</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-black uppercase tracking-wider text-gray-900 mb-2">Message *</label>
            <textarea
              v-model="contactForm.message"
              required
              rows="6"
              class="w-full px-4 py-3 border-2 border-slate-200 rounded-sm focus:outline-none focus:border-industrial-blue transition-colors resize-none text-black"
              placeholder="Tell us about your project or inquiry..."
            ></textarea>
          </div>

          <!-- Success Message -->
          <div v-if="formStatus.success" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-sm mb-4">
            {{ formStatus.success }}
          </div>

          <!-- Error Message -->
          <div v-if="formStatus.error" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-sm mb-4">
            {{ formStatus.error }}
          </div>

          <button
            type="submit"
            :disabled="formStatus.submitting"
            class="w-full bg-industrial-blue hover:bg-industrial-red text-white py-4 rounded-sm font-black uppercase tracking-widest text-xs transition-colors flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="formStatus.submitting">Sending...</span>
            <span v-else>Send Message <Send class="w-4 h-4" /></span>
          </button>
        </form>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Send } from 'lucide-vue-next'
import { api } from '@/services/api'

const contactForm = ref({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: ''
})

const formStatus = ref({
  submitting: false,
  submitted: false,
  error: null,
  success: null
})

const submitForm = async () => {
  formStatus.value.submitting = true
  formStatus.value.error = null
  formStatus.value.success = null

  try {
    const response = await api.post('/contact/submit', contactForm.value)
    if (response && response.success) {
      formStatus.value.success = 'Thank you for your message! We will get back to you soon.'
      formStatus.value.submitted = true
      contactForm.value = { name: '', email: '', phone: '', subject: '', message: '' }
      setTimeout(() => {
        formStatus.value.success = null
        formStatus.value.submitted = false
      }, 5000)
    } else {
      formStatus.value.error = response?.message || 'Failed to submit form.'
    }
  } catch (err) {
    console.error('Error submitting form:', err)
    formStatus.value.error = 'Failed to submit form. Please try again.'
  } finally {
    formStatus.value.submitting = false
  }
}
</script>

<style scoped>
.contact-form-preview {
  min-height: 100vh;
  background: white;
}
</style>
