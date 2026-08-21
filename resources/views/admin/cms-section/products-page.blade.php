<x-layouts.cms_app title="CMS Admin - Products Page" :cmsData="$cmsData">
    <x-slot:styles></x-slot:styles>

    <aside class="cms-sidebar">
        <div class="cms-sidebar-header">
            <div class="cms-sidebar-title">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                CMS Admin
            </div>
            <div class="cms-sidebar-subtitle">Products Page Sections</div>
        </div>

        <nav>
            <!-- Hero Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header active" onclick="toggleSection('hero')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Hero Section
                    </div>
                    <svg class="cms-nav-arrow expanded" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content active" id="hero-content">
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
                            <input type="text" name="badge" class="cms-form-input" value="{{ $cmsData['hero']['badge'] ?? 'Our Products' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Main Title (HTML allowed for highlights)</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['hero']['title'] ?? 'ENGINEERING EXCELLENCE' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['hero']['description'] ?? 'Comprehensive portfolio of power systems and equipment designed for reliability, efficiency, and sustainability.' }}</textarea>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Hero Section</button>
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
                    <span>Products Page CMS</span>
                </div>
                <h1 class="cms-page-title">Products Page Live Preview</h1>
            </div>
        </div>

        <div class="browser-container">
            <div class="browser-card">
                <div class="browser-toolbar">
                    <div class="browser-buttons">
                        <button onclick="reloadPage()" class="browser-btn" title="Reload page">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                        <button onclick="goHome()" class="browser-btn" title="Go home">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="browser-address-bar">
                        <span class="browser-secure-icon">🔒</span>
                        <input type="text" value="http://localhost:5173/preview/products/hero-section" id="url-input" placeholder="Enter preview URL...">
                        <span id="current-section-badge" class="browser-section-badge">Products Hero Section</span>
                    </div>
                    <button onclick="openInNewTab()" class="browser-btn" title="Open in new tab">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </button>
                </div>

                <div class="browser-content">
                    <div class="loading-overlay" id="loading-overlay">
                        <div class="loading-spinner"></div>
                    </div>
                    <iframe
                        src="http://localhost:5173/preview/products/hero-section"
                        class="browser-iframe"
                        id="browser-iframe"
                        data-default-src="http://localhost:5173/preview/products/hero-section"
                        onload="hideLoading()"
                        onerror="handleError()">
                    </iframe>
                </div>
            </div>
        </div>
    </main>

    <x-slot:scripts>
        <script>
            const PREVIEW_BASE_URL = 'http://localhost:5173';

            const sectionPreviewUrls = {
                'hero': PREVIEW_BASE_URL + '/preview/products/hero-section'
            };

            const sectionPreviewNames = {
                'hero': 'Products Hero Section'
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

            function toggleSection(sectionId) {
                document.querySelectorAll('.cms-nav-header').forEach(h => {
                    h.classList.remove('active');
                    const a = h.querySelector('.cms-nav-arrow');
                    if (a) a.classList.remove('expanded');
                });
                document.querySelectorAll('.cms-nav-content').forEach(c => {
                    c.style.display = 'none';
                    c.classList.remove('active');
                });

                const clickedHeader = document.querySelector(`button[onclick*="toggleSection('${sectionId}')"]`);
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

                const previewUrl = sectionPreviewUrls[sectionId] || (PREVIEW_BASE_URL + '/preview/products/' + sectionId);
                const iframe = document.getElementById('browser-iframe');
                const urlInput = document.getElementById('url-input');
                const badge = document.getElementById('current-section-badge');

                showLoading();
                if (iframe) iframe.src = previewUrl;
                if (urlInput) urlInput.value = previewUrl;
                if (badge) badge.textContent = sectionPreviewNames[sectionId] || sectionId;
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
                const defaultUrl = PREVIEW_BASE_URL + '/preview/products/hero-section';
                if (iframe) iframe.src = defaultUrl;
                if (urlInput) urlInput.value = defaultUrl;
                if (badge) badge.textContent = 'Products Hero Section';
            }

            function openInNewTab() {
                const urlInput = document.getElementById('url-input');
                const url = urlInput ? urlInput.value : (PREVIEW_BASE_URL + '/preview/products/hero-section');
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
                    const response = await fetch('/admin/cms-section/products-page/' + sectionId, {
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
                            alertSuccess.innerHTML = '<strong>Success!</strong> ' + (data.message || 'Saved successfully.');
                            setTimeout(() => alertSuccess.style.display = 'none', 3000);
                        }
                        reloadPage();
                    } else {
                        throw new Error(data.message || 'Failed to save');
                    }
                } catch (err) {
                    if (alertError) {
                        alertError.style.display = 'block';
                        alertError.innerHTML = '<strong>Error!</strong> ' + err.message;
                        setTimeout(() => alertError.style.display = 'none', 5000);
                    }
                } finally {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            }
        </script>
    </x-slot:scripts>
</x-layouts.cms_app>
