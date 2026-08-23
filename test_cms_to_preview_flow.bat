@echo off
echo ============================================
echo CMS to Preview Data Flow Test
echo ============================================
echo.

echo [Step 1] Starting Laravel Server...
start cmd /k "cd D:\Herd\InfluxGroup-backend && php artisan serve"

echo [Step 2] Waiting for server to start...
timeout /t 3 /nobreak >nul

echo [Step 3] Opening CMS Admin for adding certifications...
start http://127.0.0.1:8000/admin/cms-section/home-page

echo [Step 4] Opening API endpoint for verification...
timeout /t 1 /nobreak >nul
start http://127.0.0.1:8000/api/cms/home-certifications

echo [Step 5] Opening preview page...
timeout /t 1 /nobreak >nul
start http://127.0.0.1:8000/preview/certifications

echo.
echo ============================================
echo Test Environment Ready!
echo ============================================
echo.
echo COMPLETE DATA FLOW TEST:
echo.
echo 1. [CMS] Go to the admin page that just opened
echo 2. [CMS] Click "Certifications" section in sidebar
echo 3. [CMS] Add 3-4 test certifications:
echo    - ISO 9001:2015 - Quality Management - 🏆
echo    - ISO 14001:2015 - Environmental Management - 🌱
echo    - CE Mark - European Conformity - 🇪🇺
echo 4. [CMS] Click "Save Certifications"
echo 5. [API] Check the API endpoint page - should show your data
echo 6. [PREVIEW] Check the preview page - should display certifications
echo 7. [VERIFY] Try adding more certifications in CMS
echo 8. [VERIFY] Refresh preview page - new data should appear
echo.
echo EXPECTED RESULTS:
echo ✅ CMS form saves without errors
echo ✅ API returns JSON with your certifications
echo ✅ Preview page displays certifications dynamically
echo ✅ Changes in CMS appear immediately on preview page
echo.
echo Press any key to stop testing...
pause >nul

echo.
echo To stop the server, close the Laravel Server window
pause