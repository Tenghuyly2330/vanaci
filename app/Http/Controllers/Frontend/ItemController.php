<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Type;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $types = Type::all();
        $categories = Category::all();

        // ✅ Always eager-load type for filtering
        $itemsQuery = Item::with('type');
        $typeName = null;
        $categoryName = null;
        $type = null;
        $category = null;

        // 🔹 Type filter
        if ($request->type) {
            $type = Type::where('slug', $request->type)->first();
            if ($type) {
                $itemsQuery->where('type_id', $type->id);
                $typeName = $type->type;

                // 🔹 Category filter (optional)
                if ($request->category) {
                    $category = Category::where('slug', $request->category)
                        ->where('type_id', $type->id)
                        ->first();

                    if ($category) {
                        $itemsQuery->where('category_id', $category->id);
                        $categoryName = $category->name;
                    }
                }
            }
        }

        // 🔹 "New Arrivals" filter
        if ($request->filter === 'new') {
            $itemsQuery->where('status', true);

            if (!$type && !$category) {
                $typeName = 'New Arrivals';
            } elseif ($type && !$category) {
                $typeName = "{$type->type} - New Arrivals";
            } elseif ($type && $category) {
                $typeName = "{$type->type} - New Arrivals";
                $categoryName = $category->name ?? null;
            }
        }

        $items = $itemsQuery->get()->map(function ($item) {

            $colors = is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true);
            $firstColor = $colors[0] ?? null;
            $firstImage = $firstColor['images'][0] ?? null;

            return (object) [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'price' => $item->price,
                'discount' => $item->discount,
                'status' => $item->status,
                'image' => $firstImage ?? 'assets/images/default.jpg',
                'type' => $item->type,
                'size' => is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true),
                'color' => is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true),
            ];
        });

        return view('frontend.item', compact(
            'items',
            'types',
            'categories',
            'typeName',
            'categoryName'
        ));
    }

    public function show($slug)
    {
        $types = Type::all();
        $categories = Category::all();

        // ✅ Get main item
        $item = Item::with('type')->where('slug', $slug)->firstOrFail();

        // ✅ Decode JSON fields safely
        $item->color = is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true);
        $item->size = is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true);

        $firstColor = $item->color[0] ?? null;
        $item->image = $firstColor['images'][0] ?? 'assets/images/default.jpg';

        // ✅ Related items (same category, exclude itself)
        $relatedItems = Item::with('type')
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->inRandomOrder()
            ->take(12)
            ->get()
            ->map(function ($related) {
                $colors = is_array($related->color) ? $related->color : json_decode($related->color ?? '[]', true);
                $firstColor = $colors[0] ?? null;
                $firstImage = $firstColor['images'][0] ?? null;

                return (object) [
                    'id' => $related->id,
                    'name' => $related->name,
                    'slug' => $related->slug,
                    'price' => $related->price,
                    'discount' => $related->discount,
                    'status' => $related->status,
                    'image' => $firstImage ?? 'assets/images/default.jpg',
                    'type' => $related->type,
                    'size' => is_array($related->size) ? $related->size : json_decode($related->size ?? '[]', true),
                    'color' => $colors,
                ];
            });

        // ✅ Optional: show some random products like index
        $items = Item::with('type')
            ->inRandomOrder()
            ->take(12)
            ->get()
            ->map(function ($random) {
                $colors = is_array($random->color)
                    ? $random->color
                    : json_decode($random->color ?? '[]', true);

                $firstColor = $colors[0] ?? null;
                $firstImage = $firstColor['images'][0] ?? null;

                // ✅ Fix relative path issue
                if ($firstImage && !str_starts_with($firstImage, '/')) {
                    $firstImage = '/' . ltrim($firstImage, '/');
                }

                return (object) [
                    'id' => $random->id,
                    'name' => $random->name,
                    'slug' => $random->slug,
                    'price' => $random->price,
                    'discount' => $random->discount,
                    'status' => $random->status,
                    'image' => $firstImage ?? 'assets/images/default.jpg',
                    'type' => $random->type,
                    'size' => is_array($random->size)
                        ? $random->size
                        : json_decode($random->size ?? '[]', true),
                    'color' => $colors,
                ];
            });


        return view('frontend.show', compact(
            'item',
            'items',
            'categories',
            'types',
            'relatedItems'
        ));
    }
}
