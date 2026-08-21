<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AboutPageController extends Controller
{
    /**
     * Display the About page CMS view
     */
    public function index(): View
    {
        $cmsData = $this->loadAllCmsData();
        return view('admin.cms-section.about-page', compact('cmsData'));
    }

    /**
     * Load all CMS section data for About Page
     */
    private function loadAllCmsData(): array
    {
        return [
            'hero' => $this->loadHeroSection(),
            'missionVision' => $this->loadMissionVision(),
            'journey' => $this->loadJourney(),
            'coreValues' => $this->loadCoreValues(),
            'certifications' => $this->loadCertifications(),
            'careerCta' => $this->loadCareerCta(),
        ];
    }

    private function updateOrCreateSectionItem(string $sectionName, string $itemName, array $values): ContentManagement
    {
        $item = ContentManagement::where('section_name', $sectionName)
            ->where('section_item_name', $itemName)
            ->where(function ($q) {
                $q->where('page_name', 'about_page')->orWhereNull('page_name');
            })->first();

        if ($item) {
            $item->update(array_merge(['page_name' => 'about_page'], $values));
            return $item;
        }

        return ContentManagement::create(array_merge([
            'page_name' => 'about_page',
            'section_name' => $sectionName,
            'section_item_name' => $itemName,
        ], $values));
    }

    private function loadHeroSection(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'about_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'hero_section')
            ->get()
            ->keyBy('section_item_name');

        return [
            'badge' => $items['hero_section_badge_text']->section_content ?? 'About Us',
            'title' => $items['hero_section_title']->section_content ?? 'POWERING PROGRESS SINCE 1980',
            'description' => $items['hero_section_description']->section_content ?? 'From humble beginnings to becoming Bangladesh\'s premier engineering conglomerate, our journey reflects four decades of excellence, innovation, and unwavering commitment to national development.',
            'items' => $items
        ];
    }

    private function loadMissionVision(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'about_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'mission_vision')
            ->get()
            ->keyBy('section_item_name');

        $mission = [
            'title' => $items['mission_title']->section_content ?? 'OUR MISSION',
            'description' => $items['mission_description']->section_content ?? 'To deliver reliable, efficient, and sustainable power solutions that drive Bangladesh\'s industrial growth and infrastructure development.',
            'points' => json_decode($items['mission_points']->section_content ?? '[]', true) ?: [
                'Powering Bangladesh\'s development through innovative energy solutions',
                'Ensuring energy security for future generations',
                'Building sustainable infrastructure nationwide'
            ]
        ];

        $vision = [
            'title' => $items['vision_title']->section_content ?? 'OUR VISION',
            'description' => $items['vision_description']->section_content ?? 'To be the leading engineering conglomerate in South Asia, recognized globally for excellence in power infrastructure and renewable energy solutions.',
            'points' => json_decode($items['vision_points']->section_content ?? '[]', true) ?: [
                'Regional leadership in sustainable infrastructure development',
                'Global recognition for engineering excellence',
                'Pioneering renewable energy adoption'
            ]
        ];

        return [
            'items' => $items,
            'mission' => $mission,
            'vision' => $vision
        ];
    }

    private function loadJourney(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'about_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'journey')
            ->get()
            ->keyBy('section_item_name');

        $title = $items['journey_title']->section_content ?? 'Our Journey';
        $subtitle = $items['journey_subtitle']->section_content ?? 'Four decades of excellence in powering Bangladesh\'s development';

        $milestones = [];
        for ($i = 1; $i <= 6; $i++) {
            $milestoneKey = 'journey_milestone' . $i;
            if (isset($items[$milestoneKey]) && $items[$milestoneKey]->section_content) {
                $milestoneData = json_decode($items[$milestoneKey]->section_content, true);
                if ($milestoneData && is_array($milestoneData)) {
                    $milestones[] = [
                        'id' => $i,
                        'year' => $milestoneData['year'] ?? '',
                        'title' => $milestoneData['title'] ?? '',
                        'description' => $milestoneData['description'] ?? '',
                        'order' => $milestoneData['order'] ?? $i
                    ];
                }
            }
        }

        if (empty($milestones)) {
            $milestones = [
                ['id' => 1, 'year' => '1980', 'title' => 'Foundation', 'description' => 'Influx Group established as a small electrical contractor in Dhaka', 'order' => 1],
                ['id' => 2, 'year' => '1995', 'title' => 'Expansion', 'description' => 'Entered power transmission and distribution sector', 'order' => 2],
                ['id' => 3, 'year' => '2005', 'title' => 'Manufacturing', 'description' => 'Started manufacturing transformers and switchgear', 'order' => 3],
                ['id' => 4, 'year' => '2015', 'title' => 'Renewables', 'description' => 'Diversified into solar and wind energy solutions', 'order' => 4],
                ['id' => 5, 'year' => '2020', 'title' => 'EPC Leadership', 'description' => 'Became leading EPC contractor for mega projects', 'order' => 5],
                ['id' => 6, 'year' => '2026', 'title' => 'Regional Hub', 'description' => 'Expanded operations across South Asia', 'order' => 6]
            ];
        }

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'items' => $items,
            'milestones' => collect($milestones)->sortBy('order')->values()
        ];
    }

    private function loadCoreValues(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'about_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'core_values')
            ->get()
            ->keyBy('section_item_name');

        $title = $items['core_values_title']->section_content ?? 'Core Values';
        $subtitle = $items['core_values_subtitle']->section_content ?? 'The principles that guide everything we do';

        $values = [];
        $i = 1;
        while (isset($items["core_value_{$i}"]) && $items["core_value_{$i}"]->section_content) {
            $jsonData = json_decode($items["core_value_{$i}"]->section_content, true);
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

        if (empty($values)) {
            $values = [
                ['id' => 1, 'title' => 'Quality Excellence', 'description' => 'Uncompromising commitment to quality across all engineering solutions.', 'icon' => 'ShieldCheck', 'order' => 1],
                ['id' => 2, 'title' => 'Innovation', 'description' => 'Pioneering modern technology to deliver efficient power infrastructure.', 'icon' => 'Award', 'order' => 2],
                ['id' => 3, 'title' => 'Integrity', 'description' => 'Building trust through honest relationships and ethical business practices.', 'icon' => 'Users', 'order' => 3],
                ['id' => 4, 'title' => 'Sustainability', 'description' => 'Driving green energy adoption for a cleaner environment.', 'icon' => 'TrendingUp', 'order' => 4]
            ];
        }

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'items' => $items,
            'values' => collect($values)->sortBy('order')->values()
        ];
    }

    private function loadCertifications(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'about_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'certifications_section')
            ->get()
            ->keyBy('section_item_name');

        $title = $items['certifications_title']->section_content ?? 'Certifications & Standards';
        $subtitle = $items['certifications_subtitle']->section_content ?? 'Internationally recognized certifications ensuring quality and safety';
        $list = json_decode($items['certifications_list']->section_content ?? '[]', true) ?: [
            'ISO 9001:2015',
            'ISO 14001:2015',
            'ISO 45001:2018',
            'IEC 60076',
            'IEEE Standards',
            'BPDB Approved'
        ];

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'list' => $list,
            'items' => $items
        ];
    }

    private function loadCareerCta(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'about_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'career_cta_section')
            ->get()
            ->keyBy('section_item_name');

        return [
            'title' => $items['career_cta_title']->section_content ?? 'Join Our Mission',
            'description' => $items['career_cta_description']->section_content ?? 'Be part of Bangladesh\'s engineering excellence story',
            'button_text' => $items['career_cta_button_text']->section_content ?? 'Career Opportunities',
            'button_link' => $items['career_cta_button_link']->section_content ?? '/contact',
            'items' => $items
        ];
    }

    /**
     * Update About Page section content
     */
    public function update(Request $request, string $section): JsonResponse
    {
        try {
            switch ($section) {
                case 'hero':
                    return $this->updateHeroSection($request);
                case 'mission-vision':
                    return $this->updateMissionVision($request);
                case 'journey':
                    return $this->updateJourney($request);
                case 'core-values':
                    return $this->updateCoreValues($request);
                case 'certifications':
                    return $this->updateCertifications($request);
                case 'career-cta':
                    return $this->updateCareerCta($request);
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unknown section: ' . $section
                    ], 400);
            }
        } catch (\Exception $e) {
            Log::error("Failed to update About Page section ({$section}): " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update section: ' . $e->getMessage()
            ], 500);
        }
    }

    private function updateHeroSection(Request $request): JsonResponse
    {
        if ($request->has('badge')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_badge_text', ['section_content' => $request->badge]);
        }
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_title', ['section_content' => $request->title]);
        }
        if ($request->has('description')) {
            $this->updateOrCreateSectionItem('hero_section', 'hero_section_description', ['section_content' => $request->description]);
        }

        return response()->json(['success' => true, 'message' => 'About Hero section updated successfully.']);
    }

    private function updateMissionVision(Request $request): JsonResponse
    {
        if ($request->has('mission_title')) {
            $this->updateOrCreateSectionItem('mission_vision', 'mission_title', ['section_content' => $request->mission_title]);
        }
        if ($request->has('mission_description')) {
            $this->updateOrCreateSectionItem('mission_vision', 'mission_description', ['section_content' => $request->mission_description]);
        }
        if ($request->has('mission_points')) {
            $points = is_array($request->mission_points) ? array_filter($request->mission_points) : array_filter(explode("\n", $request->mission_points));
            $this->updateOrCreateSectionItem('mission_vision', 'mission_points', ['section_content' => json_encode(array_values($points))]);
        }

        if ($request->has('vision_title')) {
            $this->updateOrCreateSectionItem('mission_vision', 'vision_title', ['section_content' => $request->vision_title]);
        }
        if ($request->has('vision_description')) {
            $this->updateOrCreateSectionItem('mission_vision', 'vision_description', ['section_content' => $request->vision_description]);
        }
        if ($request->has('vision_points')) {
            $points = is_array($request->vision_points) ? array_filter($request->vision_points) : array_filter(explode("\n", $request->vision_points));
            $this->updateOrCreateSectionItem('mission_vision', 'vision_points', ['section_content' => json_encode(array_values($points))]);
        }

        return response()->json(['success' => true, 'message' => 'Mission & Vision section updated successfully.']);
    }

    private function updateJourney(Request $request): JsonResponse
    {
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('journey', 'journey_title', ['section_content' => $request->title]);
        }
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('journey', 'journey_subtitle', ['section_content' => $request->subtitle]);
        }

        for ($i = 1; $i <= 6; $i++) {
            if ($request->has("milestone_{$i}_year")) {
                $milestoneData = [
                    'year' => $request->input("milestone_{$i}_year"),
                    'title' => $request->input("milestone_{$i}_title", ''),
                    'description' => $request->input("milestone_{$i}_description", ''),
                    'order' => $i
                ];
                $this->updateOrCreateSectionItem('journey', 'journey_milestone' . $i, ['section_content' => json_encode($milestoneData)]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Journey section updated successfully.']);
    }

    private function updateCoreValues(Request $request): JsonResponse
    {
        $MAX_VALUES = 4;

        // Handle deletion from new format
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'delete_value_') === 0 && !empty($value)) {
                $deleteId = (int) $value;

                \Log::info('Deleting core value ID: ' . $deleteId);

                // Get all current core value items in JSON format
                $currentItems = ContentManagement::where('section_name', 'core_values')
                    ->where('section_item_name', 'regexp', '^core_value_[0-9]+$')
                    ->where(function ($q) {
                        $q->where('page_name', 'about_page')->orWhereNull('page_name');
                    })
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
                ContentManagement::where('section_name', 'core_values')
                    ->where('section_item_name', 'regexp', '^core_value_[0-9]+$')
                    ->where(function ($q) {
                        $q->where('page_name', 'about_page')->orWhereNull('page_name');
                    })
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
            $this->updateOrCreateSectionItem('core_values', 'core_values_title', ['section_content' => $request->title]);
        }

        // Update section subtitle
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('core_values', 'core_values_subtitle', ['section_content' => $request->subtitle]);
        }

        // Update core value items with maximum limit enforcement
        if ($request->has('values')) {
            \Log::info('Processing values update', ['values' => $request->values]);

            $valuesCount = count($request->values);
            if ($valuesCount > $MAX_VALUES) {
                return response()->json([
                    'success' => false,
                    'message' => "Maximum {$MAX_VALUES} core values allowed. You have provided {$valuesCount} values."
                ], 400);
            }

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

        return response()->json(['success' => true, 'message' => 'Core Values updated successfully.']);
    }

    private function updateCertifications(Request $request): JsonResponse
    {
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('certifications_section', 'certifications_title', ['section_content' => $request->title]);
        }
        if ($request->has('subtitle')) {
            $this->updateOrCreateSectionItem('certifications_section', 'certifications_subtitle', ['section_content' => $request->subtitle]);
        }
        if ($request->has('certifications')) {
            $certs = is_array($request->certifications) ? array_filter($request->certifications) : array_filter(explode("\n", $request->certifications));
            $this->updateOrCreateSectionItem('certifications_section', 'certifications_list', ['section_content' => json_encode(array_values($certs))]);
        }

        return response()->json(['success' => true, 'message' => 'Certifications updated successfully.']);
    }

    private function updateCareerCta(Request $request): JsonResponse
    {
        if ($request->has('title')) {
            $this->updateOrCreateSectionItem('career_cta_section', 'career_cta_title', ['section_content' => $request->title]);
        }
        if ($request->has('description')) {
            $this->updateOrCreateSectionItem('career_cta_section', 'career_cta_description', ['section_content' => $request->description]);
        }
        if ($request->has('button_text')) {
            $this->updateOrCreateSectionItem('career_cta_section', 'career_cta_button_text', ['section_content' => $request->button_text]);
        }
        if ($request->has('button_link')) {
            $this->updateOrCreateSectionItem('career_cta_section', 'career_cta_button_link', ['section_content' => $request->button_link]);
        }

        return response()->json(['success' => true, 'message' => 'Career CTA updated successfully.']);
    }
}
