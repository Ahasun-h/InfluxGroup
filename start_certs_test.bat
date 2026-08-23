@echo off
echo ============================================
echo Certifications Integration Test
echo ============================================
echo.
echo Starting Laravel server and opening test pages...
echo.

echo Step 1: Starting Laravel server...
start cmd /k "cd D:\Herd\InfluxGroup-backend && php artisan serve"

echo Step 2: Waiting for server to start...
timeout /t 5 /nobreak >nul

echo Step 3: Opening CMS admin page...
start http://127.0.0.1:8000/admin/cms-section/home-page

timeout /t 1 /nobreak >nul

echo Step 4: Opening API endpoint...
start http://127.0.0.1:8000/api/cms/home-certifications

timeout /t 1 /nobreak >nul

echo Step 5: Opening preview page...
start http://127.0.0.1:8000/preview/certifications

echo.
echo ============================================
echo Test Environment Ready!
echo ============================================
echo.
echo OPENED PAGES:
echo   1. CMS Admin: http://127.0.0.1:8000/admin/cms-section/home-page
echo   2. API Endpoint: http://127.0.0.1:8000/api/cms/home-certifications
echo   3. Preview Page: http://127.0.0.1:8000/preview/certifications
echo.
echo TESTING INSTRUCTIONS:
echo   1. In CMS page, click "Certifications" section
echo   2. Click "Add New Certification" button
echo   3. Add 3-4 test certifications:
echo      - ISO 9001:2015 | Quality Management | 🏆
echo      - ISO 14001:2015 | Environmental Management | 🌱
echo      - CE Mark | European Conformity | 🇪🇺
echo   4. Click "Save Certifications"
echo   5. Check API page - should show your data as JSON
echo   6. Check Preview page - should display certifications
echo   7. Add more certifications and refresh preview page
echo.
echo EXPECTED RESULTS:
echo   [OK] CMS form saves without CSRF errors
echo   [OK] API returns JSON with certifications data
echo   [OK] Preview page displays certifications dynamically
echo   [OK] Changes in CMS appear on preview immediately
echo.
echo To stop testing, close this window or press Ctrl+C in server window.
pause