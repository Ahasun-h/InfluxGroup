# Certifications Section Testing Guide

## ✅ Pre-flight Checks (Backend)

### 1. Route Verification
```bash
# Test if the route is registered
php artisan route:list | grep home-certifications
```
**Expected:** Should show `GET|HEAD  api/cms/home-certifications`

### 2. Controller Method Check
```bash
# Verify the controller method exists
grep -n "getHomeCertifications" app/Http/Controllers/Api/ContentController.php
```
**Expected:** Should find the method around line 827

### 3. CMS Controller Integration
```bash
# Verify certifications handling in CMS
grep -n "certifications.*=>.*loadCertifications" app/Http/Controllers/Admin/HomePageController.php
```
**Expected:** Should find the integration around line 41

## 🧪 Testing Steps

### Phase 1: API Endpoint Testing

#### Test 1.1: Raw API Call
```bash
# Test the API endpoint directly
curl -X GET http://your-domain/api/cms/home-certifications
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

#### Test 1.2: Browser Test
1. Open browser
2. Navigate to: `http://your-domain/api/cms/home-certifications`
3. Check for proper JSON response

### Phase 2: CMS Form Testing

#### Test 2.1: Access CMS Section
1. Navigate to: `/admin/cms-section/home-page`
2. Look for "Certifications" in the sidebar
3. **Expected:** Should see the Certifications navigation item

#### Test 2.2: Form Structure
1. Click on "Certifications" section
2. **Expected:**
   - Section Title input field
   - Section Subtitle textarea
   - Certifications counter showing "0/12"
   - "Add New Certification" button
   - Empty state message

#### Test 2.3: Add First Certification
1. Click "Add New Certification"
2. Fill in the fields:
   - Name: "ISO 9001:2015"
   - Description: "Quality Management System"
   - Icon: "🏆"
3. **Expected:**
   - Counter updates to "1/12"
   - Form appears with delete button
   - Add button still shows "11 slots remaining"

#### Test 2.4: Add Multiple Certifications
1. Add 2-3 more certifications:
   - "ISO 14001:2015" - "Environmental Management"
   - "ISO 45001:2018" - "Occupational Health & Safety"
2. **Expected:**
   - Counter updates correctly (2/12, 3/12, etc.)
   - All certifications display properly
   - Sequential IDs assigned correctly

#### Test 2.5: Delete Certification
1. Click delete (X) button on a certification
2. **Expected:**
   - Certification removed from DOM
   - Counter decreases
   - Remaining certifications stay intact

#### Test 2.6: Save Certifications
1. Fill in section details:
   - Title: "Professional Certifications"
   - Subtitle: "Internationally recognized standards"
2. Add 2-3 certifications
3. Click "Save Certifications"
4. **Expected:**
   - Success message appears
   - No CSRF errors
   - Data persists after page refresh

### Phase 3: Database Verification

#### Test 3.1: Check Database Storage
```sql
-- Check if certifications data is stored
SELECT section_name, section_item_name, section_content
FROM content_management
WHERE section_name = 'certifications'
AND page_name = 'home_page'
ORDER BY section_item_name;
```

**Expected Results:**
- `certifications_title` - contains section title
- `certifications_subtitle` - contains subtitle
- `certification_1`, `certification_2`, etc. - contain JSON data

#### Test 3.2: Verify JSON Structure
```sql
-- Check the JSON structure of a certification
SELECT section_item_name, section_content
FROM content_management
WHERE section_item_name = 'certification_1'
AND section_name = 'certifications';
```

**Expected JSON:**
```json
{
  "id": 1,
  "order": 1,
  "name": "ISO 9001:2015",
  "title": "ISO 9001:2015",
  "description": "Quality Management System",
  "icon": "🏆"
}
```

### Phase 4: Frontend Display Testing

#### Test 4.1: Homepage Display
1. Navigate to homepage: `/`
2. **Expected:**
   - Certifications section displays with title/subtitle
   - All certifications show in grid layout
   - Styling matches other sections
   - Responsive design works

#### Test 4.2: Preview Page
1. Navigate to: `/preview/home/certifications`
2. **Expected:**
   - Page loads successfully
   - Shows loading state briefly
   - Displays certifications dynamically
   - Proper error handling if API fails

#### Test 4.3: API Response Usage
1. Open browser DevTools → Network tab
2. Load homepage
3. **Expected:**
   - Request to `/api/cms/home-certifications`
   - Proper JSON response
   - Data used in frontend display

### Phase 5: Edge Cases & Error Handling

#### Test 5.1: Maximum Limit
1. Try to add more than 12 certifications
2. **Expected:**
   - Alert message shown
   - Add button disabled after 12
   - Counter shows "12/12"

#### Test 5.2: Empty Fields
1. Add certification with only name filled
2. **Expected:**
   - Saves successfully
   - Missing fields handled gracefully

#### Test 5.3: API Failure
1. Temporarily break the API endpoint
2. **Expected:**
   - Frontend shows fallback data
   - Error message displayed
   - Page doesn't crash

## 🔍 Debugging Commands

### Check Route Registration
```bash
php artisan route:list --path=home-certifications
```

### Test Controller Directly
```bash
php artisan tinker
>>> $controller = new App\Http\Controllers\Api\ContentController();
>>> $controller->getHomeCertifications();
```

### Check Database
```bash
php artisan tinker
>>> App\Models\ContentManagement::where('section_name', 'certifications')->get();
```

### Clear Cache
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
```

## 📋 Success Criteria

✅ **Backend:**
- [ ] Route registered and accessible
- [ ] Controller method works correctly
- [ ] CMS integration functional
- [ ] Database storage proper

✅ **CMS Form:**
- [ ] Section accessible in sidebar
- [ ] Add/delete functions work
- [ ] Save functionality successful
- [ ] Counter updates correctly
- [ ] Maximum limit enforced

✅ **Frontend:**
- [ ] API endpoint returns proper data
- [ ] Homepage displays certifications
- [ ] Preview page works
- [ ] Responsive design maintained
- [ ] Error handling works

## 🐛 Common Issues & Solutions

### Issue 1: Route Not Found
**Solution:** Run `php artisan route:clear` and check route syntax

### Issue 2: CSRF Token Error
**Solution:** Ensure `@csrf` directive is in form and CSRF token is sent in headers

### Issue 3: Controller Method Not Found
**Solution:** Check method name spelling and ensure controller is imported

### Issue 4: Empty API Response
**Solution:** Verify database has certifications data, check controller logic

### Issue 5: Frontend Not Updating
**Solution:** Clear browser cache, check API response in Network tab

## 🚀 Next Steps After Testing

Once all tests pass:
1. Deploy to staging environment
2. Test with real user scenarios
3. Monitor for any issues
4. Document any additional features needed
5. Plan for production deployment