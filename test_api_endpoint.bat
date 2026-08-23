@echo off
echo ============================================
echo Testing Certifications API Endpoint
echo ============================================
echo.

echo [1] Starting Laravel Server...
start cmd /k "cd D:\Herd\InfluxGroup-backend && php artisan serve --host=127.0.0.1 --port=8000"

echo [2] Waiting for server to start...
timeout /t 3 /nobreak >nul

echo [3] Testing API Endpoint...
curl -X GET http://127.0.0.1:8000/api/cms/home-certifications

echo.
echo [4] Testing with detailed response...
curl -X GET http://127.0.0.1:8000/api/cms/home-certifications -w "\n\nHTTP Status: %{http_code}\nContent-Type: %{content_type}\n"

echo.
echo ============================================
echo API Endpoint Test Complete
echo ============================================
pause