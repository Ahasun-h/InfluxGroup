# 🧪 Testing the Certifications API Endpoint

## Quick Test Method

### Option 1: Run PowerShell Script
```powershell
# Open PowerShell as Administrator
cd D:\Herd\InfluxGroup-backend
.\test_certifications_api.ps1
```

### Option 2: Manual Testing Step-by-Step

#### Step 1: Open PowerShell/Terminal
Press `Win + X`, select "Windows PowerShell" or "Terminal"

#### Step 2: Navigate to Project
```powershell
cd D:\Herd\InfluxGroup-backend
```

#### Step 3: Start Laravel Server
```powershell
php artisan serve
```

You should see:
```
INFO  Server running on [http://127.0.0.1:8000].
  Press Ctrl+C to stop the server
```

#### Step 4: Test API Endpoint
Open a NEW terminal window and run:

```powershell
# Test basic API call
curl http://127.0.0.1:8000/api/cms/home-certifications

# Or with more details
curl http://127.0.0.1:8000/api/cms/home-certifications | ConvertFrom-Json | ConvertTo-Json -Depth 10
```

#### Step 5: Test in Browser
Open browser and navigate to:
```
http://127.0.0.1:8000/api/cms/home-certifications
```

## Expected Results

### ✅ Success Response (Empty Data):
```json
{
  "success": true,
  "data": {
    "title": "Certifications & Standards",
    "subtitle": "Internationally recognized certifications ensuring quality and safety",
    "certifications": [],
    "list": []
  }
}
```

### ✅ Success Response (With Data):
```json
{
  "success": true,
  "data": {
    "title": "Professional Certifications",
    "subtitle": "Our quality standards",
    "certifications": [
      {
        "name": "ISO 9001:2015",
        "title": "ISO 9001:2015",
        "description": "Quality Management System",
        "icon": "🏆"
      }
    ],
    "list": [...]
  }
}
```

## Troubleshooting

### Error: "php: command not found"
**Solution:** Install PHP and add to PATH, or use XAMPP/WAMP

### Error: "Connection refused"
**Solution:** Make sure Laravel server is running on port 8000

### Error: "404 Not Found"
**Solution:** Clear Laravel cache
```powershell
php artisan route:clear
php artisan cache:clear
```

### Error: "500 Internal Server Error"
**Solution:** Check Laravel logs
```powershell
php artisan log:tail
```

## Advanced Testing

### Test Route Registration:
```powershell
php artisan route:list | findstr home-certifications
```

### Test Controller Method:
```powershell
php artisan tinker
>>> App\Http\Controllers\Api\ContentController::class
>>> $controller = new App\Http\Controllers\Api\ContentController()
>>> $controller->getHomeCertifications()
```

### Test Database Query:
```powershell
php artisan tinker
>>> App\Models\ContentManagement::where('section_name', 'certifications')->get()
```

## Quick Checklist

✅ **PHP Installed**: `php --version`
✅ **Laravel Running**: Server starts on port 8000
✅ **Route Registered**: `php artisan route:list` shows the route
✅ **Controller Method Exists**: `getHomeCertifications()` found in controller
✅ **API Returns JSON**: Valid JSON response received
✅ **Response Structure**: Contains success, data, title, subtitle, certifications, list

## 🚀 Next Steps After Testing

1. Add some certifications via CMS: `/admin/cms-section/home-page`
2. Re-test API to see populated data
3. Test frontend integration on homepage
4. Test preview page at `/preview/home/certifications`