# PowerShell script to test Certifications API endpoint
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Testing Certifications API Endpoint" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Change to the project directory
Set-Location "D:\Herd\InfluxGroup-backend"

# Test 1: Check if PHP is available
Write-Host "[Test 1] Checking PHP availability..." -ForegroundColor Yellow
try {
    $phpVersion = php --version
    Write-Host "✓ PHP is available: $phpVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ PHP not found. Please install PHP and add it to PATH." -ForegroundColor Red
    exit 1
}

# Test 2: Check Laravel installation
Write-Host "[Test 2] Checking Laravel installation..." -ForegroundColor Yellow
if (Test-Path "artisan") {
    Write-Host "✓ Laravel artisan file found" -ForegroundColor Green
} else {
    Write-Host "✗ Laravel installation not found" -ForegroundColor Red
    exit 1
}

# Test 3: Check route configuration
Write-Host "[Test 3] Checking route configuration..." -ForegroundColor Yellow
if (Test-Path "routes\api.php") {
    $routeContent = Get-Content "routes\api.php" -Raw
    if ($routeContent -match "home-certifications") {
        Write-Host "✓ Route 'home-certifications' found in api.php" -ForegroundColor Green
    } else {
        Write-Host "✗ Route 'home-certifications' not found" -ForegroundColor Red
    }
} else {
    Write-Host "✗ routes/api.php file not found" -ForegroundColor Red
}

# Test 4: Check controller method
Write-Host "[Test 4] Checking controller method..." -ForegroundColor Yellow
if (Test-Path "app\Http\Controllers\Api\ContentController.php") {
    $controllerContent = Get-Content "app\Http\Controllers\Api\ContentController.php" -Raw
    if ($controllerContent -match "getHomeCertifications") {
        Write-Host "✓ Controller method 'getHomeCertifications' found" -ForegroundColor Green
    } else {
        Write-Host "✗ Controller method 'getHomeCertifications' not found" -ForegroundColor Red
    }
} else {
    Write-Host "✗ ContentController.php not found" -ForegroundColor Red
}

# Test 5: Start Laravel server and test API
Write-Host "[Test 5] Starting Laravel server..." -ForegroundColor Yellow
Write-Host "Server will start on http://127.0.0.1:8000" -ForegroundColor Cyan
Write-Host "Press Ctrl+C to stop the server when done testing" -ForegroundColor Yellow
Write-Host ""

# Start Laravel server
php artisan serve --host=127.0.0.1 --port=8000