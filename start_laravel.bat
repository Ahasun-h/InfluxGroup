@echo off
echo ============================================
echo Starting Laravel Backend Server
echo ============================================
echo.
echo This will start the Laravel server that your Vue
echo frontend needs to fetch certifications data.
echo.
echo The Vue frontend at http://localhost:5173 will connect
echo to this backend server at http://localhost:8000
echo.
echo ============================================
echo Starting Laravel Server on port 8000...
echo ============================================
echo.

cd D:\Herd\InfluxGroup-backend
php artisan serve --host=127.0.0.1 --port=8000