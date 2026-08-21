<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display the contact section management page
     */
    public function index(): View
    {
        $cmsData = $this->loadAllCmsData();
        return view('admin.cms-section.contact-section', compact('cmsData'));
    }

    /**
     * Load all CMS section data for Contact Page
     */
    private function loadAllCmsData(): array
    {
        $contactItems = ContentManagement::where('section_name', 'contact_section')
            ->get()
            ->keyBy('section_item_name');

        // Hero section
        $hero = [
            'badge' => $contactItems['contact_hero_badge']->section_content ?? 'Contact Us',
            'title' => $contactItems['contact_hero_title']->section_content ?? 'GET IN TOUCH',
            'description' => $contactItems['contact_hero_description']->section_content ?? 'Ready to discuss your next project? Contact our team for expert consultation and solutions.',
        ];

        // Contact info
        $info = [
            'phone_1' => $contactItems['contact_phone_1']->section_content ?? '+880 2 987 6543',
            'phone_2' => $contactItems['contact_phone_2']->section_content ?? '+880 1XXX-XXXXXX',
            'email_1' => $contactItems['contact_email_1']->section_content ?? 'info@influxgroup.com',
            'email_2' => $contactItems['contact_email_2']->section_content ?? 'sales@influxgroup.com',
            'office_hours_weekdays' => $contactItems['contact_office_hours_weekdays']->section_content ?? 'Saturday - Thursday: 9:00 AM - 6:00 PM',
            'office_hours_friday' => $contactItems['contact_office_hours_friday']->section_content ?? 'Friday: Closed',
        ];

        // Office locations
        $offices = [];
        for ($i = 1; $i <= 10; $i++) {
            $officeKey = 'contact_office_' . $i;
            if (isset($contactItems[$officeKey]) && $contactItems[$officeKey]->section_content) {
                $officeData = json_decode($contactItems[$officeKey]->section_content, true);
                if ($officeData && isset($officeData['city'])) {
                    $offices[] = $officeData;
                }
            }
        }
        if (empty($offices)) {
            $offices = [
                ['order' => 1, 'city' => 'Dhaka', 'type' => 'Corporate Headquarters', 'address' => 'Level 12, Energy Plaza, Tejgaon I/A', 'phone' => '+880 2 987 6543', 'email' => 'dhaka@influxgroup.com'],
                ['order' => 2, 'city' => 'Chittagong', 'type' => 'Regional Office', 'address' => 'Plot 45, GEC Circle, Nasirabad', 'phone' => '+880 31 654 321', 'email' => 'ctg@influxgroup.com']
            ];
        }

        // Map embed URL
        $map = [
            'embed_url' => $contactItems['contact_map_embed_url']->section_content ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.3832277878897!2d90.4125!3d23.8104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDQ4JzM3LjQiTiA5MMKwMjQnNDUuMCJF!5e0!3m2!1sen!2sbd!4v1620000000000!5m2!1sen!2sbd',
        ];

        // Emergency section
        $emergency = [
            'title' => $contactItems['emergency_title']->section_content ?? 'Emergency <span class="text-industrial-red">Support</span>',
            'description' => $contactItems['emergency_description']->section_content ?? '24/7 emergency support available for critical power infrastructure issues',
            'primary_text' => $contactItems['emergency_primary_text']->section_content ?? 'Emergency Line',
            'primary_link' => $contactItems['emergency_primary_link']->section_content ?? 'tel:+88029876543',
            'secondary_text' => $contactItems['emergency_secondary_text']->section_content ?? 'Email Support',
            'secondary_link' => $contactItems['emergency_secondary_link']->section_content ?? 'mailto:support@influxgroup.com',
        ];

        return [
            'hero' => $hero,
            'info' => $info,
            'offices' => collect($offices)->sortBy('order')->values(),
            'map' => $map,
            'emergency' => $emergency,
            'items' => $contactItems
        ];
    }

    /**
     * Update Contact Page section via AJAX
     */
    public function updateSection(Request $request, string $section): JsonResponse
    {
        try {
            switch ($section) {
                case 'hero':
                    return $this->updateHero($request);
                case 'info':
                    return $this->updateInfo($request);
                case 'offices':
                    return $this->updateOffices($request);
                case 'map':
                    return $this->updateMap($request);
                case 'emergency':
                    return $this->updateEmergency($request);
                default:
                    return response()->json(['success' => false, 'message' => 'Unknown section: ' . $section], 400);
            }
        } catch (\Exception $e) {
            Log::error("Failed to update Contact section ({$section}): " . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function updateOrCreateItem(string $itemName, string $content): void
    {
        ContentManagement::updateOrCreate(
            ['section_name' => 'contact_section', 'section_item_name' => $itemName],
            ['section_content' => $content, 'attributes' => null, 'media_files' => null]
        );
    }

    private function updateHero(Request $request): JsonResponse
    {
        if ($request->has('badge')) $this->updateOrCreateItem('contact_hero_badge', $request->badge);
        if ($request->has('title')) $this->updateOrCreateItem('contact_hero_title', $request->title);
        if ($request->has('description')) $this->updateOrCreateItem('contact_hero_description', $request->description);

        return response()->json(['success' => true, 'message' => 'Contact Hero section updated successfully.']);
    }

    private function updateInfo(Request $request): JsonResponse
    {
        if ($request->has('phone_1')) $this->updateOrCreateItem('contact_phone_1', $request->phone_1);
        if ($request->has('phone_2')) $this->updateOrCreateItem('contact_phone_2', $request->phone_2);
        if ($request->has('email_1')) $this->updateOrCreateItem('contact_email_1', $request->email_1);
        if ($request->has('email_2')) $this->updateOrCreateItem('contact_email_2', $request->email_2);
        if ($request->has('office_hours_weekdays')) $this->updateOrCreateItem('contact_office_hours_weekdays', $request->office_hours_weekdays);
        if ($request->has('office_hours_friday')) $this->updateOrCreateItem('contact_office_hours_friday', $request->office_hours_friday);

        return response()->json(['success' => true, 'message' => 'Contact Information updated successfully.']);
    }

    private function updateOffices(Request $request): JsonResponse
    {
        if ($request->has('deleted_offices') && $request->deleted_offices) {
            $deletedIds = explode(',', $request->deleted_offices);
            foreach ($deletedIds as $id) {
                ContentManagement::where('section_name', 'contact_section')
                    ->where('section_item_name', 'contact_office_' . trim($id))
                    ->delete();
            }
        }

        for ($i = 1; $i <= 10; $i++) {
            $city = $request->input("office_{$i}_city");
            if ($city) {
                $officeData = [
                    'city' => $city,
                    'type' => $request->input("office_{$i}_type", ''),
                    'address' => $request->input("office_{$i}_address", ''),
                    'phone' => $request->input("office_{$i}_phone", ''),
                    'email' => $request->input("office_{$i}_email", ''),
                    'order' => $i
                ];
                $this->updateOrCreateItem("contact_office_{$i}", json_encode($officeData));
            }
        }

        return response()->json(['success' => true, 'message' => 'Office locations updated successfully.']);
    }

    private function updateMap(Request $request): JsonResponse
    {
        if ($request->has('map_embed_url')) {
            $this->updateOrCreateItem('contact_map_embed_url', $request->map_embed_url);
        }
        return response()->json(['success' => true, 'message' => 'Google Map location updated successfully.']);
    }

    private function updateEmergency(Request $request): JsonResponse
    {
        if ($request->has('emergency_title')) $this->updateOrCreateItem('emergency_title', $request->emergency_title);
        if ($request->has('emergency_description')) $this->updateOrCreateItem('emergency_description', $request->emergency_description);
        if ($request->has('emergency_primary_text')) $this->updateOrCreateItem('emergency_primary_text', $request->emergency_primary_text);
        if ($request->has('emergency_primary_link')) $this->updateOrCreateItem('emergency_primary_link', $request->emergency_primary_link);
        if ($request->has('emergency_secondary_text')) $this->updateOrCreateItem('emergency_secondary_text', $request->emergency_secondary_text);
        if ($request->has('emergency_secondary_link')) $this->updateOrCreateItem('emergency_secondary_link', $request->emergency_secondary_link);

        return response()->json(['success' => true, 'message' => 'Emergency support section updated successfully.']);
    }

    /**
     * Fallback traditional update route
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->has('section')) {
            $this->updateSection($request, $request->section);
        } else {
            $this->updateInfo($request);
            $this->updateMap($request);
            $this->updateEmergency($request);
            $this->updateOffices($request);
        }

        return redirect()->route('admin.cms-section.contact-section')
            ->with('success', 'Contact section updated successfully.');
    }
}
