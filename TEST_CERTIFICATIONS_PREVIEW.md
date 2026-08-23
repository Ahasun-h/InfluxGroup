# 🧪 Testing Guide: /preview/certifications Page

## 🎯 Testing Overview

This guide will help you test the `/preview/certifications` preview page to ensure it works correctly with API data integration.

## 📋 Pre-test Requirements

### Backend Setup
- ✅ Laravel server running on port 8000
- ✅ Database migrations completed
- ✅ CMS accessible at `/admin/cms-section/home-page`
- ✅ API endpoint `/api/cms/home-certifications` working

### Frontend Setup
- ✅ Vue.js development server running (if needed)
- ✅ Router configuration updated
- ✅ Components properly imported

## 🧪 Step-by-Step Testing

### Test 1: Route Accessibility

**Objective:** Verify the preview page route is accessible

**Steps:**
1. Open browser
2. Navigate to: `http://your-domain/preview/certifications`
3. Check for page load

**Expected Results:**
- ✅ Page loads without 404 error
- ✅ No console errors
- ✅ Vue router accepts the route
- ✅ Component renders successfully

**Alternative Routes to Test:**
- `/preview/certifications-section`
- `certifications` (when in preview context)

---

### Test 2: Initial Page Load (Empty State)

**Objective:** Test page behavior when no certifications exist

**Steps:**
1. Ensure no certifications in database
2. Navigate to: `/preview/certifications`
3. Observe loading state briefly
4. Check final rendered content

**Expected Results:**
- ✅ Loading spinner shows briefly (1-2 seconds)
- ✅ Page renders with default/fallback certifications
- ✅ Default certifications display:
  - "ISO 9001:2015"
  - "ISO 14001:2015"
  - "ISO 45001:2018"
  - "IEC 60076"
  - "IEEE Standards"
  - "BPDB Approved"
- ✅ Section title: "Certifications & Standards"
- ✅ Section subtitle displays properly
- ✅ Grid layout: 2 columns mobile, 3 tablet, 6 desktop

**Visual Checklist:**
- [ ] White background
- [ ] Centered title with blue highlight
- [ ] Subtitle below title
- [ ] Grid of certification boxes
- [ ] Each box: light background, centered text
- [ ] Hover effects work (blue background, white text)

---

### Test 3: API Data Integration

**Objective:** Test dynamic data fetching from API

**Steps:**
1. Open browser DevTools (F12)
2. Go to Network tab
3. Navigate to: `/preview/certifications`
4. Find request to `/api/cms/home-certifications`
5. Check response structure

**Expected API Response:**
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

**API Call Verification:**
- [ ] Request method: GET
- [ ] Request URL: `/api/cms/home-certifications`
- [ ] Response status: 200 OK
- [ ] Response type: application/json
- [ ] Response contains required fields

---

### Test 4: CMS Data Integration

**Objective:** Test that CMS data appears on preview page

**Steps:**
1. Navigate to CMS: `/admin/cms-section/home-page`
2. Click "Certifications" section
3. Add test certifications:
   - Name: "ISO 9001:2015", Description: "Quality Management", Icon: "🏆"
   - Name: "ISO 14001:2015", Description: "Environmental Management", Icon: "🌱"
   - Name: "CE Mark", Description: "European Conformity", Icon: "🇪🇺"
4. Click "Save Certifications"
5. Navigate to: `/preview/certifications`
6. Refresh page if needed

**Expected Results:**
- ✅ New certifications appear on page
- ✅ Certification names display correctly
- ✅ Grid layout updates (3 items in grid)
- ✅ Styling remains consistent
- ✅ Hover effects work

**Data Verification:**
- [ ] "ISO 9001:2015" appears
- [ ] "ISO 14001:2015" appears
- [ ] "CE Mark" appears
- [ ] Grid shows 3 certification boxes
- [ ] Responsive layout maintained

---

### Test 5: Error Handling

**Objective:** Test error handling when API fails

**Steps:**
1. Stop Laravel server
2. Navigate to: `/preview/certifications`
3. Observe error state

**Expected Results:**
- ✅ Error message displays
- ✅ "Failed to load certifications data" message
- ✅ Retry button appears
- ✅ Fallback certifications still display
- ✅ Page doesn't crash

**Error State Visuals:**
- [ ] Error icon displays (red warning)
- [ ] Error message readable
- [ ] Retry button functional
- [ ] Fallback data visible below error
- [ ] Background styling maintained

**Recovery Test:**
1. Start Laravel server again
2. Click "Retry" button
3. ✅ Data loads successfully
4. ✅ Error state disappears
5. ✅ Certifications display properly

---

### Test 6: Responsive Design

**Objective:** Test responsive behavior across screen sizes

**Steps:**
1. Open `/preview/certifications` in browser
2. Open DevTools (F12)
3. Toggle device toolbar (Ctrl+Shift+M)
4. Test different screen sizes

**Screen Sizes to Test:**

**Mobile (320px - 768px):**
- [ ] 2 column grid
- [ ] Title readable size
- [ ] Certifications stack properly
- [ ] No horizontal scrolling
- [ ] Touch targets adequate size

**Tablet (768px - 1024px):**
- [ ] 3 column grid
- [ ] Proper spacing between items
- [ ] Title centered properly
- [ ] Subtitle width appropriate

**Desktop (1024px+):**
- [ ] 6 column grid
- [ ] Maximum 6 certifications per row
- [ ] Hover effects work with mouse
- [ ] Animations smooth

---

### Test 7: Component Interactions

**Objective:** Test user interactions with certifications

**Steps:**
1. Navigate to: `/preview/certifications`
2. Test hover effects on certification boxes
3. Test animations on page load

**Expected Results:**
- ✅ Hover: Background changes to industrial blue
- ✅ Hover: Text changes to white
- ✅ Hover: Smooth transition animation
- ✅ Page load: Items animate in sequence
- ✅ Each item has slight delay (100ms increments)

**Animation Tests:**
- [ ] Items slide up on page load
- [ ] Animation timing feels natural
- [ ] No animation jank or stuttering
- [ ] Hover transitions smooth

---

### Test 8: Title Processing

**Objective:** Test title splitting functionality

**Steps:**
1. Go to CMS certifications section
2. Change title to: "Quality & Safety Standards"
3. Save and refresh preview page
4. Check title rendering

**Expected Results:**
- ✅ "Quality &" appears in normal color
- ✅ "Safety Standards" appears in blue (highlighted)
- ✅ Ampersand (&) splitting works correctly
- ✅ Title styling maintained

**Alternative Title Tests:**
- "Certifications & Compliance" → "&" split works
- "Training Programs" → space splitting works
- "ISO Standards" → single word displays properly

---

## 🔍 Debugging Tools

### Browser Console Commands

**Check Vue Component:**
```javascript
// In browser console
$vm.$root.$route.name  // Should show 'Certifications'
$vm.$root.$route.path  // Should show '/preview/certifications'
```

**Check API Response:**
```javascript
// Test API directly in console
fetch('/api/cms/home-certifications')
  .then(r => r.json())
  .then(data => console.log(data))
```

**Test Component Props:**
```javascript
// Access component data
$vm.certificationsData
$vm.loading
$vm.error
```

### Laravel Artisan Commands

**Test API Endpoint:**
```bash
php artisan tinker
>>> $response = (new App\Http\Controllers\Api\ContentController())->getHomeCertifications();
>>> echo $response->getContent();
```

**Check Database:**
```bash
php artisan tinker
>>> App\Models\ContentManagement::where('section_name', 'certifications')
>>>    ->where('page_name', 'home_page')
>>>    ->get();
```

---

## 🐛 Common Issues & Solutions

### Issue 1: Route Not Found
**Symptoms:** 404 error when accessing `/preview/certifications`

**Solutions:**
```bash
# Clear Vue cache
rm -rf node_modules/.vite
npm install

# Rebuild frontend
npm run dev

# Check router configuration
# Verify route exists in src/router/index.js lines 185-193
```

### Issue 2: API Connection Refused
**Symptoms:** Network error, API call fails

**Solutions:**
```bash
# Ensure Laravel server is running
php artisan serve

# Check if port 8000 is available
netstat -an | findstr :8000

# Verify API endpoint exists
php artisan route:list | grep home-certifications
```

### Issue 3: Component Not Rendering
**Symptoms:** Blank page or component not visible

**Solutions:**
```javascript
// Check browser console for Vue errors
// Verify component imports in Certifications.vue
// Check CertificationsSection component exists
// Verify props are being passed correctly
```

### Issue 4: Styling Issues
**Symptoms:** Wrong colors, layout broken

**Solutions:**
- Check if CSS is loading
- Verify Tailwind CSS is configured
- Check for conflicting styles
- Test in different browsers

---

## ✅ Test Completion Checklist

### Basic Functionality
- [ ] Route accessible at `/preview/certifications`
- [ ] Page loads without errors
- [ ] Loading state displays
- [ ] Certifications render on page
- [ ] Section title displays correctly
- [ ] Section subtitle displays correctly

### API Integration
- [ ] API call succeeds (200 OK)
- [ ] JSON response structure correct
- [ ] Data properly parsed
- [ ] Component receives props correctly
- [ ] Error handling works

### CMS Integration
- [ ] CMS changes appear on preview
- [ ] Save functionality works
- [ ] Data persists after refresh
- [ ] Multiple certifications display

### User Experience
- [ ] Responsive design works
- [ ] Hover effects functional
- [ ] Animations smooth
- [ ] No console errors
- [ ] Page loads in reasonable time

### Error Handling
- [ ] API failure handled gracefully
- [ ] Retry button works
- [ ] Fallback data displays
- [ ] Error messages clear

---

## 🚀 Quick Test Script

**Minimal Test (30 seconds):**
1. Navigate to `/preview/certifications`
2. ✅ Page loads
3. ✅ See certifications displayed
4. ✅ Hover over certification (background changes)
5. ✅ Check mobile view (responsive)

**Comprehensive Test (5 minutes):**
1. Run all 8 tests above
2. Test with CMS data
3. Test error scenarios
4. Test responsive design
5. Verify all functionality

---

## 📊 Success Criteria

**For Preview Page to Pass:**
- ✅ Accessible at `/preview/certifications`
- ✅ Fetches data from API successfully
- ✅ Displays certifications in grid layout
- ✅ Shows loading and error states appropriately
- ✅ Updates when CMS data changes
- ✅ Responsive across all screen sizes
- ✅ All user interactions work smoothly

## 🎯 Next Steps After Testing

Once testing is complete:
1. Document any bugs found
2. Fix any issues discovered
3. Test with real user scenarios
4. Deploy to staging environment
5. Get user feedback