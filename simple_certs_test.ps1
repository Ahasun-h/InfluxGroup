# Simple PowerShell test script for Certifications integration
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Certifications CMS Integration Test" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Change to project directory
Set-Location "D:\Herd\InfluxGroup-backend"

Write-Host "[Step 1] Starting Laravel Server..." -ForegroundColor Yellow
$serverProcess = Start-Process -FilePath "php" -ArgumentList "artisan", "serve", "--host", "127.0.0.1", "--port", "8000" -PassThru -WindowStyle Minimized

Write-Host "Server started (PID: " -NoNewline
Write-Host $serverProcess.Id -ForegroundColor Green
Write-Host ")"

Write-Host "Waiting for server to start..." -ForegroundColor Yellow
Start-Sleep -Seconds 5

Write-Host "[Step 2] Opening browser windows..." -ForegroundColor Yellow
Start-Process "http://127.0.0.1:8000/admin/cms-section/home-page"
Start-Sleep -Seconds 1
Start-Process "http://127.0.0.1:8000/api/cms/home-certifications"
Start-Sleep -Seconds 1
Start-Process "http://127.0.0.1:8000/preview/certifications"

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Test Environment Ready!" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "BROWSER WINDOWS OPENED:" -ForegroundColor Green
Write-Host "  1. CMS Admin page" -ForegroundColor White
Write-Host "  2. API endpoint" -ForegroundColor White
Write-Host "  3. Preview page" -ForegroundColor White

Write-Host ""
Write-Host "TESTING STEPS:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. In CMS page, click 'Certifications' section" -ForegroundColor White
Write-Host "2. Click 'Add New Certification' and add test data:" -ForegroundColor White
Write-Host "   - ISO 9001:2015 | Quality Management | [emoji]" -ForegroundColor Gray
Write-Host "   - ISO 14001:2015 | Environmental Management | [emoji]" -ForegroundColor Gray
Write-Host "3. Click 'Save Certifications'" -ForegroundColor White
Write-Host "4. Check API page - should show JSON with your data" -ForegroundColor White
Write-Host "5. Check Preview page - should display certifications" -ForegroundColor White
Write-Host "6. Add more certifications and refresh preview page" -ForegroundColor White

Write-Host ""
Write-Host "Press any key to stop server..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

Stop-Process -Id $serverProcess.Id -Force -ErrorAction SilentlyContinue
Write-Host "Server stopped." -ForegroundColor Green