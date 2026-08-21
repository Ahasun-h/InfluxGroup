<x-layouts.cms_app title="CMS Admin - Contact Page" :cmsData="$cmsData">
    <x-slot:styles>
    </x-slot:styles>

    <!-- Left Sidebar with Collapsible Forms -->
    <aside class="cms-sidebar">
        <div class="cms-sidebar-header">
            <div class="cms-sidebar-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                CMS Admin
            </div>
            <div class="cms-sidebar-subtitle">Contact Page Sections</div>
        </div>

        <nav>
            <!-- Hero Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('hero')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Hero Section
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="hero-content">
                    <div class="alert alert-success" id="alert-hero-success">
                        <strong>Success!</strong> Hero section saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-hero-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="hero-form" class="cms-form" onsubmit="saveSection(event, 'hero')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Badge Text</label>
                            <input type="text" name="badge" class="cms-form-input" value="{{ $cmsData['hero']['badge'] ?? 'Contact Us' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Main Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['hero']['title'] ?? 'GET IN TOUCH' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['hero']['description'] ?? 'Ready to discuss your next project? Contact our team for expert consultation and solutions.' }}</textarea>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Hero Section</button>
                    </form>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('info')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>
                        </svg>
                        Contact Information
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="info-content">
                    <div class="alert alert-success" id="alert-info-success">
                        <strong>Success!</strong> Contact information saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-info-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="info-form" class="cms-form" onsubmit="saveSection(event, 'info')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="form-subtitle">Phone Numbers</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Phone 1</label>
                            <input type="text" name="phone_1" class="cms-form-input" value="{{ $cmsData['info']['phone_1'] ?? '+880 2 987 6543' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Phone 2</label>
                            <input type="text" name="phone_2" class="cms-form-input" value="{{ $cmsData['info']['phone_2'] ?? '+880 1XXX-XXXXXX' }}">
                        </div>

                        <div class="form-subtitle" style="margin-top: 1.5rem;">Email Addresses</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Email 1</label>
                            <input type="email" name="email_1" class="cms-form-input" value="{{ $cmsData['info']['email_1'] ?? 'info@influxgroup.com' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Email 2</label>
                            <input type="email" name="email_2" class="cms-form-input" value="{{ $cmsData['info']['email_2'] ?? 'sales@influxgroup.com' }}">
                        </div>

                        <div class="form-subtitle" style="margin-top: 1.5rem;">Office Hours</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Weekdays Hours</label>
                            <input type="text" name="office_hours_weekdays" class="cms-form-input" value="{{ $cmsData['info']['office_hours_weekdays'] ?? 'Saturday - Thursday: 9:00 AM - 6:00 PM' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Friday Hours</label>
                            <input type="text" name="office_hours_friday" class="cms-form-input" value="{{ $cmsData['info']['office_hours_friday'] ?? 'Friday: Closed' }}">
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Contact Information</button>
                    </form>
                </div>
            </div>

            <!-- Office Locations -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('offices')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Office Locations
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="offices-content">
                    <div class="alert alert-success" id="alert-offices-success">
                        <strong>Success!</strong> Offices saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-offices-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="offices-form" class="cms-form" onsubmit="saveSection(event, 'offices')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="deleted_offices" id="deleted_offices" value="">

                        <div id="offices-container">
                            @foreach($cmsData['offices'] as $index => $office)
                                <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative; margin-bottom: 8px;" data-office-id="{{ $office['order'] ?? $index + 1 }}">
                                    <button type="button" style="position: absolute; top: 0.5rem; right: 0.5rem; width: 1.75rem; height: 1.75rem; background: rgba(220, 38, 38, 0.3); color: #f87171; border: none; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center;" onclick="deleteOffice({{ $office['order'] ?? $index + 1 }}, this)">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                    <div style="font-weight: 700; font-size: 0.8rem; color: #60a5fa; margin-bottom: 0.75rem;">Office {{ $index + 1 }}</div>

                                    <div class="cms-form-group">
                                        <label class="cms-form-label">City</label>
                                        <input type="text" name="office_{{ $office['order'] ?? $index + 1 }}_city" class="cms-form-input" value="{{ $office['city'] ?? '' }}" placeholder="e.g. Dhaka">
                                    </div>
                                    <div class="cms-form-group">
                                        <label class="cms-form-label">Office Type</label>
                                        <input type="text" name="office_{{ $office['order'] ?? $index + 1 }}_type" class="cms-form-input" value="{{ $office['type'] ?? '' }}" placeholder="e.g. Corporate Headquarters">
                                    </div>
                                    <div class="cms-form-group">
                                        <label class="cms-form-label">Address</label>
                                        <input type="text" name="office_{{ $office['order'] ?? $index + 1 }}_address" class="cms-form-input" value="{{ $office['address'] ?? '' }}">
                                    </div>
                                    <div class="cms-form-group">
                                        <label class="cms-form-label">Phone</label>
                                        <input type="text" name="office_{{ $office['order'] ?? $index + 1 }}_phone" class="cms-form-input" value="{{ $office['phone'] ?? '' }}">
                                    </div>
                                    <div class="cms-form-group">
                                        <label class="cms-form-label">Email</label>
                                        <input type="text" name="office_{{ $office['order'] ?? $index + 1 }}_email" class="cms-form-input" value="{{ $office['email'] ?? '' }}">
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add Office Button -->
                            <div id="add-office-button" style="border: 2px dashed #1e293b; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem; cursor: pointer; transition: all 0.3s; min-height: 120px;" onmouseover="this.style.borderColor='#3b82f6'; this.style.background='rgba(59,130,246,0.05)'" onmouseout="this.style.borderColor='#1e293b'; this.style.background='transparent'" onclick="addNewOffice()">
                                <div style="width: 3rem; height: 3rem; border-radius: 50%; background: #0f172a; color: #6b7280; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                                    <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #6b7280;">Add New Office</span>
                            </div>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success" style="margin-top: 1.5rem;">Save Office Locations</button>
                    </form>
                </div>
            </div>

            <!-- Map Location -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('map')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Map Location
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="map-content">
                    <div class="alert alert-success" id="alert-map-success">
                        <strong>Success!</strong> Map location saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-map-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="map-form" class="cms-form" onsubmit="saveSection(event, 'map')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Google Maps Embed URL</label>
                            <textarea name="map_embed_url" class="cms-form-textarea" rows="4" placeholder="Paste the Google Maps embed URL here...">{{ $cmsData['map']['embed_url'] ?? '' }}</textarea>
                            <p style="font-size: 0.7rem; color: #6b7280; margin-top: 0.5rem;">Tip: In Google Maps, click Share → Embed a map → Copy the URL from the src attribute of the iframe.</p>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Map Location</button>
                    </form>
                </div>
            </div>

            <!-- Emergency Support -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('emergency')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Emergency Support
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="emergency-content">
                    <div class="alert alert-success" id="alert-emergency-success">
                        <strong>Success!</strong> Emergency section saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-emergency-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="emergency-form" class="cms-form" onsubmit="saveSection(event, 'emergency')">
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Title</label>
                            <input type="text" name="emergency_title" class="cms-form-input" value="{{ strip_tags($cmsData['emergency']['title'] ?? 'Emergency Support') }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="emergency_description" class="cms-form-textarea">{{ $cmsData['emergency']['description'] ?? '24/7 emergency support available for critical power infrastructure issues' }}</textarea>
                        </div>

                        <div class="form-subtitle" style="margin-top: 1.5rem;">Primary Button</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Button Text</label>
                            <input type="text" name="emergency_primary_text" class="cms-form-input" value="{{ $cmsData['emergency']['primary_text'] ?? 'Emergency Line' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Button Link</label>
                            <input type="text" name="emergency_primary_link" class="cms-form-input" value="{{ $cmsData['emergency']['primary_link'] ?? 'tel:+88029876543' }}">
                        </div>

                        <div class="form-subtitle" style="margin-top: 1.5rem;">Secondary Button</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Button Text</label>
                            <input type="text" name="emergency_secondary_text" class="cms-form-input" value="{{ $cmsData['emergency']['secondary_text'] ?? 'Email Support' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Button Link</label>
                            <input type="text" name="emergency_secondary_link" class="cms-form-input" value="{{ $cmsData['emergency']['secondary_link'] ?? 'mailto:support@influxgroup.com' }}">
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Emergency Section</button>
                    </form>
                </div>
            </div>
        </nav>

        <a href="{{ route('dashboard') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </aside>

    <!-- Main Content - Browser preview -->
    <main class="cms-main">
        <div class="cms-header">
            <div>
                <div class="cms-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <span>Contact Page CMS</span>
                </div>
                <h1 class="cms-page-title">Contact Page Live Preview</h1>
            </div>
        </div>

        <div class="browser-container">
            <div class="browser-card">
                <!-- Browser Toolbar -->
                <div class="browser-toolbar">
                    <div class="browser-buttons">
                        <button onclick="reloadPage()" class="browser-btn" title="Reload page">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                        <button onclick="goHome()" class="browser-btn" title="Go home">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="browser-address-bar">
                        <span class="browser-secure-icon">🔒</span>
                        <input type="text" value="http://localhost:5173/preview/contact/hero-section" id="url-input" placeholder="Enter preview URL...">
                        <span id="current-section-badge" class="browser-section-badge">Contact Hero Section</span>
                    </div>

                    <button onclick="openInNewTab()" class="browser-btn" title="Open in new tab">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </button>
                </div>

                <!-- Browser Content -->
                <div class="browser-content">
                    <div class="loading-overlay" id="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                    <iframe
                        src="http://localhost:5173/preview/contact/hero-section"
                        class="browser-iframe"
                        id="browser-iframe"
                        data-default-src="http://localhost:5173/preview/contact/hero-section"
                        onload="hideLoading()"
                        onerror="handleError()">
                    </iframe>
                </div>
            </div>
        </div>
    </main>

    <x-slot:scripts>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            const PREVIEW_BASE_URL = 'http://localhost:5173';

            const sectionPreviewUrls = {
                'hero': PREVIEW_BASE_URL + '/preview/contact/hero-section',
                'info': PREVIEW_BASE_URL + '/preview/contact/info',
                'offices': PREVIEW_BASE_URL + '/preview/contact/offices',
                'map': PREVIEW_BASE_URL + '/preview/contact/map',
                'emergency': PREVIEW_BASE_URL + '/preview/contact/emergency'
            };

            const sectionPreviewNames = {
                'hero': 'Contact Hero Section',
                'info': 'Contact Information',
                'offices': 'Office Locations',
                'map': 'Map Location',
                'emergency': 'Emergency Support'
            };

            function showLoading() {
                const overlay = document.getElementById('loading-overlay');
                if (overlay) overlay.style.display = 'flex';
            }

            function hideLoading() {
                const overlay = document.getElementById('loading-overlay');
                if (overlay) overlay.style.display = 'none';
            }

            function handleError() {
                hideLoading();
                console.error('Failed to load preview');
            }

            function toggleSection(sectionId, btnElem = null) {
                // Close all sections
                document.querySelectorAll('.cms-nav-header').forEach(header => {
                    header.classList.remove('active');
                    const arrow = header.querySelector('.cms-nav-arrow');
                    if (arrow) arrow.classList.remove('expanded');
                });
                document.querySelectorAll('.cms-nav-content').forEach(content => {
                    content.style.display = 'none';
                    content.classList.remove('active');
                });

                // Open selected section
                let clickedHeader = btnElem;
                if (!clickedHeader && typeof event !== 'undefined' && event && event.currentTarget) {
                    clickedHeader = event.currentTarget;
                }
                if (!clickedHeader) {
                    clickedHeader = document.querySelector(`button[onclick*="toggleSection('${sectionId}')"]`);
                }

                const targetContent = document.getElementById(sectionId + '-content');

                if (clickedHeader) {
                    clickedHeader.classList.add('active');
                    const arrow = clickedHeader.querySelector('.cms-nav-arrow');
                    if (arrow) arrow.classList.add('expanded');
                }
                if (targetContent) {
                    targetContent.style.display = 'block';
                    targetContent.classList.add('active');
                }

                // Update preview iframe
                const previewUrl = sectionPreviewUrls[sectionId] || (PREVIEW_BASE_URL + '/preview/contact/' + sectionId);
                const iframe = document.getElementById('browser-iframe');
                const urlInput = document.getElementById('url-input');
                const badge = document.getElementById('current-section-badge');

                showLoading();
                if (iframe) iframe.src = previewUrl;
                if (urlInput) urlInput.value = previewUrl;
                if (badge) badge.textContent = sectionPreviewNames[sectionId] || formatSectionTitle(sectionId);
            }

            function formatSectionTitle(sectionId) {
                return sectionId.split('-')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            }

            function reloadPage() {
                const iframe = document.getElementById('browser-iframe');
                showLoading();
                if (iframe) iframe.src = iframe.src;
            }

            function goHome() {
                const iframe = document.getElementById('browser-iframe');
                const urlInput = document.getElementById('url-input');
                const badge = document.getElementById('current-section-badge');

                showLoading();
                const defaultUrl = PREVIEW_BASE_URL + '/preview/contact/hero-section';
                if (iframe) iframe.src = defaultUrl;
                if (urlInput) urlInput.value = defaultUrl;
                if (badge) badge.textContent = 'Contact Hero Section';
            }

            function openInNewTab() {
                const urlInput = document.getElementById('url-input');
                const url = urlInput ? urlInput.value : (PREVIEW_BASE_URL + '/preview/contact/hero-section');
                window.open(url, '_blank');
            }

            async function saveSection(event, sectionId) {
                event.preventDefault();
                const form = document.getElementById(sectionId + '-form');
                const formData = new FormData(form);
                const alertSuccess = document.getElementById('alert-' + sectionId + '-success');
                const alertError = document.getElementById('alert-' + sectionId + '-error');

                if (alertSuccess) alertSuccess.style.display = 'none';
                if (alertError) alertError.style.display = 'none';

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Saving...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch('/admin/cms-section/contact-section/' + sectionId, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        if (alertSuccess) {
                            alertSuccess.style.display = 'block';
                            alertSuccess.innerHTML = '<strong>Success!</strong> ' + (data.message || 'Section saved successfully.');
                            setTimeout(() => {
                                alertSuccess.style.display = 'none';
                            }, 3000);
                        }
                        reloadPage();
                    } else {
                        throw new Error(data.message || 'Failed to save section');
                    }
                } catch (err) {
                    console.error('Error saving section:', err);
                    if (alertError) {
                        alertError.style.display = 'block';
                        alertError.innerHTML = '<strong>Error!</strong> ' + err.message;
                        setTimeout(() => {
                            alertError.style.display = 'none';
                        }, 5000);
                    }
                } finally {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            }

            // Office management
            var nextOfficeId = {{ $cmsData['offices']->count() + 1 }};

            function addNewOffice() {
                const container = document.getElementById('offices-container');
                const addButton = document.getElementById('add-office-button');

                if (!container || !addButton) return;

                const div = document.createElement('div');
                div.className = 'cms-value-item';
                div.style = 'background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative; margin-bottom: 8px;';
                div.setAttribute('data-office-id', nextOfficeId);
                div.innerHTML = `
                    <button type="button" style="position: absolute; top: 0.5rem; right: 0.5rem; width: 1.75rem; height: 1.75rem; background: rgba(220, 38, 38, 0.3); color: #f87171; border: none; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center;" onclick="deleteOffice(${nextOfficeId}, this)">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div style="font-weight: 700; font-size: 0.8rem; color: #60a5fa; margin-bottom: 0.75rem;">New Office</div>
                    <div class="cms-form-group">
                        <label class="cms-form-label">City</label>
                        <input type="text" name="office_${nextOfficeId}_city" class="cms-form-input" placeholder="e.g. Sylhet">
                    </div>
                    <div class="cms-form-group">
                        <label class="cms-form-label">Office Type</label>
                        <input type="text" name="office_${nextOfficeId}_type" class="cms-form-input" placeholder="e.g. Branch Office">
                    </div>
                    <div class="cms-form-group">
                        <label class="cms-form-label">Address</label>
                        <input type="text" name="office_${nextOfficeId}_address" class="cms-form-input" placeholder="Full address">
                    </div>
                    <div class="cms-form-group">
                        <label class="cms-form-label">Phone</label>
                        <input type="text" name="office_${nextOfficeId}_phone" class="cms-form-input" placeholder="+880 ...">
                    </div>
                    <div class="cms-form-group">
                        <label class="cms-form-label">Email</label>
                        <input type="text" name="office_${nextOfficeId}_email" class="cms-form-input" placeholder="office@influxgroup.com">
                    </div>
                `;

                container.insertBefore(div, addButton);
                nextOfficeId++;
            }

            function deleteOffice(officeId, btn) {
                const item = btn.closest('.cms-value-item');
                if (item) {
                    item.remove();
                    // Track deleted office
                    const deletedField = document.getElementById('deleted_offices');
                    if (deletedField) {
                        const current = deletedField.value;
                        deletedField.value = current ? current + ',' + officeId : String(officeId);
                    }
                }
            }
        </script>
    </x-slot:scripts>
</x-layouts.cms_app>
