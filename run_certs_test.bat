@echo off
echo ============================================
echo Certifications Integration Test Launcher
echo ============================================
echo.
echo This will launch the PowerShell test script
echo.
pause
PowerShell -ExecutionPolicy Bypass -File "%~dp0test_certifications_integration.ps1"
pause