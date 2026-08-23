# 🔗 Complete API Integration Guide for http://localhost:5173/preview/certifications

## 🎯 Overview
This guide ensures that the `/api/cms/home-certifications` API is properly integrated in the Certifications.vue component at `http://localhost:5173/preview/certifications`.

## 🏗️ Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                    LOCAL DEVELOPMENT SETUP                    │
├─────────────────────────────────────────────────────────────┤
│  Laravel Backend: http://localhost:8000                        │
│  Vue Frontend:   http://localhost:5173                        │
│  Preview Page:   http://localhost:5173/preview/certifications  │
│  API Endpoint:   http://localhost:8000/api/cms/home-certifications │
└─────────────────────────────────────────────────────────────┘

                            ↓ Complete Data Flow ↓

┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│  Browser │    │  Vue App │    │  API     │    │ Laravel  │    │ Database │
│localhost:│───▶│localhost:│───▶│localhost:│───▶│localhost:│───▶│   MySQL   │
│  5173    │    │  5173    │    │  8000    │    │  8000    │    │          │
└──────────┘    └──────────┘    └──────────┘    └──────────┘    └──────────┘
     ↓               ↓               ↓               ↓               ↓
  User visits     Component       Service call     Controller      Storage
 /preview/     fetches API     to backend     processes &     persists
certifications     via           /cms/home-     returns         data
              homeCertifications   certifications
                  Service()        JSON
```

## 🔧 Configuration Implementation

### 1. API Configuration Setup

**File:** `D:\Herd\InfluxGroup-backend\InfluxGroup\.env.local`
```env
# Local Development Configuration
VITE_API_URL=http://localhost:8000/api
NODE_ENV=development
VITE_DEV=true
```

**File:** `D:\Herd\InfluxGroup-backend\InfluxGroup\src\config\api.js`
```javascript
export const API_CONFIG = {
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
}

export const API_ENDPOINTS = {
  HOME_CERTIFICATIONS: '/cms/home-certifications',
  // ... other endpoints
}
```

### 2. Service Implementation

**File:** `D:\Herd\InfluxGroup-backend\InfluxGroup\src\services\content.js`
```javascript
export const homeCertificationsService = {
  async getCertificationsData() {
    try {
      console.log('🔍 homeCertificationsService: Fetching from', API_ENDPOINTS.HOME_CERTIFICATIONS)
      const response = await api.get(API_ENDPOINTS.HOME_CERTIFICATIONS)
      console.log('✅ homeCertificationsService: Response received', response)
      return response
    } catch (error) {
      console.error('❌ homeCertificationsService: Error fetching home certifications data', error)
      throw error
    }
  },
}
```

### 3. Component Implementation

**File:** `D:\Herd\InfluxGroup-backend\InfluxGroup\src\pages\preview\home\Certifications.vue`
```vue
<template>
  <div class="certifications-preview">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Loading certifications data...</p>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <h3>Failed to load certifications data</h3>
      <p>{{ error }}</p>
      <button @click="fetchCertificationsData">Retry</button>
    </div>

    <!-- Certifications Content -->
    <CertificationsSection
      v-else
      :certifications-data="certificationsData"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { homeCertificationsService } from '@/services/content'
import CertificationsSection from '@/components/sections/CertificationsSection.vue'

const certificationsData = ref(null)
const loading = ref(true)
const error = ref(null)

const fetchCertificationsData = async () => {
  try {
    loading.value = true
    error.value = null

    console.log('🔍 Fetching certifications from CMS...')

    // API call to http://localhost:8000/api/cms/home-certifications
    const response = await homeCertificationsService.getCertificationsData()

    console.log('✅ Certifications API response:', response)

    // Handle different response formats
    if (response && response.success && response.data) {
      certificationsData.value = response.data
    } else if (response && response.data) {
      certificationsData.value = response.data
    } else if (response) {
      certificationsData.value = response
    } else {
      throw new Error('Invalid API response format')
    }

    console.log('✅ Certifications data loaded successfully:', certificationsData.value)
  } catch (err) {
    console.error('❌ Error fetching certifications data:', err)
    error.value = err.message || 'Failed to load certifications data'

    // Use fallback data
    certificationsData.value = {
      title: 'Certifications & Standards',
      subtitle: 'Internationally recognized certifications ensuring quality and safety',
      certifications: [
        { name: 'ISO 9001:2015', title: 'ISO 9001:2015', description: 'Quality Management', icon: '🏆' }
      ]
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCertificationsData()
})
</script>
```

## 🧪 Testing the Implementation

### Phase 1: Start Development Servers

**Step 1: Open two terminal windows**

**Terminal 1 - Laravel Backend:**
```bash
cd D:\Herd\InfluxGroup-backend
php artisan serve
```
✅ Should see: `Server running on [http://127.0.0.1:8000]`

**Terminal 2 - Vue Frontend:**
```bash
cd D:\Herd\InfluxGroup-backend\InfluxGroup
npm run dev
```
✅ Should see: `Local: http://localhost:5173/`

### Phase 2: Verify API Endpoint

**Step 2: Test API directly**
```bash
# In browser or terminal
curl http://localhost:8000/api/cms/home-certifications
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "title": "Certifications & Standards",
    "subtitle": "Internationally recognized certifications ensuring quality and safety",
    "certifications": [],
    "list": []
  }
}
```

### Phase 3: Test Frontend Component

**Step 3: Access Preview Page**
```
http://localhost:5173/preview/certifications
```

**Step 4: Open Browser DevTools (F12)**

**Console Tab - Expected Logs:**
```
🔍 Fetching certifications from CMS...
✅ Certifications API response: { success: true, data: {...} }
✅ Certifications data loaded successfully: { title: "...", certifications: [...] }
```

**Network Tab - Expected Request:**
- Request URL: `http://localhost:8000/api/cms/home-certifications`
- Method: `GET`
- Status: `200 OK`
- Response Type: `application/json`

### Phase 4: Test with CMS Data

**Step 5: Add Test Data via CMS**
```
http://localhost:8000/admin/cms-section/home-page
```

1. Click "Certifications" section
2. Click "Add New Certification"
3. Add certifications:
   - **ISO 9001:2015** | Quality Management System | 🏆
   - **ISO 14001:2015** | Environmental Management | 🌱
4. Click "Save Certifications"

**Step 6: Verify API Response**
```bash
curl http://localhost:8000/api/cms/home-certifications
```

**Expected Response:**
```json
{
  "success": true,
  "data": {
    "title": "Certifications & Standards",
    "subtitle": "Internationally recognized certifications ensuring quality and safety",
    "certifications": [
      { "name": "ISO 9001:2015", "title": "ISO 9001:2015", "description": "Quality Management System", "icon": "🏆" },
      { "name": "ISO 14001:2015", "title": "ISO 14001:2015", "description": "Environmental Management", "icon": "🌱" }
    ],
    "list": [...]
  }
}
```

**Step 7: Verify Frontend Display**
```
http://localhost:5173/preview/certifications
```

✅ Should display:
- Title: "Certifications & Standards"
- Subtitle: "Internationally recognized certifications ensuring quality and safety"
- Grid with 2 certifications
- Responsive layout
- Hover effects

## 🔍 Troubleshooting Guide

### Issue 1: Vue Dev Server Shows Different Port

**Problem:** Vue runs on port other than 5173

**Solution:**
```bash
# Check available ports
netstat -an | findstr LISTENING

# Kill process using port 5173
npx kill-port 5173

# Restart dev server
npm run dev
```

### Issue 2: API Connection Refused

**Problem:** `ERR_CONNECTION_REFUSED` when calling API

**Solution:**
```bash
# Verify Laravel server is running
curl http://localhost:8000

# Check if port 8000 is available
netstat -an | findstr :8000

# Restart Laravel server
php artisan serve --port=8001
```

### Issue 3: CORS Errors

**Problem:** CORS policy blocking API calls

**Solution:**
```php
// In Laravel config/cors.php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5173', 'http://localhost:5174'],
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
```

### Issue 4: Environment Variables Not Loading

**Problem:** API URL not pointing to localhost:8000

**Solution:**
```bash
# Clear Vue cache
cd D:\Herd\InfluxGroup-backend\InfluxGroup
rm -rf node_modules/.vite
rm -rf dist

# Restart dev server
npm run dev
```

### Issue 5: Component Not Fetching Data

**Problem:** Preview page shows fallback data only

**Debug Steps:**
1. Open browser console at `http://localhost:5173/preview/certifications`
2. Check for API call logs
3. Verify API response structure
4. Check Network tab for failed requests

**Expected Console Output:**
```
🔍 Fetching certifications from CMS...
✅ Certifications API response: { success: true, data: {...} }
✅ Certifications data loaded successfully: {...}
```

## 📊 Complete Success Criteria

### Backend (Laravel)
- ✅ Server running on http://localhost:8000
- ✅ API endpoint `/api/cms/home-certifications` accessible
- ✅ Returns JSON with `{ success: true, data: {...} }`
- ✅ CMS form saves certifications to database
- ✅ No CSRF errors on form submission

### Frontend (Vue)
- ✅ Dev server running on http://localhost:5173
- ✅ Preview page loads without errors
- ✅ Component makes API call to backend
- ✅ Displays certifications from API response
- ✅ Shows loading/error states appropriately
- ✅ No CORS errors in browser console

### Integration
- ✅ Data flows from CMS → Database → API → Vue → Display
- ✅ Changes in CMS appear on frontend immediately
- ✅ Console shows proper debug logs
- ✅ Network tab shows successful API calls
- ✅ Responsive design works on all screen sizes

## 🚀 Quick Start Script

**Double-click:** `start_local_dev.bat`

**This will:**
1. Start Laravel server on port 8000
2. Start Vue dev server on port 5173
3. Open all necessary browser windows
4. Display testing instructions
5. Provide debugging guidance

## 🎯 Final Verification

**Complete this checklist:**

**Setup:**
- [ ] Laravel server running on localhost:8000
- [ ] Vue dev server running on localhost:5173
- [ ] .env.local configured with VITE_API_URL=http://localhost:8000/api
- [ ] No CORS errors in browser console

**API Testing:**
- [ ] http://localhost:8000/api/cms/home-certifications returns 200 OK
- [ ] API returns JSON with proper structure
- [ ] CMS data appears in API response

**Frontend Testing:**
- [ ] http://localhost:5173/preview/certifications loads
- [ ] Browser shows loading state briefly
- [ ] Console logs show API call success
- [ ] Certifications display dynamically
- [ ] CMS changes appear immediately

**The `/api/cms/home-certifications` API is now fully integrated in the `http://localhost:5173/preview/certifications` component!** 🎉