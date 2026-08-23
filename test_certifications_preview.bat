@echo off
echo ============================================
echo Testing Certifications Preview Page
echo ============================================
echo.

echo [Step 1] Starting Laravel Server...
start cmd /k "cd D:\Herd\InfluxGroup-backend && php artisan serve"

echo [Step 2] Waiting for server to start...
timeout /t 3 /nobreak >nul

echo [Step 3] Opening automated test page...
start test_preview_page.html

echo [Step 4] Opening preview page in browser...
timeout /t 2 /nobreak >nul
start http://127.0.0.1:8000/preview/certifications

echo [Step 5] Opening CMS for adding test data...
timeout /t 1 /nobreak >nul
start http://127.0.0.1:8000/admin/cms-section/home-page

echo.
echo ============================================
echo Test Environment Started!
echo ============================================
echo.
echo 1. Laravel Server running in separate window
echo 2. Automated test page opened in browser
echo 3. Preview page opened in new tab
echo 4. CMS admin opened in new tab
echo.
echo Test Instructions:
echo 1. Click "Run All Tests" in test page
echo 2. Check preview page displays certifications
echo 3. Add test data via CMS
echo 4. Refresh preview page to see dynamic data
echo.
echo Press any key to stop testing...
pause >nul

echo.
echo To stop the server, close the Laravel Server window or press Ctrl+C in that window
pause