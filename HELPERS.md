# Helper Functions Documentation

This file contains comprehensive documentation for all custom helper functions available in the InfluxGroup Backend application.

## CMS Content Helpers

### `get_cms_content($sectionName, $itemName, $default = null)`
Get CMS content by section and item name from the database.

**Parameters:**
- `$sectionName` - Section name in database
- `$itemName` - Item name within section
- `$default` - Default value if content not found

**Returns:** Mixed (content value or default)

**Example:**
```php
$title = get_cms_content('brand_statements_section', 'brand_statements_title', 'Default Title');
```

### `get_cms_json($sectionName, $itemName, $default = [])`
Get CMS content and decode as JSON.

**Parameters:**
- `$sectionName` - Section name in database
- `$itemName` - Item name within section
- `$default` - Default value if content not found or invalid JSON

**Returns:** Array (decoded JSON data)

**Example:**
```php
$stats = get_cms_json('brand_statements_section', 'brand_statements_stat1');
```

### `get_brand_content($items, $key, $default = '')`
Get brand statements content - alias for CMS content retrieval from items collection.

**Parameters:**
- `$items` - Collection of CMS items
- `$key` - Item key to retrieve
- `$default` - Default value

**Returns:** Mixed

**Example:**
```php
$title = get_brand_content($brandItems, 'brand_statements_title', 'Default Title');
```

### `save_cms_content($sectionName, $itemName, $content, $attributes = null, $mediaFiles = null)`
Save CMS content to database using updateOrCreate.

**Parameters:**
- `$sectionName` - Section name in database
- `$itemName` - Item name within section
- `$content` - Content to save
- `$attributes` - Optional attributes
- `$mediaFiles` - Optional media files reference

**Returns:** ContentManagement model instance

**Example:**
```php
save_cms_content('brand_statements_section', 'brand_statements_title', 'New Title');
```

### `get_cms_section_data($sectionName, $itemNames = [])`
Get all data for a CMS section.

**Parameters:**
- `$sectionName` - Section name in database
- `$itemNames` - Optional array of specific item names to retrieve

**Returns:** Collection of CMS items keyed by item name

**Example:**
```php
$brandData = get_cms_section_data('brand_statements_section');
$specificData = get_cms_section_data('brand_statements_section', ['brand_statements_title', 'brand_statements_description']);
```

## Image/File Helpers

### `process_image_upload($imageUrl, $directory, $prefix = 'image')`
Process image upload from base64 or URL, with validation and file saving.

**Parameters:**
- `$imageUrl` - Image URL or base64 data
- `$directory` - Directory to save image (relative to public path)
- `$prefix` - File name prefix for generated files

**Returns:** String (image URL/path)

**Throws:** Exception if image validation fails

**Example:**
```php
$imagePath = process_image_upload($request->image_url, 'uploads/brand-statements', 'brand');
```

### `format_cms_image($imageUrl)`
Format CMS image URL for display with proper asset handling.

**Parameters:**
- `$imageUrl` - Image URL or relative path

**Returns:** String|null (formatted image URL)

**Example:**
```php
$displayUrl = format_cms_image('/uploads/image.jpg');
```

## JSON/Data Helpers

### `is_valid_json($string)`
Check if a string is valid JSON.

**Parameters:**
- `$string` - String to validate

**Returns:** Boolean

**Example:**
```php
if (is_valid_json($data)) {
    $decoded = json_decode($data);
}
```

### `safe_json_decode($json, $default = null)`
Safely decode JSON with error handling.

**Parameters:**
- `$json` - JSON string to decode
- `$default` - Default value if decoding fails

**Returns:** Mixed (decoded data or default)

**Example:**
```php
$data = safe_json_decode($jsonString, []);
```

### `array_get_nested($array, $key, $default = null)`
Get nested array value using dot notation.

**Parameters:**
- `$array` - Array to search
- `$key` - Dot notation key (e.g., 'user.profile.name')
- `$default` - Default value if key not found

**Returns:** Mixed

**Example:**
```php
$name = array_get_nested($user, 'profile.name', 'Unknown');
```

## String/Text Helpers

### `generate_slug($text, $separator = '-')`
Generate URL-friendly slug from string.

**Parameters:**
- `$text` - Text to convert to slug
- `$separator` - Separator character (default: '-')

**Returns:** String (slug)

**Example:**
```php
$slug = generate_slug('Hello World'); // Returns: 'hello-world'
```

### `truncate_text($text, $length = 100, $suffix = '...')`
Truncate text to specified length with suffix.

**Parameters:**
- `$text` - Text to truncate
- `$length` - Maximum length
- `$suffix` - Suffix to add when truncated

**Returns:** String

**Example:**
```php
$short = truncate_text($longText, 50, '...');
```

### `generate_random_string($length = 10, $includeNumbers = true, $includeSpecialChars = false)`
Generate random string with customizable options.

**Parameters:**
- `$length` - String length
- `$includeNumbers` - Include numbers (default: true)
- `$includeSpecialChars` - Include special characters (default: false)

**Returns:** String (random string)

**Example:**
```php
$random = generate_random_string(16, true, false);
```

## Detection Helpers

### `is_emoji($string)`
Check if string contains emoji characters.

**Parameters:**
- `$string` - String to check

**Returns:** Boolean

**Example:**
```php
if (is_emoji($text)) {
    // Handle emoji text
}
```

### `is_image_url($string)`
Check if string is an image URL (not emoji).

**Parameters:**
- `$string` - String to check

**Returns:** Boolean

**Example:**
```php
if (is_image_url($logo)) {
    // Handle image URL
}
```

## Format Helpers

### `format_file_size($bytes, $precision = 2)`
Format file size in human-readable format.

**Parameters:**
- `$bytes` - File size in bytes
- `$precision` - Decimal precision (default: 2)

**Returns:** String (formatted size)

**Example:**
```php
$size = format_file_size(1048576); // Returns: '1 MB'
```

### `format_currency($amount, $currency = 'USD', $decimals = 2)`
Format currency value with symbol.

**Parameters:**
- `$amount` - Amount to format
- `$currency` - Currency code (default: 'USD')
- `$decimals` - Decimal precision (default: 2)

**Returns:** String (formatted currency)

**Example:**
```php
$price = format_currency(99.99, 'USD'); // Returns: '$99.99'
```

### `format_date($date, $format = 'F j, Y')`
Format date for display.

**Parameters:**
- `$date` - DateTime object or string
- `$format` - Date format (default: 'F j, Y')

**Returns:** String (formatted date)

**Example:**
```php
$displayDate = format_date($date, 'F j, Y'); // Returns: 'January 1, 2024'
```

### `time_ago($date)`
Get time ago string (e.g., "5 minutes ago").

**Parameters:**
- `$date` - DateTime object or string

**Returns:** String (relative time)

**Example:**
```php
$relative = time_ago($createdAt); // Returns: '2 hours ago'
```

## Route/Navigation Helpers

### `is_active_route($routeNames)`
Check if current route matches given route name(s).

**Parameters:**
- `$routeNames` - Route name string or array of route names

**Returns:** Boolean

**Example:**
```php
if (is_active_route('admin.dashboard')) {
    // Add active class
}
```

### `set_active_class($routeNames, $activeClass = 'active')`
Set active CSS class based on route.

**Parameters:**
- `$routeNames` - Route name string or array
- `$activeClass` - CSS class name (default: 'active')

**Returns:** String (empty string or active class)

**Example:**
```php
<li class="{{ set_active_class('admin.dashboard') }}">
```

## Cache Helpers

### `cache_remember($key, $ttl, $callback, $tags = [])`
Cache remember with tags support.

**Parameters:**
- `$key` - Cache key
- `$ttl` - Time to live (DateTimeInterval or int seconds)
- `$callback` - Callback function to generate cached data
- `$tags` - Optional array of cache tags

**Returns:** Mixed (cached or generated data)

**Example:**
```php
$data = cache_remember('cms_data', 3600, function() {
    return get_cms_section_data('brand_statements_section');
}, ['cms']);
```

### `clear_cache_by_tags($tags)`
Clear cache by tags.

**Parameters:**
- `$tags` - Array of cache tags to clear

**Returns:** Boolean (success status)

**Example:**
```php
clear_cache_by_tags(['cms', 'brand_statements']);
```

## Utility Helpers

### `get_client_ip()`
Get client IP address with proxy detection.

**Returns:** String (IP address)

**Example:**
```php
$ip = get_client_ip();
```

### `get_gravatar_url($email, $size = 80, $default = 'mp')`
Get Gravatar URL for email.

**Parameters:**
- `$email` - Email address
- `$size` - Image size (default: 80)
- `$default` - Default image type (default: 'mp')

**Returns:** String (Gravatar URL)

**Example:**
```php
$avatar = get_gravatar_url('user@example.com', 80, 'mp');
```

## Usage Examples

### Complete CMS Workflow
```php
// Get CMS content
$title = get_cms_content('brand_statements_section', 'brand_statements_title');

// Get JSON data
$stats = get_cms_json('brand_statements_section', 'brand_statements_stat1');

// Process image upload
$imagePath = process_image_upload($request->image_url, 'uploads/brand-statements', 'brand');

// Save updated content
save_cms_content('brand_statements_section', 'brand_statements_title', 'New Title');

// Clear related cache
clear_cache_by_tags(['cms']);
```

### Form Handling
```php
// Process form data
$title = $request->title;
$slug = generate_slug($title);
$imageUrl = process_image_upload($request->image_url, 'uploads/products', 'product');

// Save to CMS
save_cms_content('product_section', 'product_title', $title);
save_cms_content('product_section', 'product_slug', $slug);
save_cms_content('product_section', 'product_image', $imageUrl);
```

### Display Logic
```php
// Get and display content
$title = get_cms_content('brand_statements_section', 'brand_statements_title', 'Default Title');
$imageUrl = format_cms_image(get_cms_content('brand_statements_section', 'brand_statements_image'));
$stats = get_cms_json('brand_statements_section', 'brand_statements_stat1');

// Format display
<div>
    <h2>{{ $title }}</h2>
    <img src="{{ $imageUrl }}" alt="{{ $title }}">
    <p>Value: {{ $stats['value'] ?? 'N/A' }}</p>
</div>
```

## Notes

- All helper functions are automatically loaded via the HelperServiceProvider
- Helper functions are available globally throughout the application
- Functions include proper error handling and validation
- Most functions include sensible default values
- All functions follow Laravel coding standards

## Testing

Helper functions can be tested in tinker:

```bash
php artisan tinker
>>> is_emoji('😀')
// true
>>> generate_slug('Hello World')
// "hello-world"
>>> format_file_size(1048576)
// "1 MB"
```
