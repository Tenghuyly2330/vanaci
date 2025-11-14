<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Item;
use App\Models\Type;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $types = Type::all();
        $categories = Category::all();

        // ✅ Eager-load type for filtering
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

        // ✅ Get items ordered by oldest first
        $items = $itemsQuery
            ->orderBy('created_at', 'asc') // 👈 oldest first
            ->get()
            ->map(function ($item) {
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
                    'created_at' => $item->created_at,
                ];
            });

        // ✅ Group items by type name (MEN, WOMEN, etc.)
        $groupedItems = $items->groupBy(fn($item) => $item->type->type ?? 'Other');

        // ✅ Preserve Type order and sort each group by oldest first
        $orderedGroupedItems = collect();
        foreach ($types as $type) {
            if ($groupedItems->has($type->type)) {
                $orderedGroupedItems->put($type->type, $groupedItems[$type->type]->sortBy('created_at')); // 👈 ascending
            }
        }

        // Add any leftover “Other” types
        foreach ($groupedItems as $key => $group) {
            if (!$orderedGroupedItems->has($key)) {
                $orderedGroupedItems->put($key, $group->sortBy('created_at'));
            }
        }

        return view('frontend.explore', compact(
            'orderedGroupedItems',
            'types',
            'categories',
            'typeName',
            'categoryName'
        ));
    }
}
