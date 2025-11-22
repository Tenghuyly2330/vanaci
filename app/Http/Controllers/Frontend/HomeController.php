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
        // Load essential data
        $types = Type::select('id', 'type', 'slug')->get();
        $categories = Category::orderBy('created_at', 'asc')->get();

        // Fetch random items
        $items = Item::with(['category', 'type'])
            ->orderBy('created_at', 'asc')
            ->take(12)
            ->get()
            ->map(function ($item) {

                // Decode color JSON
                $colors = is_array($item->color)
                    ? $item->color
                    : json_decode($item->color ?? '[]', true);

                if (!is_array($colors)) {
                    $colors = [];
                }

                // Decode sizes JSON
                $sizes = is_array($item->size)
                    ? $item->size
                    : json_decode($item->size ?? '[]', true);

                if (!is_array($sizes)) {
                    $sizes = [];
                }

                // Keep full structure exactly as the view expects
                $item->color = $colors;
                $item->size = $sizes;

                return $item;
            });

        return view('frontend.home', compact('types', 'categories', 'items'));
    }
}
