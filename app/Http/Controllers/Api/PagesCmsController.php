<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;

class PagesCmsController extends Controller
{
    // ── Products Page ────────────────────────────────────────────────────

    public function getProductsHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'products_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'products_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['products_hero_badge']->section_content       ?? 'Our Products',
                'title'       => $items['products_hero_title']->section_content       ?? 'ENGINEERING <span class="text-industrial-blue">EXCELLENCE</span>',
                'description' => $items['products_hero_description']->section_content ?? 'Comprehensive portfolio of power systems and equipment designed for reliability, efficiency, and sustainability.',
            ]
        ]);
    }

    // ── Projects Page ────────────────────────────────────────────────────

    public function getProjectsHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'projects_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'projects_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['projects_hero_badge']->section_content       ?? 'Our Projects',
                'title'       => $items['projects_hero_title']->section_content       ?? 'BUILDING <span class="text-industrial-blue">BANGLADESH</span>',
                'description' => $items['projects_hero_description']->section_content ?? 'From mega power projects to renewable energy installations, we deliver engineering excellence that powers the nation.',
            ]
        ]);
    }

    // ── Services & Solutions Page ────────────────────────────────────────

    public function getServicesHeroSection()
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'services_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'services_hero')
            ->get()
            ->keyBy('section_item_name');

        return response()->json([
            'success' => true,
            'data' => [
                'badge'       => $items['services_hero_badge']->section_content       ?? 'What We Offer',
                'title'       => $items['services_hero_title']->section_content       ?? 'SERVICES &amp; <span class="text-industrial-blue">SOLUTIONS</span>',
                'description' => $items['services_hero_description']->section_content ?? 'Comprehensive engineering services and tailored solutions from concept to commissioning, ensuring your power infrastructure operates at peak performance.',
            ]
        ]);
    }
}
