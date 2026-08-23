@echo off
echo ============================================
echo Testing Certifications API Endpoint
echo ============================================
echo.

echo Starting Laravel server...
start "Laravel Server" cmd /k "cd D:\Herd\InfluxGroup-backend && php artisan serve"

echo Waiting for server to start (5 seconds)...
timeout /t 5 /nobreak >nul

echo.
echo Testing API endpoint...
echo.
echo Opening browser to: http://127.0.0.1:8000/api/cms/home-certifications
start http://127.0.0.1:8000/api/cms/home-certifications

echo.
echo ============================================
echo Server is running in separate window
echo Browser should show API response
echo ============================================
echo.
echo Press any key to stop testing...
pause >nul

echo.
echo To stop the server, close the Laravel Server window or press Ctrl+C in that window
pause