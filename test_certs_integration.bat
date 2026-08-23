@echo off
echo ============================================
echo Testing Certifications CMS to Preview Integration
echo ============================================
echo.

echo [Step 1] Starting Laravel Server...
start cmd /k "cd D:\Herd\InfluxGroup-backend && php artisan serve"

echo [Step 2] Waiting for server to start...
timeout /t 3 /nobreak >nul

echo [Step 3] Opening CMS for adding certifications...
start http://127.0.0.1:8000/admin/cms-section/home-page

echo [Step 4] Opening API endpoint to verify backend...
timeout /t 1 /nobreak >nul
start http://127.0.0.1:8000/api/cms/home-certifications

echo [Step 5] Opening preview page to verify frontend...
timeout /t 1 /nobreak >nul
start http://127.0.0.1:8000/preview/certifications

echo.
echo ============================================
echo Test Instructions
echo ============================================
echo.
echo PART 1: ADD CERTIFICATIONS IN CMS
echo ============================================
echo.
echo 1. In the CMS page that opened, click "Certifications" section
echo 2. Add 3-4 test certifications:
echo    - Click "Add New Certification"
echo    - Fill in: Name, Description, Icon
echo    - Examples:
echo      * ISO 9001:2015 | Quality Management | 🏆
echo      * ISO 14001:2015 | Environmental Management | 🌱
echo      * CE Mark | European Conformity | 🇪🇺
echo.
echo PART 2: VERIFY API RESPONSE
echo ============================================
echo.
echo 1. Check the API endpoint page that opened
echo 2. You should see JSON response structure:
echo    {
echo      "success": true,
echo      "data": {
echo        "title": "...",
echo        "subtitle": "...",
echo        "certifications": [...],
echo        "list": [...]
echo      }
echo    }
echo.
echo PART 3: VERIFY PREVIEW PAGE
echo ============================================
echo.
echo 1. Check the preview page that opened
echo 2. You should see:
echo    - Your certifications displayed in a grid
echo    - Section title and subtitle from CMS
echo    - Responsive layout (6 columns on desktop)
echo    - Hover effects on certification boxes
echo.
echo PART 4: TEST DYNAMIC UPDATES
echo ============================================
echo.
echo 1. Go back to CMS and add more certifications
echo 2. Click "Save Certifications"
echo 3. Refresh the preview page
echo 4. New certifications should appear immediately
echo.
echo EXPECTED RESULTS:
echo ✅ CMS form saves without errors
echo ✅ API returns proper JSON with certifications
echo ✅ Preview page displays certifications dynamically
echo ✅ Changes in CMS appear on preview page immediately
echo.
echo Press any key to continue to verification...
pause >nul

echo.
echo ============================================
echo VERIFICATION CHECKLIST
echo ============================================
echo.
echo Please verify each component:
echo.
echo [ ] CMS: Certifications section accessible
echo [ ] CMS: Add/delete functionality works
echo [ ] CMS: Save completes without CSRF errors
echo [ ] API: Returns 200 OK status
echo [ ] API: JSON structure is correct
echo [ ] API: Contains certifications array
echo [ ] Preview: Page loads without errors
echo [ ] Preview: Shows CMS data dynamically
echo [ ] Preview: Layout displays correctly
echo [ ] Preview: Responsive design works
echo.
echo If all items checked, the integration is working perfectly!
echo.
echo Press any key to stop testing...
pause >nul

echo.
echo To stop the server, close the Laravel Server window
pause