<x-layouts.cms_app title="CMS Admin - About Page" :cmsData="$cmsData">
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
            <div class="cms-sidebar-subtitle">About Page Sections</div>
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
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Badge Text</label>
                            <input type="text" name="badge" class="cms-form-input" value="{{ $cmsData['hero']['badge'] ?? 'About Us' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Main Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['hero']['title'] ?? 'POWERING PROGRESS SINCE 1980' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['hero']['description'] ?? 'From humble beginnings to becoming Bangladesh\'s premier engineering conglomerate, our journey reflects four decades of excellence, innovation, and unwavering commitment to national development.' }}</textarea>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Hero Section</button>
                    </form>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('mission-vision')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Mission & Vision
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="mission-vision-content">
                    <div class="alert alert-success" id="alert-mission-vision-success">
                        <strong>Success!</strong> Mission & Vision saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-mission-vision-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="mission-vision-form" class="cms-form" onsubmit="saveSection(event, 'mission-vision')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-subtitle">Mission Statement</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Mission Title</label>
                            <input type="text" name="mission_title" class="cms-form-input" value="{{ $cmsData['missionVision']['mission']['title'] ?? 'OUR MISSION' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Mission Description</label>
                            <textarea name="mission_description" class="cms-form-textarea">{{ $cmsData['missionVision']['mission']['description'] ?? '' }}</textarea>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Mission Points (one per line)</label>
                            <textarea name="mission_points" class="cms-form-textarea" rows="4">{{ implode("\n", $cmsData['missionVision']['mission']['points'] ?? []) }}</textarea>
                        </div>

                        <div class="form-subtitle" style="margin-top: 1.5rem;">Vision Statement</div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Vision Title</label>
                            <input type="text" name="vision_title" class="cms-form-input" value="{{ $cmsData['missionVision']['vision']['title'] ?? 'OUR VISION' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Vision Description</label>
                            <textarea name="vision_description" class="cms-form-textarea">{{ $cmsData['missionVision']['vision']['description'] ?? '' }}</textarea>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Vision Points (one per line)</label>
                            <textarea name="vision_points" class="cms-form-textarea" rows="4">{{ implode("\n", $cmsData['missionVision']['vision']['points'] ?? []) }}</textarea>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Mission & Vision</button>
                    </form>
                </div>
            </div>

            <!-- Journey Section -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('journey')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Journey Timeline
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="journey-content">
                    <div class="alert alert-success" id="alert-journey-success">
                        <strong>Success!</strong> Journey timeline saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-journey-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="journey-form" class="cms-form" onsubmit="saveSection(event, 'journey')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['journey']['title'] ?? 'Our Journey' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="cms-form-input" value="{{ $cmsData['journey']['subtitle'] ?? '' }}">
                        </div>

                        <div class="form-subtitle">Milestones Timeline</div>

                        @foreach($cmsData['journey']['milestones'] as $index => $milestone)
                            <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1rem;">
                                <div style="font-weight: 700; font-size: 0.8rem; color: #60a5fa; margin-bottom: 0.75rem;">Milestone {{ $index + 1 }}</div>
                                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 0.5rem; margin-bottom: 0.75rem;">
                                    <input type="text" name="milestone_{{ $index + 1 }}_year" class="cms-form-input" placeholder="Year" value="{{ $milestone['year'] ?? '' }}">
                                    <input type="text" name="milestone_{{ $index + 1 }}_title" class="cms-form-input" placeholder="Title" value="{{ $milestone['title'] ?? '' }}">
                                </div>
                                <textarea name="milestone_{{ $index + 1 }}_description" class="cms-form-textarea" placeholder="Description">{{ $milestone['description'] ?? '' }}</textarea>
                            </div>
                        @endforeach

                        <button type="submit" class="cms-btn cms-btn-success">Save Journey Timeline</button>
                    </form>
                </div>
            </div>

            <!-- Core Values -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('core-values')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Core Values
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="core-values-content">
                    <div class="alert alert-success" id="alert-core-values-success">
                        <strong>Success!</strong> Core Values saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-core-values-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="core-values-form" class="cms-form" onsubmit="saveCoreValues(event)">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['coreValues']['title'] ?? 'Core Values' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="cms-form-input" value="{{ $cmsData['coreValues']['subtitle'] ?? '' }}">
                        </div>

                        <div class="form-subtitle">Values List</div>

                        <div id="values-container">
                            @foreach($cmsData['coreValues']['values'] as $index => $val)
                                <div class="cms-value-item" style="background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative; margin-bottom: 8px" data-value-id="{{ $val['id'] ?? $index + 1 }}">
                                    <!-- Delete Button -->
                                    <button type="button" class="delete-value-btn" style="position: absolute; top: 0.5rem; right: 0.5rem; width: 1.75rem; height: 1.75rem; background: rgba(220, 38, 38, 0.3); color: #f87171; border: none; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'" onclick="deleteValue({{ $val['id'] ?? $index + 1 }}, this)">
                                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="delete_value_{{ $val['id'] ?? $index + 1 }}" id="delete_value_{{ $val['id'] ?? $index + 1 }}" value="">

                                    <div style="font-weight: 700; font-size: 0.8rem; color: #34d399; margin-bottom: 0.75rem;">Value {{ $index + 1 }}</div>

                                    <!-- Icon Preview Section -->
                                    <div style="margin-bottom: 1rem;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                            <label style="font-size: 0.625rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.1em; color: #3b82f6;">Icon Preview</label>
                                            <div style="width: 4rem; height: 4rem; background: rgba(59, 130, 246, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; overflow: hidden;" id="icon-preview-{{ $val['id'] ?? $index + 1 }}">
                                                <div style="width: 2rem; height: 2rem; color: #3b82f6; display: flex; align-items: center; justify-content-center;" id="icon-container-{{ $val['id'] ?? $index + 1 }}">
                                                    {!! $val['icon'] ?? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div style="position: relative;">
                                            <textarea name="values[{{ $val['id'] ?? $index + 1 }}][icon]" id="icon-input-{{ $val['id'] ?? $index + 1 }}" rows="3" class="cms-form-textarea" style="font-family: monospace; font-size: 0.75rem; height: 4rem; resize: none;" placeholder="Paste your SVG code here..." oninput="updateIconPreview({{ $val['id'] ?? $index + 1 }}, this.value)">{!! $val['icon'] ?? '' !!}</textarea>
                                            <div style="position: absolute; top: 0.5rem; right: 0.5rem; font-size: 0.5rem; color: #4b5563; font-family: monospace;">SVG</div>
                                        </div>
                                    </div>

                                    <div class="cms-form-group">
                                        <label class="cms-form-label">Title</label>
                                        <input type="text" name="values[{{ $val['id'] ?? $index + 1 }}][title]" class="cms-form-input" value="{{ $val['title'] ?? '' }}">
                                    </div>

                                    <div class="cms-form-group">
                                        <label class="cms-form-label">Description</label>
                                        <textarea name="values[{{ $val['id'] ?? $index + 1 }}][description]" class="cms-form-textarea" rows="3">{{ $val['description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add New Value Button -->
                            <div id="add-value-button" style="border: 2px dashed #1e293b; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem; cursor: pointer; transition: all 0.3s; min-height: 200px;" onmouseover="this.style.borderColor='#3b82f6'; this.style.background='rgba(59, 130, 246, 0.05)'" onmouseout="this.style.borderColor='#1e293b'; this.style.background='transparent'" onclick="addNewValue()">
                                <div style="width: 4rem; height: 4rem; border-radius: 50%; background: #0f172a; color: #6b7280; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; transition: all 0.3s;" id="add-icon-bg">
                                    <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #6b7280; transition: color 0.3s;" id="add-text">Add New Value</span>
                                <span style="font-size: 0.75rem; color: #4b5563; margin-top: 0.5rem;" id="add-subtext">Click to add a new core value</span>
                                <span style="font-size: 0.625rem; color: #6b7280; margin-top: 0.25rem;" id="add-limit-text">Maximum 4 values allowed</span>
                            </div>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success" style="margin-top: 1.5rem;">Save Core Values</button>
                    </form>
                </div>
            </div>

            <!-- Certifications -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('certifications')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        Certifications & Standards
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="certifications-content">
                    <div class="alert alert-success" id="alert-certifications-success">
                        <strong>Success!</strong> Certifications saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-certifications-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="certifications-form" class="cms-form" onsubmit="saveSection(event, 'certifications')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">Section Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['certifications']['title'] ?? 'Certifications & Standards' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="cms-form-input" value="{{ $cmsData['certifications']['subtitle'] ?? '' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Certifications List (one per line)</label>
                            <textarea name="certifications" class="cms-form-textarea" rows="6">{{ implode("\n", $cmsData['certifications']['list'] ?? []) }}</textarea>
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Certifications</button>
                    </form>
                </div>
            </div>

            <!-- Career CTA -->
            <div class="cms-nav-item">
                <button class="cms-nav-header" onclick="toggleSection('career-cta')">
                    <div class="cms-nav-label">
                        <svg class="cms-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Career CTA
                    </div>
                    <svg class="cms-nav-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="cms-nav-content" id="career-cta-content">
                    <div class="alert alert-success" id="alert-career-cta-success">
                        <strong>Success!</strong> Career CTA saved successfully.
                    </div>
                    <div class="alert alert-error" id="alert-career-cta-error">
                        <strong>Error!</strong> Something went wrong.
                    </div>

                    <form id="career-cta-form" class="cms-form" onsubmit="saveSection(event, 'career-cta')">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="cms-form-group">
                            <label class="cms-form-label">CTA Title</label>
                            <input type="text" name="title" class="cms-form-input" value="{{ $cmsData['careerCta']['title'] ?? 'Join Our Mission' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="description" class="cms-form-textarea">{{ $cmsData['careerCta']['description'] ?? '' }}</textarea>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Button Text</label>
                            <input type="text" name="button_text" class="cms-form-input" value="{{ $cmsData['careerCta']['button_text'] ?? 'Career Opportunities' }}">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Button Link</label>
                            <input type="text" name="button_link" class="cms-form-input" value="{{ $cmsData['careerCta']['button_link'] ?? '/contact' }}">
                        </div>

                        <button type="submit" class="cms-btn cms-btn-success">Save Career CTA</button>
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
                    <span>About Page CMS</span>
                </div>
                <h1 class="cms-page-title">About Page Live Preview</h1>
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
                        <input type="text" value="http://localhost:5173/preview/about/hero-section" id="url-input" placeholder="Enter preview URL...">
                        <span id="current-section-badge" class="browser-section-badge">About Hero Section</span>
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
                        src="http://localhost:5173/preview/about/hero-section"
                        class="browser-iframe"
                        id="browser-iframe"
                        data-default-src="http://localhost:5173/preview/about/hero-section"
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
                'hero': PREVIEW_BASE_URL + '/preview/about/hero-section',
                'mission-vision': PREVIEW_BASE_URL + '/preview/about/mission-vision',
                'journey': PREVIEW_BASE_URL + '/preview/about/journey',
                'core-values': PREVIEW_BASE_URL + '/preview/about/core-values',
                'certifications': PREVIEW_BASE_URL + '/preview/about/certifications',
                'career-cta': PREVIEW_BASE_URL + '/preview/about/career-cta'
            };

            const sectionPreviewNames = {
                'hero': 'About Hero Section',
                'mission-vision': 'Mission & Vision',
                'journey': 'Journey Timeline',
                'core-values': 'Core Values',
                'certifications': 'Certifications & Standards',
                'career-cta': 'Career CTA'
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

                // Update main browser iframe and address bar in cms_app layout
                const previewUrl = sectionPreviewUrls[sectionId] || (PREVIEW_BASE_URL + '/preview/about/' + sectionId);

                const iframe = document.getElementById('browser-iframe');
                const urlInput = document.getElementById('url-input');
                const badge = document.getElementById('current-section-badge');

                showLoading();
                if (iframe) {

                    console.log('Preview URL:', previewUrl);

                    iframe.src = previewUrl;
                }
                if (urlInput) {
                    urlInput.value = previewUrl;
                }
                if (badge) {
                    badge.textContent = sectionPreviewNames[sectionId] || formatSectionTitle(sectionId);
                }
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
                const defaultUrl = PREVIEW_BASE_URL + '/preview/about/hero-section';
                if (iframe) iframe.src = defaultUrl;
                if (urlInput) urlInput.value = defaultUrl;
                if (badge) badge.textContent = 'About Hero Section';
            }

            function openInNewTab() {
                const urlInput = document.getElementById('url-input');
                const url = urlInput ? urlInput.value : (PREVIEW_BASE_URL + '/preview/about/hero-section');
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
                    const response = await fetch('/admin/cms-section/about-page/' + sectionId, {
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

            // Core Values specific functions
            window.nextValueId = {{ count($cmsData['coreValues']['values'] ?? []) + 1 }};
            var nextValueId = window.nextValueId;

            function updateIconPreview(id, svgValue) {
                const container = document.getElementById(`icon-container-${id}`);
                const preview = document.getElementById(`icon-preview-${id}`);

                if (container && svgValue.trim()) {
                    try {
                        container.innerHTML = svgValue;

                        const svg = container.querySelector('svg');
                        if (svg) {
                            svg.style.width = '100%';
                            svg.style.height = '100%';
                            svg.style.maxWidth = '2rem';
                            svg.style.maxHeight = '2rem';
                            svg.style.overflow = 'visible';
                        }

                        if (preview) {
                            preview.style.transform = 'scale(0.95)';
                            preview.style.opacity = '0.7';
                            setTimeout(() => {
                                preview.style.transform = 'scale(1)';
                                preview.style.opacity = '1';
                            }, 150);
                        }
                    } catch (error) {
                        console.error('Error updating icon preview:', error);
                        container.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                    }
                }
            }

            function addNewValue() {
                try {
                    const container = document.getElementById('values-container');
                    const addButton = container.lastElementChild;

                    if (!container || !addButton) {
                        console.error('Container or add button not found!');
                        return;
                    }

                    // Check current count of value items (excluding the add button)
                    const currentValueCount = container.querySelectorAll('.cms-value-item').length;
                    const MAX_VALUES = 4;

                    if (currentValueCount >= MAX_VALUES) {
                        alert(`Maximum ${MAX_VALUES} core values allowed. Please delete existing values before adding new ones.`);
                        return;
                    }

                    const div = document.createElement('div');
                    div.className = 'cms-value-item';
                    div.style = 'background: #0f172a; border: 1px solid #334155; border-radius: 0.5rem; padding: 1rem; position: relative;';
                    div.setAttribute('data-value-id', nextValueId);
                    div.innerHTML = `
                        <!-- Delete Button -->
                        <button type="button" class="delete-value-btn" style="position: absolute; top: 0.5rem; right: 0.5rem; width: 1.75rem; height: 1.75rem; background: rgba(220, 38, 38, 0.3); color: #f87171; border: none; border-radius: 0.25rem; display: flex; align-items: center; justify-center; opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'" onclick="deleteValue(${nextValueId}, this)">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <input type="hidden" name="delete_value_${nextValueId}" id="delete_value_${nextValueId}" value="">

                        <div style="font-weight: 700; font-size: 0.8rem; color: #34d399; margin-bottom: 0.75rem;">Value ${nextValueId}</div>

                        <!-- Icon Preview Section -->
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <label style="font-size: 0.625rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.1em; color: #3b82f6;">Icon Preview</label>
                                <div style="width: 4rem; height: 4rem; background: rgba(59, 130, 246, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; overflow: hidden;" id="icon-preview-${nextValueId}">
                                    <div style="width: 2rem; height: 2rem; color: #3b82f6; display: flex; align-items: center; justify-content-center;" id="icon-container-${nextValueId}">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div style="position: relative;">
                                <textarea name="values[${nextValueId}][icon]" id="icon-input-${nextValueId}" rows="3" class="cms-form-textarea" style="font-family: monospace; font-size: 0.75rem; height: 4rem; resize: none;" placeholder="Paste your SVG code here..." oninput="updateIconPreview(${nextValueId}, this.value)"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></textarea>
                                <div style="position: absolute; top: 0.5rem; right: 0.5rem; font-size: 0.5rem; color: #4b5563; font-family: monospace;">SVG</div>
                            </div>
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Title</label>
                            <input type="text" name="values[${nextValueId}][title]" class="cms-form-input" placeholder="Value Title">
                        </div>

                        <div class="cms-form-group">
                            <label class="cms-form-label">Description</label>
                            <textarea name="values[${nextValueId}][description]" class="cms-form-textarea" rows="3" placeholder="Value description..."></textarea>
                        </div>
                    `;

                    container.insertBefore(div, addButton);

                    // Focus on the title input field
                    setTimeout(() => {
                        const titleInput = div.querySelector('input[type="text"]');
                        if (titleInput) {
                            titleInput.focus();
                        }
                    }, 100);

                    nextValueId++;

                    // Update add button visibility
                    updateAddButtonVisibility();
                } catch (error) {
                    console.error('Error adding new value:', error);
                    alert('There was an error adding a new value. Please check the console for details.');
                }
            }

            function updateAddButtonVisibility() {
                const container = document.getElementById('values-container');
                const addButton = document.getElementById('add-value-button');
                const currentValueCount = container?.querySelectorAll('.cms-value-item').length || 0;
                const MAX_VALUES = 4;

                if (addButton) {
                    const addIconBg = document.getElementById('add-icon-bg');
                    const addText = document.getElementById('add-text');
                    const addSubtext = document.getElementById('add-subtext');
                    const limitText = document.getElementById('add-limit-text');

                    if (currentValueCount >= MAX_VALUES) {
                        // Disabled state
                        addButton.style.cursor = 'not-allowed';
                        addButton.style.opacity = '0.5';
                        addButton.style.border = '2px dashed #475569';
                        addButton.onclick = null; // Remove click handler

                        if (addIconBg) {
                            addIconBg.style.background = '#1e293b';
                            addIconBg.style.color = '#6b7280';
                        }

                        if (addText) {
                            addText.textContent = 'Maximum Limit Reached';
                            addText.style.color = '#ef4444';
                        }

                        if (addSubtext) {
                            addSubtext.textContent = `You have ${currentValueCount} of ${MAX_VALUES} values`;
                            addSubtext.style.color = '#ef4444';
                        }

                        if (limitText) {
                            limitText.textContent = 'Delete existing values to add new ones';
                            limitText.style.color = '#ef4444';
                        }
                    } else {
                        // Enabled state
                        addButton.style.cursor = 'pointer';
                        addButton.style.opacity = '1';
                        addButton.style.border = '2px dashed #1e293b';
                        addButton.onclick = addNewValue;

                        if (addIconBg) {
                            addIconBg.style.background = '#0f172a';
                            addIconBg.style.color = '#6b7280';
                        }

                        if (addText) {
                            addText.textContent = 'Add New Value';
                            addText.style.color = '#6b7280';
                        }

                        if (addSubtext) {
                            addSubtext.textContent = `Click to add a new core value (${currentValueCount}/${MAX_VALUES})`;
                            addSubtext.style.color = '#4b5563';
                        }

                        if (limitText) {
                            limitText.textContent = `Maximum ${MAX_VALUES} values allowed`;
                            limitText.style.color = '#6b7280';
                        }

                        // Re-add hover effects
                        addButton.onmouseover = function() {
                            this.style.borderColor = '#3b82f6';
                            this.style.background = 'rgba(59, 130, 246, 0.05)';
                        };
                        addButton.onmouseout = function() {
                            this.style.borderColor = '#1e293b';
                            this.style.background = 'transparent';
                        };
                    }
                }
            }

            function deleteValue(id, button) {
                event.preventDefault();
                if (confirm('Delete this core value?')) {
                    const form = document.getElementById('core-values-form');
                    const deleteInput = document.getElementById(`delete_value_${id}`);

                    if (deleteInput && form) {
                        deleteInput.value = id;
                        form.submit();
                    }
                }
            }

            function initializeCoreValues() {
                // Initialize icon previews with proper sizing
                const previews = document.querySelectorAll('[id^="icon-preview-"]');
                previews.forEach(preview => {
                    preview.style.transition = 'all 0.15s ease-out';
                });

                // Ensure all existing SVG icons are properly sized
                const containers = document.querySelectorAll('[id^="icon-container-"]');
                containers.forEach(container => {
                    const svg = container.querySelector('svg');
                    if (svg) {
                        svg.style.width = '100%';
                        svg.style.height = '100%';
                        svg.style.maxWidth = '2rem';
                        svg.style.maxHeight = '2rem';
                        svg.style.overflow = 'visible';
                    }
                });

                // Add delete button functionality
                const deleteButtons = document.querySelectorAll('.delete-value-btn');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const id = this.getAttribute('data-value-id');
                        if (confirm('Delete this core value?')) {
                            const form = document.getElementById('core-values-form');
                            const deleteInput = document.getElementById(`delete_value_${id}`);
                            if (deleteInput && form) {
                                deleteInput.value = id;
                                form.submit();
                            }
                        }
                    });
                });

                // Initialize add button visibility
                updateAddButtonVisibility();
            }

            async function saveCoreValues(event) {
                event.preventDefault();
                const form = document.getElementById('core-values-form');
                const formData = new FormData(form);
                const alertSuccess = document.getElementById('alert-core-values-success');
                const alertError = document.getElementById('alert-core-values-error');

                if (alertSuccess) alertSuccess.style.display = 'none';
                if (alertError) alertError.style.display = 'none';

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Saving...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch('/admin/cms-section/about-page/core-values', {
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
                            alertSuccess.innerHTML = '<strong>Success!</strong> ' + (data.message || 'Core Values saved successfully.');
                            setTimeout(() => {
                                alertSuccess.style.display = 'none';
                            }, 3000);
                        }
                        reloadPage();
                    } else {
                        throw new Error(data.message || 'Failed to save Core Values');
                    }
                } catch (err) {
                    console.error('Error saving Core Values:', err);
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

            // On DOM load, set up About page preview URL and open hero section by default
            document.addEventListener('DOMContentLoaded', function() {
                const initialUrl = PREVIEW_BASE_URL + '/preview/about/hero-section';
                const iframe = document.getElementById('browser-iframe');
                const urlInput = document.getElementById('url-input');
                const badge = document.getElementById('current-section-badge');

                if (iframe) iframe.src = initialUrl;
                if (urlInput) urlInput.value = initialUrl;
                if (badge) badge.textContent = 'About Hero Section';

                // Listen for Enter key on url-input to navigate iframe
                if (urlInput) {
                    urlInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            if (iframe && this.value) {
                                showLoading();
                                iframe.src = this.value;
                            }
                        }
                    });
                }

                // Open hero section by default
                setTimeout(() => {
                    const heroHeader = document.querySelector('button[onclick="toggleSection(\'hero\')"]');
                    const heroContent = document.getElementById('hero-content');
                    if (heroHeader && heroContent) {
                        heroHeader.classList.add('active');
                        heroContent.style.display = 'block';
                        heroContent.classList.add('active');
                    }
                }, 100);

                // Initialize Core Values functionality
                initializeCoreValues();
            });
        </script>
    </x-slot:scripts>
</x-layouts.cms_app>

