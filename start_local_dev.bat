@echo off
echo ============================================
echo Local Development Environment Setup
echo Certifications API Integration Test
echo ============================================
echo.

echo This script will set up the complete local development
echo environment for testing the Certifications API integration.
echo.

echo DEVELOPMENT STACK:
echo   • Vue Frontend: http://localhost:5173
echo   • Laravel Backend: http://localhost:8000
echo   • Preview Page: http://localhost:5173/preview/certifications
echo   • API Endpoint: http://localhost:8000/api/cms/home-certifications
echo.

echo ============================================
echo Step 1: Starting Laravel Backend Server
echo ============================================
echo.

echo Starting Laravel server on port 8000...
start "Laravel Backend" cmd /k "cd D:\Herd\InfluxGroup-backend && php artisan serve --host=127.0.0.1 --port=8000"

echo Waiting for Laravel server to start...
timeout /t 5 /nobreak >nul

echo ✓ Laravel backend should be running on http://localhost:8000
echo.

echo ============================================
echo Step 2: Starting Vue Frontend Dev Server
echo ============================================
echo.

echo Starting Vue development server on port 5173...
cd D:\Herd\InfluxGroup-backend\InfluxGroup
start "Vue Frontend" cmd /k "npm run dev"

echo Waiting for Vue dev server to start...
timeout /t 8 /nobreak >nul

echo ✓ Vue frontend should be running on http://localhost:5173
echo.

echo ============================================
echo Step 3: Opening Development URLs
echo ============================================
echo.

echo Opening development URLs in browser...
timeout /t 2 /nobreak >nul

echo Backend API test page...
start http://localhost:8000/api/cms/home-certifications

timeout /t 1 /nobreak >nul

echo Frontend preview page...
start http://localhost:5173/preview/certifications

timeout /t 1 /nobreak >nul

echo Vue dev server...
start http://localhost:5173

timeout /t 1 /nobreak >nul

echo CMS Admin page...
start http://localhost:8000/admin/cms-section/home-page

echo.
echo ============================================
echo Local Development Environment Ready!
echo ============================================
echo.

echo 🌐 OPENED BROWSER WINDOWS:
echo    1. Backend API: http://localhost:8000/api/cms/home-certifications
echo    2. Frontend Preview: http://localhost:5173/preview/certifications
echo    3. Vue Dev Server: http://localhost:5173
echo    4. CMS Admin: http://localhost:8000/admin/cms-section/home-page
echo.

echo 🔗 API INTEGRATION FLOW:
echo    CMS (localhost:8000) → Database → API → Vue (localhost:5173) → Display
echo.

echo 📋 TESTING INSTRUCTIONS:
echo.
echo PART 1: VERIFY API ENDPOINT
echo    1. Check the Backend API test page
echo    2. Should show JSON response structure
echo    3. Verify "success": true and "data" object
echo.

echo PART 2: VERIFY FRONTEND INTEGRATION
echo    1. Check the Frontend Preview page
echo    2. Should show loading state briefly
echo    3. Should display certifications (default or from CMS)
echo    4. Open browser console (F12) to see API call logs
echo.

echo PART 3: ADD CMS DATA
echo    1. Go to CMS Admin page
echo    2. Click "Certifications" section
echo    3. Add 3-4 test certifications:
echo       • ISO 9001:2015 | Quality Management | 🏆
echo       • ISO 14001:2015 | Environmental Management | 🌱
echo       • CE Mark | European Conformity | 🇪🇺
echo    4. Click "Save Certifications"
echo.

echo PART 4: VERIFY DYNAMIC DATA
echo    1. Check Backend API page - should show your data
echo    2. Check Frontend Preview page - should show certifications
echo    3. Add more certifications in CMS
echo    4. Refresh frontend preview page
echo    5. New data should appear immediately!
echo.

echo ✅ SUCCESS CRITERIA:
echo    [OK] Vue frontend loads on localhost:5173
echo    [OK] Laravel backend runs on localhost:8000
echo    [OK] API endpoint returns proper JSON
echo    [OK] Frontend fetches data from API successfully
echo    [OK] Preview page displays certifications dynamically
echo    [OK] CMS data appears on frontend immediately
echo.

echo 🔍 DEBUGGING:
echo    • Open browser console (F12) to see API call logs
echo    • Network tab shows actual API request/response
echo    • Look for "🔍 Fetching certifications from CMS..." logs
echo    • Check for "✅ Certifications data loaded successfully" logs
echo.

echo 🛑 TO STOP DEVELOPMENT:
echo    Close the "Laravel Backend" and "Vue Frontend" windows
echo    Or press Ctrl+C in each window
echo.

echo Press any key to continue with development...
pause >nul

echo.
echo Development servers are running in separate windows.
echo Keep this window open for reference, or close it when done.
pause