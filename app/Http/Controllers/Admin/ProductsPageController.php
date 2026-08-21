<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ProductsPageController extends Controller
{
    public function index(): View
    {
        $cmsData = $this->loadAllCmsData();
        return view('admin.cms-section.products-page', compact('cmsData'));
    }

    private function loadAllCmsData(): array
    {
        return [
            'hero' => $this->loadHeroSection(),
        ];
    }

    private function updateOrCreate(string $sectionName, string $itemName, array $values): ContentManagement
    {
        $item = ContentManagement::where('section_name', $sectionName)
            ->where('section_item_name', $itemName)
            ->where(function ($q) {
                $q->where('page_name', 'products_page')->orWhereNull('page_name');
            })->first();

        if ($item) {
            $item->update(array_merge(['page_name' => 'products_page'], $values));
            return $item;
        }

        return ContentManagement::create(array_merge([
            'page_name'         => 'products_page',
            'section_name'      => $sectionName,
            'section_item_name' => $itemName,
        ], $values));
    }

    private function loadHeroSection(): array
    {
        $items = ContentManagement::where(function ($q) {
                $q->where('page_name', 'products_page')->orWhereNull('page_name');
            })
            ->where('section_name', 'products_hero')
            ->get()
            ->keyBy('section_item_name');

        return [
            'badge'       => $items['products_hero_badge']->section_content       ?? 'Our Products',
            'title'       => $items['products_hero_title']->section_content       ?? 'ENGINEERING <span class="text-industrial-blue">EXCELLENCE</span>',
            'description' => $items['products_hero_description']->section_content ?? 'Comprehensive portfolio of power systems and equipment designed for reliability, efficiency, and sustainability.',
        ];
    }

    public function update(Request $request, string $section): JsonResponse
    {
        try {
            switch ($section) {
                case 'hero':
                    return $this->updateHeroSection($request);
                default:
                    return response()->json(['success' => false, 'message' => 'Unknown section: ' . $section], 400);
            }
        } catch (\Exception $e) {
            Log::error("Failed to update Products Page section ({$section}): " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update section: ' . $e->getMessage()], 500);
        }
    }

    private function updateHeroSection(Request $request): JsonResponse
    {
        if ($request->has('badge')) {
            $this->updateOrCreate('products_hero', 'products_hero_badge', ['section_content' => $request->badge]);
        }
        if ($request->has('title')) {
            $this->updateOrCreate('products_hero', 'products_hero_title', ['section_content' => $request->title]);
        }
        if ($request->has('description')) {
            $this->updateOrCreate('products_hero', 'products_hero_description', ['section_content' => $request->description]);
        }

        return response()->json(['success' => true, 'message' => 'Products Hero section updated successfully.']);
    }
}
