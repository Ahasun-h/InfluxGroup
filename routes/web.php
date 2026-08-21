<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Storage link creation routes - runs php artisan storage:link command
Route::get('/storage-files', [StorageController::class, 'createLink'])->name('storage.link');
Route::get('/storage-link', [StorageController::class, 'createLink'])->name('storage.create');

// Storage file serving route - serves files when nginx doesn't follow symlinks
Route::get('/storage-files/{folder}/{filename}', [StorageController::class, 'serve'])
    ->where('filename', '.*')
    ->name('storage.serve');

// Admin route for storage link creation
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('storage-link', [StorageController::class, 'createLink'])->name('storage.link.run');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Analytics management
    Route::get('analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/website', [\App\Http\Controllers\Admin\AnalyticsController::class, 'website'])->name('analytics.website');
    Route::get('analytics/business', [\App\Http\Controllers\Admin\AnalyticsController::class, 'business'])->name('analytics.business');
    Route::get('analytics/content', [\App\Http\Controllers\Admin\AnalyticsController::class, 'content'])->name('analytics.content');
    Route::get('analytics/api/chart-data', [\App\Http\Controllers\Admin\AnalyticsController::class, 'apiChartData'])->name('analytics.api.chart-data');

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::post('categories/update-order', [\App\Http\Controllers\Admin\CategoryController::class, 'updateOrder'])->name('categories.update-order');

    // Legacy redirects for backward compatibility
    Route::redirect('product-categories', 'categories?area=product');
    Route::redirect('project-categories', 'categories?area=project');

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/{product}/remove-gallery-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeGalleryImage'])->name('products.remove-gallery-image');
    Route::post('products/{product}/remove-brochure', [\App\Http\Controllers\Admin\ProductController::class, 'removeBrochure'])->name('products.remove-brochure');
    Route::post('products/{product}/remove-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeImage'])->name('products.remove-image');
    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
    Route::resource('services-and-solutions', \App\Http\Controllers\Admin\ServiceAndSolutionController::class)->parameters(['services-and-solutions' => 'item']);
    Route::post('services-and-solutions/{item}/remove-gallery-image', [\App\Http\Controllers\Admin\ServiceAndSolutionController::class, 'removeGalleryImage'])->name('services-and-solutions.remove-gallery-image');
    Route::post('services-and-solutions/{item}/remove-image', [\App\Http\Controllers\Admin\ServiceAndSolutionController::class, 'removeImage'])->name('services-and-solutions.remove-image');
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::post('news/{news}/remove-gallery-image', [\App\Http\Controllers\Admin\NewsController::class, 'removeGalleryImage'])->name('news.remove-gallery-image');
    Route::post('news/{news}/remove-image', [\App\Http\Controllers\Admin\NewsController::class, 'removeImage'])->name('news.remove-image');
    Route::post('news/upload-trix-image', [\App\Http\Controllers\Admin\NewsController::class, 'uploadTrixImage'])->name('news.upload-trix-image');
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Career Opportunities management (user-friendly URL)
    Route::resource('careers', \App\Http\Controllers\Admin\CareersController::class)->parameters([
        'careers' => 'career'
    ]);
    Route::post('careers/update-order', [\App\Http\Controllers\Admin\CareersController::class, 'updateOrder'])->name('careers.update-order');
    Route::post('careers/{career}/toggle-status', [\App\Http\Controllers\Admin\CareersController::class, 'toggleStatus'])->name('careers.toggle-status');
    Route::post('careers/{career}/restore', [\App\Http\Controllers\Admin\CareersController::class, 'restore'])->name('careers.restore');
    Route::get('careers-debug', [\App\Http\Controllers\Admin\CareersController::class, 'debug'])->name('careers.debug');

    // Test routes for debugging (remove after fixing)
    Route::get('test-career-update/{id?}', function($id = 2) {
        $job = \App\Models\CareerOpportunitie::find($id);
        if (!$job) {
            return redirect('/admin/careers')->with('error', 'Job not found');
        }
        return view('simple_test_update', ['job' => $job]);
    })->name('test.career.update');

    // Quotations management
    Route::resource('quotations', \App\Http\Controllers\Admin\QuotationController::class);
    Route::post('quotations/{quotation}/status', [\App\Http\Controllers\Admin\QuotationController::class, 'updateStatus'])->name('quotations.update-status');
    Route::get('quotations/{quotation}/pdf', [\App\Http\Controllers\Admin\QuotationController::class, 'generatePDF'])->name('quotations.pdf');
    Route::post('quotations/{quotation}/duplicate', [\App\Http\Controllers\Admin\QuotationController::class, 'duplicate'])->name('quotations.duplicate');

    // Quote Requests management
    Route::resource('quote-requests', \App\Http\Controllers\Admin\QuoteRequestController::class)->only(['index', 'show', 'destroy']);
    Route::get('quote-requests/{quoteRequest}/convert', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'convert'])->name('quote-requests.convert');
    Route::post('quote-requests/{quoteRequest}/convert', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'storeQuotation'])->name('quote-requests.store-quotation');
    Route::put('quote-requests/{quoteRequest}/status', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'updateStatus'])->name('quote-requests.update-status');

    // Leads management
    Route::resource('leads', \App\Http\Controllers\Admin\LeadsController::class)->only(['index', 'show', 'update', 'destroy']);

    // Customers management (CRM)
    Route::resource('customers', \App\Http\Controllers\Admin\CustomersController::class);
    Route::post('customers/{customer}/interactions', [\App\Http\Controllers\Admin\CustomersController::class, 'addInteraction'])->name('customers.add-interaction');
    Route::post('leads/{lead}/convert-to-customer', [\App\Http\Controllers\Admin\CustomersController::class, 'convertLead'])->name('leads.convert-to-customer');

    // Settings management
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/delete-logo', [\App\Http\Controllers\Admin\SettingsController::class, 'deleteLogo'])->name('settings.delete-logo');
    Route::post('settings/delete-logo-dark', [\App\Http\Controllers\Admin\SettingsController::class, 'deleteLogoDark'])->name('settings.delete-logo-dark');
    Route::post('settings/delete-favicon', [\App\Http\Controllers\Admin\SettingsController::class, 'deleteFavicon'])->name('settings.delete-favicon');

    // Journey timeline management (now using content_management system)
    Route::get('journey', [\App\Http\Controllers\Admin\JourneyController::class, 'index'])->name('journey.index');
    Route::put('journey', [\App\Http\Controllers\Admin\JourneyController::class, 'update'])->name('journey.update');

    // Subscription Section Routes
    Route::get('/subscription-section', [\App\Http\Controllers\Admin\SubscriptionSectionController::class, 'index'])->name('subscription-section.index');
    Route::put('/subscription-section', [\App\Http\Controllers\Admin\SubscriptionSectionController::class, 'update'])->name('subscription-section.update');

    // Career CTA Routes
    Route::get('/career-cta', [\App\Http\Controllers\Admin\CareerCtaController::class, 'index'])->name('career-cta-section.index');
    Route::put('/career-cta', [\App\Http\Controllers\Admin\CareerCtaController::class, 'update'])->name('career-cta-section.update');

    // Testimonials Routes
    Route::get('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('testimonials.index');
    Route::put('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'update'])->name('testimonials.update');
    Route::post('/testimonials', [\App\Http\Controllers\Admin\TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{id}', [\App\Http\Controllers\Admin\TestimonialController::class, 'updateTestimonial'])->name('testimonials.update-testimonial');
    Route::delete('/testimonials/{id}', [\App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Footer Routes - Redirect to settings (merged functionality)
    Route::redirect('/footer', '/settings', 301)->name('footer.index');

    // CMS Section Routes
    Route::prefix('cms-section')->name('cms-section.')->group(function () {
        Route::get('/home-page', [\App\Http\Controllers\Admin\HomePageController::class, 'index'])->name('home-page');
        Route::put('/home-page/{section}', [\App\Http\Controllers\Admin\HomePageController::class, 'update'])->name('home-page.update');
        Route::get('/about-page', [\App\Http\Controllers\Admin\AboutPageController::class, 'index'])->name('about-page');
        Route::put('/about-page/{section}', [\App\Http\Controllers\Admin\AboutPageController::class, 'update'])->name('about-page.update');
        Route::get('/contact-section', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contact-section');
        Route::put('/contact-section', [\App\Http\Controllers\Admin\ContactController::class, 'update'])->name('contact-section.update');
        Route::post('/contact-section/{section}', [\App\Http\Controllers\Admin\ContactController::class, 'updateSection'])->name('contact-section.update-section');
        Route::put('/contact-section/{section}', [\App\Http\Controllers\Admin\ContactController::class, 'updateSection'])->name('contact-section.update-section-put');
        Route::get('/products-page', [\App\Http\Controllers\Admin\ProductsPageController::class, 'index'])->name('products-page');
        Route::post('/products-page/{section}', [\App\Http\Controllers\Admin\ProductsPageController::class, 'update'])->name('products-page.update');
        Route::get('/projects-page', [\App\Http\Controllers\Admin\ProjectsPageController::class, 'index'])->name('projects-page');
        Route::post('/projects-page/{section}', [\App\Http\Controllers\Admin\ProjectsPageController::class, 'update'])->name('projects-page.update');
        Route::get('/services-page', [\App\Http\Controllers\Admin\ServicesPageController::class, 'index'])->name('services-page');
        Route::post('/services-page/{section}', [\App\Http\Controllers\Admin\ServicesPageController::class, 'update'])->name('services-page.update');
    });


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
