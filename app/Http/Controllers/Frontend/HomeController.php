<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Item;
use App\Models\Type;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // 🔹 Load essential data
        $types = Type::select('id', 'type', 'slug')->get();
        $categories = Category::all();

        // 🔹 Fetch random items with relationships
        $items = Item::with(['category', 'type'])
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(function ($item) {
                // ✅ Decode colors safely
                $colors = is_array($item->color)
                    ? $item->color
                    : json_decode($item->color ?? '[]', true);

                if (!is_array($colors)) {
                    $colors = [];
                }

                $firstColor = $colors[0] ?? [];
                $firstName = $firstColor['name'] ?? null;
                $firstImage = $firstColor['images'][0] ?? null;

                // ✅ Decode sizes safely
                $sizes = is_array($item->size)
                    ? $item->size
                    : json_decode($item->size ?? '[]', true);

                if (!is_array($sizes) || empty($sizes)) {
                    $sizes = [];
                }

                // ✅ Return clean structured data
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'slug' => $item->slug,
                    'image' => $firstImage ? asset($firstImage) : asset('assets/images/default.jpg'),
                    'price' => (float) $item->price,
                    'discount' => (float) ($item->discount ?? 0),
                    'sizes' => $sizes,
                    'status' => (bool) ($item->status ?? false),
                    'color' => $firstName,
                    'type' => $item->type->slug,
                ];
            });

        return view('frontend.home', compact('types', 'categories', 'items'));
    }
}
