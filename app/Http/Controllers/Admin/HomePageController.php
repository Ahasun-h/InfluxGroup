<?php

namespace App\Http\Controllers\Admin;

use App\helpers\helpers;
use App\Http\Controllers\Admin\BrandStatementController;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;


class HomePageController extends Controller
{
    /**
     * Display the home page CMS view
     */
    public function index(): View
    {
        // Load all CMS section data
        $cmsData = $this->loadAllCmsData();

        return view('admin.cms-section.home-page', compact('cmsData'));
    }

    /**
     * Load all CMS section data
     */
    private function loadAllCmsData(): array
    {
        return [
            'hero' => $this->loadHeroSection(),
            'brandStatements' => $this->loadBrandStatements(),
            'missionVision' => $this->loadMissionVision(),
            'coreValues' => $this->loadCoreValues(),
            'journey' => $this->loadJourney(),
            'partners' => $this->loadPartners(),
            'certifications' => $this->loadCertifications(),
            'testimonials' => $this->loadTestimonials(),
            'contactCta' => $this->loadContactCta(),
            'subscriptionSection' => $this->loadSubscriptionSection(),
            'careerCta' => $this->loadCareerCta(),
        ];
    }

    private function updateOrCreateSectionItem(string $sectionName, string $itemName, array $values): ContentManagement
    {
        $item = ContentManagement::where('section_name', $sectionName)
            ->where('section_item_name', $itemName)
            ->where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })->first();

        if ($item) {
            $item->update(array_merge(['page_name' => 'home_page'], $values));
            return $item;
        }

        return ContentManagement::create(array_merge([
            'page_name' => 'home_page',
            'section_name' => $sectionName,
            'section_item_name' => $itemName,
        ], $values));
    }

    private function loadHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'hero_section')
            ->get()
            ->keyBy('section_item_name');

        $categories = [];
        for ($i = 1; $i <= 4; $i++) {
            $catKey = 'hero_section_category' . $i;
            if (isset($items[$catKey]) && $items[$catKey]->section_content) {
                $catData = json_decode($items[$catKey]->section_content, true);
                if ($catData) {
                    $categories[] = $catData;
                }
            }
        }

        return [
            'items' => $items,
            'categories' => collect($categories)->sortBy('order')->values()
        ];
    }

    private function loadBrandStatements()
    {
        // Ensure brand image exists in database
        $brandImage = ContentManagement::firstOrCreate(
            [
                'page_name' => 'home_page',
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_image'
            ],
            [
                'section_content' => null,
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Ensure overlay fields exist in database
        $overlayTitle = ContentManagement::firstOrCreate(
            [
                'page_name' => 'home_page',
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_overlay_title'
            ],
            [
                'section_content' => 'Core Reliability',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $overlayText = ContentManagement::firstOrCreate(
            [
                'page_name' => 'home_page',
                'section_name' => 'brand_statements_section',
                'section_item_name' => 'brand_statements_overlay_text'
            ],
            [
                'section_content' => 'Zero Downtime Operation Protocols',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'brand_statements_section')
            ->get()
            ->keyBy('section_item_name');

        $stats = [];
        for ($i = 1; $i <= 4; $i++) {
            $statKey = 'brand_statements_stat' . $i;
            if (isset($items[$statKey]) && $items[$statKey]->section_content) {
                $statData = json_decode($items[$statKey]->section_content, true);
                if ($statData && is_array($statData)) {
                    // Ensure the stat data has the required fields
                    $stats[] = [
                        'order' => $statData['order'] ?? $i,
                        'value' => $statData['value'] ?? '',
                        'label' => $statData['label'] ?? ''
                    ];
                }
            }
        }

        // Debug logging
        if (app()->environment('local')) {
            \Log::info('Brand statements stats loaded:', ['count' => count($stats), 'stats' => $stats]);
            \Log::info('Brand statements items keys:', ['keys' => array_keys($items->toArray())]);
        }

        // If no stats found, create default stats
        if (empty($stats)) {
            for ($i = 1; $i <= 4; $i++) {
                $stats[] = [
                    'order' => $i,
                    'value' => '',
                    'label' => ''
                ];
            }
        }

        return [
            'items' => $items,
            'stats' => collect($stats)->sortBy('order')->values()
        ];
    }

    private function loadMissionVision()
    {
        // Fetch all mission & vision items
        $mvItemsData = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'mission_vision')
            ->get()
            ->keyBy('section_item_name');

        // Map content to the expected format
        $mission = [
            'title' => $mvItemsData['mission_title']->section_content ?? 'OUR MISSION',
            'description' => $mvItemsData['mission_description']->section_content ?? 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
            'points' => json_decode($mvItemsData['mission_points']->section_content ?? '[]', true) ?: [
                'Powering Bangladesh\'s development through innovative energy solutions',
                'Ensuring energy security for future generations',
                'Building sustainable infrastructure nationwide'
            ]
        ];

        $vision = [
            'title' => $mvItemsData['vision_title']->section_content ?? 'OUR VISION',
            'description' => $mvItemsData['vision_description']->section_content ?? 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
            'points' => json_decode($mvItemsData['vision_points']->section_content ?? '[]', true) ?: [
                'Regional leadership in sustainable infrastructure development',
                'Global recognition for engineering excellence',
                'Pioneering renewable energy adoption'
            ]
        ];

        return [
            'items' => $mvItemsData,
            'mission' => $mission,
            'vision' => $vision
        ];
    }

    private function loadCoreValues()
    {
        $data = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'core_values')
            ->get()
            ->keyBy('section_item_name');

        $values = [];
        $i = 1;
        while (isset($data["core_value_{$i}"]) && $data["core_value_{$i}"]->section_content) {
            $jsonData = json_decode($data["core_value_{$i}"]->section_content, true);
            if ($jsonData && isset($jsonData['title'])) {
                $values[] = [
                    'id' => $i,
                    'title' => $jsonData['title'] ?? '',
                    'description' => $jsonData['description'] ?? '',
                    'icon' => $jsonData['icon'] ?? '',
                    'order' => $jsonData['order'] ?? $i
                ];
            }
            $i++;
        }

        // If no JSON format items found, check legacy format core_value1, core_value2...
        if (empty($values)) {
            for ($k = 1; $k <= 4; $k++) {
                if (isset($data["core_value{$k}"]) && $data["core_value{$k}"]->section_content) {
                    $valData = json_decode($data["core_value{$k}"]->section_content, true);
                    if ($valData && is_array($valData)) {
                        $values[] = [
                            'id' => $k,
                            'title' => $valData['title'] ?? '',
                            'description' => $valData['description'] ?? '',
                            'icon' => $valData['icon'] ?? '',
                            'order' => $valData['order'] ?? $k
                        ];
                    }
                }
            }
        }

        return [
            'items' => $data,
            'values' => collect($values)->sortBy('order')->values()
        ];
    }

    private function loadJourney()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'journey')
            ->get()
            ->keyBy('section_item_name');

        $milestones = [];
        for ($i = 1; $i <= 6; $i++) {
            $milestoneKey = 'journey_milestone' . $i;
            if (isset($items[$milestoneKey]) && $items[$milestoneKey]->section_content) {
                $milestoneData = json_decode($items[$milestoneKey]->section_content, true);
                if ($milestoneData) {
                    $milestones[] = $milestoneData;
                }
            }
        }

        return [
            'items' => $items,
            'milestones' => collect($milestones)->sortBy('year')->values()
        ];
    }

    private function loadPartners()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'partners')
            ->get()
            ->keyBy('section_item_name');

        $list = [];
        for ($i = 1; $i <= 6; $i++) {
            $partnerKey = 'partner_' . $i;
            if (isset($items[$partnerKey]) && $items[$partnerKey]->section_content) {
                $partnerData = json_decode($items[$partnerKey]->section_content, true);
                if ($partnerData && is_array($partnerData)) {
                    // Ensure each partner has required fields
                    $list[] = [
                        'id' => $partnerData['id'] ?? $i,
                        'order' => $partnerData['order'] ?? $i,
                        'name' => $partnerData['name'] ?? '',
                        'logo' => $partnerData['logo'] ?? ''
                    ];
                }
            }
        }

        return [
            'items' => $items,
            'title' => $items['partners_title']->section_content ?? 'Trusted by Industry Leaders',
            'subtitle' => $items['partners_subtitle']->section_content ?? 'Proud partner to government agencies, multinational corporations, and leading enterprises',
            'list' => collect($list)->sortBy('order')->values()
        ];
    }

    private function loadTestimonials()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'testimonials')
            ->get()
            ->keyBy('section_item_name');

        $testimonials = [];
        for ($i = 1; $i <= 6; $i++) {
            $testimonialKey = 'testimonial' . $i;
            if (isset($items[$testimonialKey]) && $items[$testimonialKey]->section_content) {
                $testimonialData = json_decode($items[$testimonialKey]->section_content, true);
                if ($testimonialData) {
                    $testimonials[] = $testimonialData;
                }
            }
        }

        return [
            'items' => $items,
            'testimonials' => collect($testimonials)->sortBy('order')->values()
        ];
    }

    private function loadContactCta()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'contact_cta')
            ->get()
            ->keyBy('section_item_name');

        return [
            'items' => $items,
            'title' => $items['cta_title']->section_content ?? 'Ready to Start Your Project?',
            'description' => $items['cta_description']->section_content ?? '',
            'button_text' => $items['cta_button_text']->section_content ?? 'Contact Us',
            'button_link' => $items['cta_button_link']->section_content ?? '/contact'
        ];
    }

    private function loadCareerCta()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'career_cta')
            ->get()
            ->keyBy('section_item_name');

        return [
            'items' => $items,
            'title' => $items['cta_title']->section_content ?? 'Join Our Team',
            'description' => $items['cta_description']->section_content ?? '',
            'button_text' => $items['cta_button_text']->section_content ?? 'View Openings',
            'button_link' => $items['cta_button_link']->section_content ?? '/careers'
        ];
    }

    private function loadSubscriptionSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'subscription_section')
            ->get()
            ->keyBy('section_item_name');

        return [
            'title' => $items['subscription_title']->section_content ?? 'Ready to Power Your Success?',
            'description' => $items['subscription_description']->section_content ?? 'Discover how our innovative solutions can transform your business and drive sustainable growth.',
            'button_text' => $items['subscription_button_text']->section_content ?? 'Get Started',
            'button_link' => $items['subscription_button_link']->section_content ?? '/contact'
        ];
    }

    /**
     * Update CMS section data from home page
     */
    public function update(Request $request, $section): JsonResponse
    {
        try {
            switch ($section) {
                case 'brand-statements':
                    return $this->updateBrandStatements($request);
                case 'hero':
                    return $this->updateHeroSection($request);
                case 'mission-vision':
                    return $this->updateMissionVision($request);
                case 'core-values':
                    return $this->updateCoreValues($request);
                case 'partners':
                    return $this->updatePartners($request);
                case 'certifications':
                    return $this->updateCertifications($request);
                case 'journey':
                    return $this->updateJourney($request);
                case 'testimonials':
                    return $this->updateTestimonials($request);
                case 'contact-cta':
                    return $this->updateContactCta($request);
                case 'career-cta':
                    return $this->updateCareerCta($request);
                case 'subscription-section':
                    return $this->updateSubscriptionSectionData($request);
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unknown section: ' . $section
                    ], 400);
            }
        } catch (\Exception $e) {
            \Log::error("Failed to update CMS section: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update brand statements section
     */
    private function updateBrandStatements(Request $request): JsonResponse
    {
        // Handle title update
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_title'
                ],
                [
                    'section_content' => $request->title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle description update
        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle image URL update or file upload
        if ($request->hasFile('brand_image_dropify')) {
            $existingImage = ContentManagement::where('section_name', 'brand_statements_section')
                ->where('section_item_name', 'brand_statements_image')
                ->first();

            $fileName = 'brand_statement_' . Str::random(20);

            if ($existingImage && !empty($existingImage->section_content)) {
                $imageUrl = helpers::updatedFileUpload($existingImage->section_content, $request->file('brand_image_dropify'), 'media', $fileName);
            } else {
                $imageUrl = helpers::fileUpload($request->file('brand_image_dropify'), 'media', $fileName);
            }

            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_image'
                ],
                [
                    'section_content' => $imageUrl,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        } elseif ($request->has('image_url') && !empty($request->image_url)) {
            $imageUrl = $request->image_url;

            // Check if it's a base64 data URL (file upload)
            if (preg_match('/^data:image\/(\w+);base64,/i', $imageUrl)) {
                try {
                    // Extract the image data
                    preg_match('/^data:image\/(\w+);base64,(.+)/i', $imageUrl, $matches);
                    $extension = strtolower($matches[1]);
                    $base64Data = $matches[2];

                    // Validate extension
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                    if (!in_array($extension, $allowedExtensions)) {
                        throw new \Exception("Invalid image format: {$extension}");
                    }

                    // Decode base64 data
                    $imageData = base64_decode($base64Data);

                    if ($imageData === false) {
                        throw new \Exception("Failed to decode image data");
                    }

                    // Validate file size (max 5MB)
                    if (strlen($imageData) > 5 * 1024 * 1024) {
                        throw new \Exception("Image file too large. Maximum size is 5MB.");
                    }

                    // Create directory if it doesn't exist
                    $directory = public_path('uploads/brand-statements');
                    if (!File::exists($directory)) {
                        File::makeDirectory($directory, 0755, true, true);
                    }

                    // Generate unique filename
                    $filename = 'brand-statements-' . time() . '-' . uniqid() . '.' . $extension;
                    $filepath = $directory . '/' . $filename;

                    // Save the file
                    File::put($filepath, $imageData);

                    // Store the public URL in database
                    $imageUrl = '/uploads/brand-statements/' . $filename;

                    \Log::info("Image saved successfully: {$filepath}");
                } catch (\Exception $e) {
                    \Log::error("Failed to process image upload: " . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => "Failed to process image: {$e->getMessage()}"
                    ], 400);
                }
            }

            if (!str_contains($imageUrl, 'AppData') && !str_contains($imageUrl, '.tmp')) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'brand_statements_section',
                        'section_item_name' => 'brand_statements_image'
                    ],
                    [
                        'section_content' => $imageUrl,
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        // Handle overlay title update
        if ($request->has('overlay_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_title'
                ],
                [
                    'section_content' => $request->overlay_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle overlay text update
        if ($request->has('overlay_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_text'
                ],
                [
                    'section_content' => $request->overlay_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle stats updates - support both old format (stat1_value) and new format (stats[1][value])
        if ($request->has('stats')) {
            // New format from edit page: stats[1][value], stats[1][label]
            foreach ($request->input('stats') as $index => $statData) {
                $statValue = $statData['value'] ?? null;
                $statLabel = $statData['label'] ?? null;
                $statOrder = $statData['order'] ?? $index;

                if ($statValue || $statLabel) {
                    $data = [
                        'value' => $statValue,
                        'label' => $statLabel,
                        'order' => $statOrder
                    ];

                    ContentManagement::updateOrCreate(
                        [
                            'section_name' => 'brand_statements_section',
                            'section_item_name' => "brand_statements_stat{$index}"
                        ],
                        [
                            'section_content' => json_encode($data),
                            'attributes' => null,
                            'media_files' => null
                        ]
                    );
                }
            }
        } else {
            // Old format from index page: stat1_value, stat1_label
            for ($i = 1; $i <= 4; $i++) {
                $statValue = $request->input("stat{$i}_value");
                $statLabel = $request->input("stat{$i}_label");

                if ($statValue || $statLabel) {
                    $statData = [
                        'value' => $statValue,
                        'label' => $statLabel,
                        'order' => $i
                    ];

                    ContentManagement::updateOrCreate(
                        [
                            'section_name' => 'brand_statements_section',
                            'section_item_name' => "brand_statements_stat{$i}"
                        ],
                        [
                            'section_content' => json_encode($statData),
                            'attributes' => null,
                            'media_files' => null
                        ]
                    );
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Brand statement updated successfully.'
        ]);
    }

    /**
     * Update hero section
     */
    private function updateHeroSection(Request $request): JsonResponse
    {
        // Handle badge text update
        if ($request->has('badge')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_badge_text', ['section_content' => $request->badge]);
        }

        // Handle title update
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_title', ['section_content' => $request->title]);
        }

        // Handle description update
        if ($request->has('description')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_description', ['section_content' => $request->description]);
        }

        // Handle primary CTA button text update
        if ($request->has('cta_button_text')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_primary_cta_text', ['section_content' => $request->cta_button_text]);
        }

        // Handle primary CTA button link update
        if ($request->has('cta_button_link')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_primary_cta_link', ['section_content' => $request->cta_button_link]);
        }

        // Handle secondary CTA button text update
        if ($request->has('secondary_button_text')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_secondary_cta_text', ['section_content' => $request->secondary_button_text]);
        }

        // Handle secondary CTA button link update
        if ($request->has('secondary_button_link')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_secondary_cta_link', ['section_content' => $request->secondary_button_link]);
        }

        // Handle background image update
        $existingBg = ContentManagement::where('section_name', 'hero_section')
            ->where('section_item_name', 'hero_section_Background')
            ->where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->first();

        $bgImagePath = null;
        if ($existingBg) {
            $bgImagePath = $existingBg->section_content;
            if (!$bgImagePath && $existingBg->media_files) {
                $media = json_decode($existingBg->media_files, true);
                $bgImagePath = $media['source_file'] ?? null;
            }
        }

        if ($request->hasFile('background_image_dropify')) {
            $fileName = 'hero_background_' . Str::random(20);
            if ($bgImagePath) {
                $bgImagePath = helpers::updatedFileUpload($bgImagePath, $request->file('background_image_dropify'), 'media', $fileName);
            } else {
                $bgImagePath = helpers::fileUpload($request->file('background_image_dropify'), 'media', $fileName);
            }
        } elseif ($request->has('background_image') && !empty($request->background_image)) {
            if (!str_contains($request->background_image, 'AppData') && !str_contains($request->background_image, '.tmp')) {
                $bgImagePath = $request->background_image;
            }
        }

        // Handle SEO attributes for background image
        $seoAttributes = $existingBg->attributes ?? null;
        if ($request->has('seo_attributes') && !empty($request->seo_attributes)) {
            $seoAttributes = is_array($request->seo_attributes) ? json_encode($request->seo_attributes) : $request->seo_attributes;
        }

        $this->updateOrCreateSectionItem('hero_section', 'hero_section_Background', [
            'section_content' => $bgImagePath,
            'attributes' => $seoAttributes,
            'media_files' => $bgImagePath ? json_encode(['source_file' => $bgImagePath]) : null
        ]);

        // Handle categories updates
        for ($i = 1; $i <= 4; $i++) {
            $catName = $request->input("cat{$i}_name");
            $catCount = $request->input("cat{$i}_count");
            $catIcon = $request->input("cat{$i}_icon");

            if ($catName !== null || $catCount !== null || $catIcon !== null) {
                $existingCategory = ContentManagement::where('section_name', 'hero_section')
                    ->where('section_item_name', "hero_section_category{$i}")
                    ->where(function ($q) {
                        $q->where('page_name', 'home_page')->orWhereNull('page_name');
                    })
                    ->first();

                $existingData = [];
                if ($existingCategory && $existingCategory->section_content) {
                    $existingData = json_decode($existingCategory->section_content, true) ?: [];
                }

                $catData = [
                    'name' => $catName ?? ($existingData['name'] ?? ''),
                    'count' => $catCount ?? ($existingData['count'] ?? ''),
                    'icon' => $catIcon ?? ($existingData['icon'] ?? ''),
                    'order' => $i
                ];

                $this->updateOrCreateSectionItem('hero_section', "hero_section_category{$i}", [
                    'section_content' => json_encode($catData)
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Hero section updated successfully.'
        ]);
    }

    /**
     * Update Brand Statements
     */
    private function updateBrandStatementSection(Request $request)
    {
        // Handle title update
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_title'
                ],
                [
                    'section_content' => $request->title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle description update
        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle image URL update or file upload
        if ($request->hasFile('brand_image_dropify')) {

            $existingImage = ContentManagement::where('section_name', 'brand_statements_section')
                ->where('section_item_name', 'brand_statements_image')
                ->first();

            $fileName = 'brand_statement_' . Str::random(20);

            if ($existingImage && !empty($existingImage->section_content)) {
                $imageUrl = helpers::updatedFileUpload($existingImage->section_content, $request->file('brand_image_dropify'), 'media', $fileName);
            } else {
                $imageUrl = helpers::fileUpload($request->file('brand_image_dropify'), 'media', $fileName);
            }

            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_image'
                ],
                [
                    'section_content' => $imageUrl,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        } elseif ($request->has('image_url') && !empty($request->image_url)) {
            // Guard against temporary upload file strings being saved directly
            if (!str_contains($request->image_url, 'AppData') && !str_contains($request->image_url, '.tmp')) {
                ContentManagement::updateOrCreate(
                    [
                        'section_name' => 'brand_statements_section',
                        'section_item_name' => 'brand_statements_image'
                    ],
                    [
                        'section_content' => $request->image_url,
                        'attributes' => null,
                        'media_files' => null
                    ]
                );
            }
        }

        // Handle overlay title update
        if ($request->has('overlay_title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_title'
                ],
                [
                    'section_content' => $request->overlay_title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle overlay text update
        if ($request->has('overlay_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'brand_statements_section',
                    'section_item_name' => 'brand_statements_overlay_text'
                ],
                [
                    'section_content' => $request->overlay_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Handle stats updates - support both old format (stat1_value) and new format (stats[1][value])
        if ($request->has('stats')) {
            // New format from edit page: stats[1][value], stats[1][label]
            foreach ($request->input('stats') as $index => $statData) {
                $statValue = $statData['value'] ?? null;
                $statLabel = $statData['label'] ?? null;
                $statOrder = $statData['order'] ?? $index;

                if ($statValue || $statLabel) {
                    $data = [
                        'value' => $statValue,
                        'label' => $statLabel,
                        'order' => $statOrder
                    ];

                    ContentManagement::updateOrCreate(
                        [
                            'section_name' => 'brand_statements_section',
                            'section_item_name' => "brand_statements_stat{$index}"
                        ],
                        [
                            'section_content' => json_encode($data),
                            'attributes' => null,
                            'media_files' => null
                        ]
                    );
                }
            }
        } else {
            // Old format from index page: stat1_value, stat1_label
            for ($i = 1; $i <= 4; $i++) {
                $statValue = $request->input("stat{$i}_value");
                $statLabel = $request->input("stat{$i}_label");

                if ($statValue || $statLabel) {
                    $statData = [
                        'value' => $statValue,
                        'label' => $statLabel,
                        'order' => $i
                    ];

                    ContentManagement::updateOrCreate(
                        [
                            'section_name' => 'brand_statements_section',
                            'section_item_name' => "brand_statements_stat{$i}"
                        ],
                        [
                            'section_content' => json_encode($statData),
                            'attributes' => null,
                            'media_files' => null
                        ]
                    );
                }
            }
        }

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson() || $request->has('_ajax')) {
            return response()->json([
                'success' => true,
                'message' => 'Brand statement updated successfully.'
            ]);
        }

        return redirect()->route('admin.brand-statements.index')
            ->with('success', 'Brand statement updated successfully.');
    }

    /**
     * Update mission vision section
     */
    private function updateMissionVision(Request $request): JsonResponse
    {
        // Handle Mission Update
        if ($request->has('mission')) {
            $mission = $request->mission;
            if (isset($mission['title'])) {
                ContentManagement::updateOrCreate(
                    ['section_name' => 'mission_vision', 'section_item_name' => 'mission_title'],
                    ['section_content' => $mission['title']]
                );
            }
            if (isset($mission['description'])) {
                ContentManagement::updateOrCreate(
                    ['section_name' => 'mission_vision', 'section_item_name' => 'mission_description'],
                    ['section_content' => $mission['description']]
                );
            }

            $missionPoints = array_filter($mission['points'] ?? [], function($p) {
                return !is_null($p) && trim($p) !== '';
            });
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'mission_points'],
                ['section_content' => json_encode(array_values($missionPoints))]
            );
        }

        // Handle Vision Update
        if ($request->has('vision')) {
            $vision = $request->vision;
            if (isset($vision['title'])) {
                ContentManagement::updateOrCreate(
                    ['section_name' => 'mission_vision', 'section_item_name' => 'vision_title'],
                    ['section_content' => $vision['title']]
                );
            }
            if (isset($vision['description'])) {
                ContentManagement::updateOrCreate(
                    ['section_name' => 'mission_vision', 'section_item_name' => 'vision_description'],
                    ['section_content' => $vision['description']]
                );
            }

            $visionPoints = array_filter($vision['points'] ?? [], function($p) {
                return !is_null($p) && trim($p) !== '';
            });
            ContentManagement::updateOrCreate(
                ['section_name' => 'mission_vision', 'section_item_name' => 'vision_points'],
                ['section_content' => json_encode(array_values($visionPoints))]
            );
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Mission & Vision updated successfully.'
        ]);
    }

    /**
     * Update core values section
     */
    private function updateCoreValues(Request $request): JsonResponse
    {
        // Handle deletion from new format
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'delete_value_') === 0 && !empty($value)) {
                $deleteId = (int) $value;

                \Log::info('Deleting core value ID: ' . $deleteId);

                // Get all current core value items in JSON format
                $currentItems = ContentManagement::where(function ($q) {
                        $q->where('page_name', 'home_page')->orWhereNull('page_name');
                    })
                    ->where('section_name', 'core_values')
                    ->where('section_item_name', 'regexp', '^core_value_[0-9]+$')
                    ->get()
                    ->sortBy(function($item) {
                        preg_match('/core_value_(\d+)$/', $item->section_item_name, $matches);
                        return (int)($matches[1] ?? 0);
                    });

                $remainingItems = [];
                foreach ($currentItems as $item) {
                    preg_match('/core_value_(\d+)$/', $item->section_item_name, $matches);
                    $id = (int)($matches[1] ?? 0);

                    if ($id !== $deleteId && $id > 0) {
                        $jsonData = json_decode($item->section_content, true);
                        if ($jsonData) {
                            $remainingItems[] = $jsonData;
                        }
                    }
                }

                // Delete ALL current core_value items to rebuild cleanly
                ContentManagement::where(function ($q) {
                        $q->where('page_name', 'home_page')->orWhereNull('page_name');
                    })
                    ->where('section_name', 'core_values')
                    ->where('section_item_name', 'regexp', '^core_value_[0-9]+$')
                    ->delete();

                // Re-insert remaining items with new indices
                foreach ($remainingItems as $idx => $item) {
                    $newId = $idx + 1;
                    $item['order'] = $newId;
                    $this->updateOrCreateSectionItem('core_values', "core_value_{$newId}", [
                        'section_content' => json_encode($item)
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Core value deleted successfully.'
                ]);
            }
        }

        // Update section title
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('core_values', 'core_values_title', [
                'section_content' => $request->title
            ]);
        }

        // Update section subtitle
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('core_values', 'core_values_subtitle', [
                'section_content' => $request->subtitle
            ]);
        }

        // Update core value items
        if ($request->has('values')) {
            \Log::info('Processing values update', ['values' => $request->values]);

            foreach ($request->values as $id => $val) {
                \Log::info("Processing value ID: {$id}", ['value' => $val]);

                $iconValue = $val['icon'] ?? '';

                $coreValueData = [
                    'title' => $val['title'] ?? '',
                    'description' => $val['description'] ?? '',
                    'icon' => $iconValue,
                    'order' => (int)$id
                ];

                $this->updateOrCreateSectionItem('core_values', "core_value_{$id}", [
                    'section_content' => json_encode($coreValueData)
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Core values updated successfully.'
        ]);
    }

    /**
     * Update partners section
     */
    private function updatePartners(Request $request): JsonResponse
    {
        // 1. Update section title
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('partners', 'partners_title', [
                'section_content' => $request->title
            ]);
        }

        // 2. Update section subtitle
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('partners', 'partners_subtitle', [
                'section_content' => $request->subtitle
            ]);
        }

        // 3. Handle partner deletions
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'delete_partner_') && !empty($value)) {
                $deleteId = (int) str_replace('delete_partner_', '', $key);
                ContentManagement::where('section_name', 'partners')
                    ->where('section_item_name', "partner_{$deleteId}")
                    ->where(function ($q) {
                        $q->where('page_name', 'home_page')->orWhereNull('page_name');
                    })
                    ->delete();
            }
        }

        // 4. Update partners list and clean up old data
        if ($request->has('partners') && is_array($request->partners)) {
            // First, get all existing partner items to clean up later
            $existingPartnerItems = ContentManagement::where('section_name', 'partners')
                ->where('section_item_name', 'regexp', '^partner_[0-9]+$')
                ->where(function ($q) {
                    $q->where('page_name', 'home_page')->orWhereNull('page_name');
                })
                ->get()
                ->keyBy('section_item_name');

            // Process each partner from the form
            $processedIds = [];
            foreach ($request->partners as $id => $partnerData) {
                $partnerName = $partnerData['name'] ?? '';
                $logoUrl = $partnerData['logo'] ?? '';

                // Skip if no data
                if (empty($partnerName) && empty($logoUrl)) {
                    continue;
                }

                // Check if file upload exists in request for this partner
                $dropifyKey = "partner_logo_{$id}_dropify";
                if ($request->hasFile($dropifyKey)) {
                    $file = $request->file($dropifyKey);
                    $fileName = 'partner_logo_' . $id . '_' . Str::random(10);
                    $logoUrl = helpers::fileUpload($file, 'media', $fileName);
                } elseif (preg_match('/^data:image\/(\w+);base64,/i', $logoUrl)) {
                    // Handle base64 image data string from dropify reader
                    try {
                        preg_match('/^data:image\/(\w+);base64,(.+)/i', $logoUrl, $matches);
                        $extension = strtolower($matches[1]);
                        $base64Data = $matches[2];
                        $imageData = base64_decode($base64Data);

                        if ($imageData !== false) {
                            $directory = public_path('uploads/partners');
                            if (!File::exists($directory)) {
                                File::makeDirectory($directory, 0755, true, true);
                            }
                            $filename = 'partner-' . $id . '-' . time() . '-' . uniqid() . '.' . $extension;
                            $filepath = $directory . '/' . $filename;
                            File::put($filepath, $imageData);
                            $logoUrl = '/uploads/partners/' . $filename;
                        }
                    } catch (\Exception $e) {
                        \Log::error("Failed to save base64 partner logo for partner ID {$id}: " . $e->getMessage());
                    }
                }

                // Use sequential storage IDs (1, 2, 3...) instead of form IDs
                $sequentialId = count($processedIds) + 1;
                $processedIds[] = $sequentialId;

                $itemData = [
                    'id' => $sequentialId,
                    'order' => $sequentialId,
                    'name' => $partnerName,
                    'logo' => $logoUrl
                ];

                $this->updateOrCreateSectionItem('partners', "partner_{$sequentialId}", [
                    'section_content' => json_encode($itemData),
                    'attributes' => null,
                    'media_files' => $logoUrl ? json_encode(['source_file' => $logoUrl]) : null
                ]);

                \Log::info("Processed partner: {$sequentialId}", $itemData);
            }

            // Clean up old partner items that are no longer in the form
            foreach ($existingPartnerItems as $itemName => $item) {
                preg_match('/partner_(\d+)$/', $itemName, $matches);
                if ($matches && isset($matches[1])) {
                    $id = (int) $matches[1];
                    if (!in_array($id, $processedIds)) {
                        \Log::info("Cleaning up old partner: {$itemName}");
                        $item->delete();
                    }
                }
            }

            \Log::info("Partners update completed. Total partners: " . count($processedIds));
        }

        return response()->json([
            'success' => true,
            'message' => 'Partners updated successfully.'
        ]);
    }

    /**
     * Load certifications section data
     */
    private function loadCertifications()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'home_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'certifications')
            ->get()
            ->keyBy('section_item_name');

        $certifications = [];
        for ($i = 1; $i <= 12; $i++) {
            $certKey = 'certification_' . $i;
            if (isset($items[$certKey]) && $items[$certKey]->section_content) {
                $certData = json_decode($items[$certKey]->section_content, true);
                if ($certData && is_array($certData)) {
                    $certifications[] = [
                        'id' => $i,
                        'name' => $certData['name'] ?? $certData['title'] ?? '',
                        'title' => $certData['title'] ?? $certData['name'] ?? '',
                        'description' => $certData['description'] ?? '',
                        'icon' => $certData['icon'] ?? '',
                        'order' => $certData['order'] ?? $i
                    ];
                } else {
                    // Handle simple string certifications
                    $certifications[] = [
                        'id' => $i,
                        'name' => $items[$certKey]->section_content,
                        'title' => $items[$certKey]->section_content,
                        'description' => '',
                        'icon' => '',
                        'order' => $i
                    ];
                }
            }
        }

        return [
            'items' => $items,
            'title' => $items['certifications_title']->section_content ?? 'Certifications & Standards',
            'subtitle' => $items['certifications_subtitle']->section_content ?? 'Internationally recognized certifications ensuring quality and safety',
            'certifications' => collect($certifications)->sortBy('order')->values()
        ];
    }

    /**
     * Update certifications section
     */
    private function updateCertifications(Request $request): JsonResponse
    {
        // Update section title
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('certifications', 'certifications_title', [
                'section_content' => $request->title
            ]);
        }

        // Update section subtitle
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('certifications', 'certifications_subtitle', [
                'section_content' => $request->subtitle
            ]);
        }

        // Handle certification deletions
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'delete_certification_') && !empty($value)) {
                $deleteId = (int) str_replace('delete_certification_', '', $key);
                ContentManagement::where('section_name', 'certifications')
                    ->where('section_item_name', "certification_{$deleteId}")
                    ->where(function ($q) {
                        $q->where('page_name', 'home_page')->orWhereNull('page_name');
                    })
                    ->delete();
            }
        }

        // Update certifications list
        if ($request->has('certifications') && is_array($request->certifications)) {
            // Get existing certification items to clean up later
            $existingCertItems = ContentManagement::where('section_name', 'certifications')
                ->where('section_item_name', 'regexp', '^certification_[0-9]+$')
                ->where(function ($q) {
                    $q->where('page_name', 'home_page')->orWhereNull('page_name');
                })
                ->get()
                ->keyBy('section_item_name');

            $processedIds = [];
            foreach ($request->certifications as $id => $certData) {
                $certName = $certData['name'] ?? $certData['title'] ?? '';
                $certTitle = $certData['title'] ?? $certData['name'] ?? '';
                $certDescription = $certData['description'] ?? '';
                $certIcon = $certData['icon'] ?? '';

                // Skip if no data
                if (empty($certName) && empty($certTitle)) {
                    continue;
                }

                // Use sequential storage IDs (1, 2, 3...) instead of form IDs
                $sequentialId = count($processedIds) + 1;
                $processedIds[] = $sequentialId;

                $itemData = [
                    'id' => $sequentialId,
                    'order' => $sequentialId,
                    'name' => $certName ?: $certTitle,
                    'title' => $certTitle ?: $certName,
                    'description' => $certDescription,
                    'icon' => $certIcon
                ];

                $this->updateOrCreateSectionItem('certifications', "certification_{$sequentialId}", [
                    'section_content' => json_encode($itemData),
                    'attributes' => null,
                    'media_files' => null
                ]);

                \Log::info("Processed certification: {$sequentialId}", $itemData);
            }

            // Clean up old certification items that are no longer in the form
            foreach ($existingCertItems as $itemName => $item) {
                preg_match('/certification_(\d+)$/', $itemName, $matches);
                if ($matches && isset($matches[1])) {
                    $id = (int) $matches[1];
                    if (!in_array($id, $processedIds)) {
                        \Log::info("Cleaning up old certification: {$itemName}");
                        $item->delete();
                    }
                }
            }

            \Log::info("Certifications update completed. Total certifications: " . count($processedIds));
        }

        return response()->json([
            'success' => true,
            'message' => 'Certifications updated successfully.'
        ]);
    }

    /**
     * Update journey section
     */
    private function updateJourney(Request $request): JsonResponse
    {
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('journey', 'journey_title', ['section_content' => $request->title]);
        }
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('journey', 'journey_subtitle', ['section_content' => $request->subtitle]);
        }
        if ($request->has('milestones') && is_array($request->milestones)) {
            foreach ($request->milestones as $index => $m) {
                $milestoneData = [
                    'year' => $m['year'] ?? '',
                    'title' => $m['title'] ?? '',
                    'description' => $m['description'] ?? '',
                    'order' => (int)$index
                ];
                $this->updateOrCreateSectionItem('journey', "journey_milestone{$index}", [
                    'section_content' => json_encode($milestoneData)
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Journey updated successfully.'
        ]);
    }

    /**
     * Update testimonials section
     */
    private function updateTestimonials(Request $request): JsonResponse
    {
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('testimonials', 'testimonials_title', ['section_content' => $request->title]);
        }
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('testimonials', 'testimonials_subtitle', ['section_content' => $request->subtitle]);
        }
        if ($request->has('testimonials') && is_array($request->testimonials)) {
            foreach ($request->testimonials as $index => $t) {
                $testimonialData = [
                    'name' => $t['name'] ?? '',
                    'role' => $t['role'] ?? '',
                    'company' => $t['company'] ?? '',
                    'content' => $t['content'] ?? '',
                    'rating' => $t['rating'] ?? 5,
                    'avatar' => $t['avatar'] ?? '',
                    'order' => (int)$index
                ];
                $this->updateOrCreateSectionItem('testimonials', "testimonial{$index}", [
                    'section_content' => json_encode($testimonialData)
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Testimonials updated successfully.'
        ]);
    }

    /**
     * Update contact CTA section
     */
    private function updateContactCta(Request $request): JsonResponse
    {
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('contact_cta', 'cta_title', ['section_content' => $request->title]);
        }
        if ($request->has('description')) {
            $this->updateOrCreateSectionItem('contact_cta', 'cta_description', ['section_content' => $request->description]);
        }
        if ($request->has('button_text')) {
            $this->updateOrCreateSectionItem('contact_cta', 'cta_button_text', ['section_content' => $request->button_text]);
        }
        if ($request->has('button_link')) {
            $this->updateOrCreateSectionItem('contact_cta', 'cta_button_link', ['section_content' => $request->button_link]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Contact CTA updated successfully.'
        ]);
    }

    /**
     * Update career CTA section
     */
    private function updateCareerCta(Request $request): JsonResponse
    {
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('career_cta', 'cta_title', ['section_content' => $request->title]);
        }
        if ($request->has('description')) {
            $this->updateOrCreateSectionItem('career_cta', 'cta_description', ['section_content' => $request->description]);
        }
        if ($request->has('button_text')) {
            $this->updateOrCreateSectionItem('career_cta', 'cta_button_text', ['section_content' => $request->button_text]);
        }
        if ($request->has('button_link')) {
            $this->updateOrCreateSectionItem('career_cta', 'cta_button_link', ['section_content' => $request->button_link]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Career CTA updated successfully.'
        ]);
    }

    /**
     * Update subscription section
     */
    private function updateSubscriptionSectionData(Request $request): JsonResponse
    {
        if ($request->has('subscription_title')) {
            $this->updateOrCreateSectionItem('subscription_section', 'subscription_title', ['section_content' => $request->subscription_title]);
        }
        if ($request->has('subscription_description')) {
            $this->updateOrCreateSectionItem('subscription_section', 'subscription_description', ['section_content' => $request->subscription_description]);
        }
        if ($request->has('subscription_button_text')) {
            $this->updateOrCreateSectionItem('subscription_section', 'subscription_button_text', ['section_content' => $request->subscription_button_text]);
        }
        if ($request->has('subscription_button_link')) {
            $this->updateOrCreateSectionItem('subscription_section', 'subscription_button_link', ['section_content' => $request->subscription_button_link]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Subscription section updated successfully.'
        ]);
    }
}
