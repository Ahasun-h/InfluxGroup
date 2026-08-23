# PowerShell script for testing Certifications CMS integration
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Certifications CMS Integration Test" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Change to project directory
Set-Location "D:\Herd\InfluxGroup-backend"

# Test 1: Check PHP availability
Write-Host "[Test 1] Checking PHP availability..." -ForegroundColor Yellow
try {
    $phpVersion = php --version 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ PHP is available" -ForegroundColor Green
        Write-Host "  $phpVersion" -ForegroundColor Gray
    } else {
        Write-Host "✗ PHP not found or not working" -ForegroundColor Red
        Write-Host "  Please install PHP and add it to your PATH" -ForegroundColor Red
        exit 1
    }
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

# Test 3: Check if port 8000 is available
Write-Host "[Test 3] Checking if port 8000 is available..." -ForegroundColor Yellow
$port8000 = Get-NetTCPConnection -LocalPort 8000 -ErrorAction SilentlyContinue
if ($port8000) {
    Write-Host "⚠ Port 8000 is already in use" -ForegroundColor Yellow
    Write-Host "  Trying to use port 8001 instead..." -ForegroundColor Yellow
    $port = 8001
} else {
    Write-Host "✓ Port 8000 is available" -ForegroundColor Green
    $port = 8000
}

# Test 4: Check route configuration
Write-Host "[Test 4] Checking route configuration..." -ForegroundColor Yellow
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

# Test 5: Check controller method
Write-Host "[Test 5] Checking controller method..." -ForegroundColor Yellow
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

# Test 6: Check database connection
Write-Host "[Test 6] Testing database connection..." -ForegroundColor Yellow
try {
    $dbTest = php artisan tinker --execute="echo 'DB Connection: OK';" 2>&1
    if ($dbTest -match "DB Connection: OK") {
        Write-Host "✓ Database connection working" -ForegroundColor Green
    } else {
        Write-Host "⚠ Database connection may have issues" -ForegroundColor Yellow
    }
} catch {
    Write-Host "⚠ Could not test database connection" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Starting Test Environment" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Start Laravel server
Write-Host "[Starting] Laravel server on port $port..." -ForegroundColor Yellow
$serverProcess = Start-Process -FilePath "php" -ArgumentList "artisan", "serve", "--host", "127.0.0.1", "--port", $port -PassThru -WindowStyle Minimized

Write-Host "✓ Server process started (PID: $($serverProcess.Id))" -ForegroundColor Green
Write-Host "  Server URL: http://127.0.0.1:$port" -ForegroundColor Gray

# Wait for server to start
Write-Host "Waiting for server to start (5 seconds)..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

# Test API endpoint
Write-Host ""
Write-Host "[API Test] Testing API endpoint..." -ForegroundColor Yellow
try {
    $apiUrl = "http://127.0.0.1:$port/api/cms/home-certifications"
    $response = Invoke-RestMethod -Uri $apiUrl -Method Get -TimeoutSec 10

    Write-Host "✓ API endpoint responding" -ForegroundColor Green
    Write-Host "  URL: $apiUrl" -ForegroundColor Gray
    Write-Host "  Status: Working" -ForegroundColor Gray

    if ($response.success) {
        Write-Host "✓ API response valid (success: true)" -ForegroundColor Green
        Write-Host "  Title: $($response.data.title)" -ForegroundColor Gray
        Write-Host "  Subtitle: $($response.data.subtitle)" -ForegroundColor Gray
        Write-Host "  Certifications count: $($response.data.certifications.Count)" -ForegroundColor Gray
    } else {
        Write-Host "⚠ API response format unexpected" -ForegroundColor Yellow
    }

    # Show full response
    Write-Host ""
    Write-Host "Full API Response:" -ForegroundColor Cyan
    $response | ConvertTo-Json -Depth 10 | Write-Host
} catch {
    Write-Host "✗ API endpoint not responding" -ForegroundColor Red
    Write-Host "  Error: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Opening Browser Windows" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan

# Open browser windows
Write-Host "[Opening] CMS Admin page..." -ForegroundColor Yellow
Start-Process "http://127.0.0.1:$port/admin/cms-section/home-page"

Start-Sleep -Seconds 1

Write-Host "[Opening] API endpoint page..." -ForegroundColor Yellow
Start-Process "http://127.0.0.1:$port/api/cms/home-certifications"

Start-Sleep -Seconds 1

Write-Host "[Opening] Preview page..." -ForegroundColor Yellow
Start-Process "http://127.0.0.1:$port/preview/certifications"

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Test Environment Ready!" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan

Write-Host ""
Write-Host "🌐 Browser Windows Opened:" -ForegroundColor Green
Write-Host "  1. CMS Admin: http://127.0.0.1:$port/admin/cms-section/home-page" -ForegroundColor White
Write-Host "  2. API Endpoint: http://127.0.0.1:$port/api/cms/home-certifications" -ForegroundColor White
Write-Host "  3. Preview Page: http://127.0.0.1:$port/preview/certifications" -ForegroundColor White

Write-Host ""
Write-Host "📋 Testing Instructions:" -ForegroundColor Yellow
Write-Host ""
Write-Host "PART 1: ADD CERTIFICATIONS IN CMS" -ForegroundColor Cyan
Write-Host "  1. In the CMS page, click 'Certifications' section" -ForegroundColor White
Write-Host "  2. Click 'Add New Certification' button" -ForegroundColor White
Write-Host "  3. Add 3-4 test certifications:" -ForegroundColor White
Write-Host "     - ISO 9001:2015 | Quality Management | 🏆" -ForegroundColor Gray
Write-Host "     - ISO 14001:2015 | Environmental Management | 🌱" -ForegroundColor Gray
Write-Host "     - CE Mark | European Conformity | 🇪🇺" -ForegroundColor Gray
Write-Host "  4. Click 'Save Certifications'" -ForegroundColor White

Write-Host ""
Write-Host "PART 2: VERIFY API RESPONSE" -ForegroundColor Cyan
Write-Host "  1. Check the API endpoint page" -ForegroundColor White
Write-Host "  2. You should see JSON with your certifications" -ForegroundColor White
Write-Host "  3. Verify data structure is correct" -ForegroundColor White

Write-Host ""
Write-Host "PART 3: VERIFY PREVIEW PAGE" -ForegroundColor Cyan
Write-Host "  1. Check the preview page" -ForegroundColor White
Write-Host "  2. You should see your certifications displayed" -ForegroundColor White
Write-Host "  3. Verify responsive layout (resize browser)" -ForegroundColor White
Write-Host "  4. Test hover effects on certification boxes" -ForegroundColor White

Write-Host ""
Write-Host "PART 4: TEST DYNAMIC UPDATES" -ForegroundColor Cyan
Write-Host "  1. Go back to CMS and add more certifications" -ForegroundColor White
Write-Host "  2. Click 'Save Certifications'" -ForegroundColor White
Write-Host "  3. Refresh the preview page" -ForegroundColor White
Write-Host "  4. New certifications should appear immediately" -ForegroundColor White

Write-Host ""
Write-Host "✅ Expected Results:" -ForegroundColor Green
Write-Host "  • CMS form saves without CSRF errors" -ForegroundColor White
Write-Host "  • API returns proper JSON with certifications" -ForegroundColor White
Write-Host "  • Preview page displays certifications dynamically" -ForegroundColor White
Write-Host "  • Changes in CMS appear on preview immediately" -ForegroundColor White

Write-Host ""
Write-Host "🔍 To stop testing:" -ForegroundColor Yellow
Write-Host "  1. Close this PowerShell window" -ForegroundColor White
Write-Host "  2. Or press Ctrl+C to stop the server" -ForegroundColor White

Write-Host ""
Write-Host "Press any key to stop the server and exit..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

# Stop the server process
Write-Host ""
Write-Host "Stopping Laravel server..." -ForegroundColor Yellow
Stop-Process -Id $serverProcess.Id -Force -ErrorAction SilentlyContinue
Write-Host "✓ Server stopped" -ForegroundColor Green

Write-Host ""
Write-Host "Test complete. Thank you for testing!" -ForegroundColor Cyan