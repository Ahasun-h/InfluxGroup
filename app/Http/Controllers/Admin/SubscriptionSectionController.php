<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionSectionController extends Controller
{
    /**
     * Display the Subscription Section management page
     */
    public function index(): View
    {
        // Get or create subscription section content
        $title = ContentManagement::firstOrCreate(
            [
                'section_name' => 'subscription_section',
                'section_item_name' => 'subscription_title'
            ],
            [
                'section_content' => 'Ready to Power Your Success?',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $description = ContentManagement::firstOrCreate(
            [
                'section_name' => 'subscription_section',
                'section_item_name' => 'subscription_description'
            ],
            [
                'section_content' => 'Discover how our innovative solutions can transform your business and drive sustainable growth.',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $buttonText = ContentManagement::firstOrCreate(
            [
                'section_name' => 'subscription_section',
                'section_item_name' => 'subscription_button_text'
            ],
            [
                'section_content' => 'Get Started',
                'attributes' => null,
                'media_files' => null
            ]
        );

        $buttonLink = ContentManagement::firstOrCreate(
            [
                'section_name' => 'subscription_section',
                'section_item_name' => 'subscription_button_link'
            ],
            [
                'section_content' => '/contact',
                'attributes' => null,
                'media_files' => null
            ]
        );

        // Fetch all subscription section items
        $data = ContentManagement::where('section_name', 'subscription_section')
            ->get()
            ->keyBy('section_item_name');

        $content = [
            'title' => $data['subscription_title']->section_content ?? 'Ready to Power Your Success?',
            'description' => $data['subscription_description']->section_content ?? 'Discover how our innovative solutions can transform your business and drive sustainable growth.',
            'button_text' => $data['subscription_button_text']->section_content ?? 'Get Started',
            'button_link' => $data['subscription_button_link']->section_content ?? '/contact',
        ];

        return view('admin.cms-section.subscription-section', compact('content'));
    }

    /**
     * Update the Subscription Section
     */
    public function update(Request $request): RedirectResponse
    {
        // Update title
        if ($request->has('title')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'subscription_section',
                    'section_item_name' => 'subscription_title'
                ],
                [
                    'section_content' => $request->title,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update description
        if ($request->has('description')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'subscription_section',
                    'section_item_name' => 'subscription_description'
                ],
                [
                    'section_content' => $request->description,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update button text
        if ($request->has('button_text')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'subscription_section',
                    'section_item_name' => 'subscription_button_text'
                ],
                [
                    'section_content' => $request->button_text,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Update button link
        if ($request->has('button_link')) {
            ContentManagement::updateOrCreate(
                [
                    'section_name' => 'subscription_section',
                    'section_item_name' => 'subscription_button_link'
                ],
                [
                    'section_content' => $request->button_link,
                    'attributes' => null,
                    'media_files' => null
                ]
            );
        }

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription section updated successfully.'
            ]);
        }

        return redirect()->route('admin.subscription-section.index')
            ->with('success', 'Subscription section updated successfully.');
    }
}
