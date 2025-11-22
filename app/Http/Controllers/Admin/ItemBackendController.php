<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Type;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemBackendController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by type
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->paginate(6)->withQueryString();

        // Types always available
        $types = Type::all();

        // Categories follow Type
        if ($request->filled('type_id')) {
            $categories = Category::where('type_id', $request->type_id)->get();
        } else {
            $categories = Category::all();
        }

        // Subcategories follow Category
        if ($request->filled('category_id')) {
            $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        } else {
            $subcategories = collect(); // empty until category selected
        }

        return view('admin.items.index', compact(
            'items',
            'types',
            'categories',
            'subcategories'
        ));
    }


    public function create()
    {
        $types = Type::all();
        $categories = Category::all();
        $subcategories = SubCategory::all();

        return view('admin.items.create', compact('types', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:items,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|gte:0',
            'discount' => 'nullable|numeric|gte:0',
            'type_id' => 'required|exists:types,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'sizes' => 'nullable|array',

            // COLORS
            'colors' => 'nullable|array',
            'colors.*.name' => 'nullable|string|max:50',
            'colors.*.stock' => 'nullable|string|max:50',
            'colors.*.code' => 'nullable|string|max:10',
            'colors.*.images' => 'nullable|array',
            'colors.*.images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'status' => 'nullable|boolean',
            'best_sellers' => 'nullable|boolean',
        ]);

        // Auto slug
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        /** HANDLE COLORS */
        $colors = [];
        if (!empty($request->colors)) {
            foreach ($request->colors as $index => $color) {
                $colorData = [
                    'name' => $color['name'] ?? '',
                    'code' => $color['code'] ?? '',
                    'stock' => $color['stock'] ?? '',
                    'images' => [],
                ];

                if ($request->hasFile("colors.$index.images")) {
                    foreach ($request->file("colors.$index.images") as $img) {
                        $upload = cloudinary()->uploadApi()->upload(
                            $img->getRealPath(),
                            [
                                "folder" => "products",
                                "resource_type" => "image"
                            ]
                        );
                        $colorData['images'][] = $upload['secure_url'];
                    }
                }
                $colors[] = $colorData;
            }
        }

        // CREATE ITEM
        Item::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'discount' => $validated['discount'] ?? 0,
            'type_id' => $validated['type_id'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'size' => $request->sizes ?? [],
            'color' => $colors,
            'status' => $request->status ?? false,
            'best_sellers' => $request->best_sellers ?? false,
        ]);

        return redirect()->route('item_backend.index')->with('success', '✅ Item created successfully!');
    }

    /** EDIT */
    public function edit(Item $item_backend)
    {
        $types = Type::all();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.items.edit', compact('item_backend', 'types', 'categories', 'subcategories'));
    }

    public function update(Request $request, Item $item_backend)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:items,slug,' . $item_backend->id,
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|gte:0',
            'discount' => 'nullable|numeric|gte:0',
            'type_id' => 'required|exists:types,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'sizes' => 'nullable|array',

            'colors' => 'nullable|array',
            'colors.*.name' => 'nullable|string|max:50',
            'colors.*.stock' => 'nullable|string|max:50',
            'colors.*.code' => 'nullable|string|max:10',
            'colors.*.existing_images' => 'nullable|array',
            'colors.*.images' => 'nullable|array',
            'colors.*.images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',

            'deleted_images' => 'nullable|array',
            'status' => 'nullable|boolean',
            'best_sellers' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        /** DELETE REMOVED CLOUDINARY IMAGES */
        if ($request->filled('deleted_images')) {
            foreach ($request->deleted_images as $url) {
                // Extract public_id from Cloudinary URL
                $publicId = basename(parse_url($url, PHP_URL_PATH));
                $publicId = explode('.', $publicId)[0];
                cloudinary()->uploadApi()->destroy('products/' . $publicId);
            }
        }

        /** UPDATE COLORS */
        $colors = [];

        if ($request->has('colors')) {
            foreach ($request->colors as $index => $color) {
                $colorData = [
                    'name' => $color['name'] ?? '',
                    'code' => $color['code'] ?? '',
                    'stock' => $color['stock'] ?? '',
                    'images' => $color['existing_images'] ?? [],
                ];

                if ($request->hasFile("colors.$index.images")) {
                    foreach ($request->file("colors.$index.images") as $img) {
                        $upload = cloudinary()->uploadApi()->upload(
                            $img->getRealPath(),
                            ["folder" => "products"]
                        );
                        $colorData['images'][] = $upload['secure_url'];
                    }
                }

                $colors[] = $colorData;
            }
        }

        // UPDATE ITEM
        $item_backend->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'discount' => $validated['discount'] ?? 0,
            'type_id' => $validated['type_id'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'size' => $request->sizes ?? [],
            'color' => $colors,
            'status' => $request->status ?? false,
            'best_sellers' => $request->status ?? false,
        ]);

        // KEEP PAGE
        $queryParams = $request->only(['page']);

        return redirect()->route('item_backend.index', $queryParams)
            ->with('success', '✅ Item updated successfully!');
    }

    /** DELETE ITEM + CLOUDINARY IMAGES */
    public function delete(Request $request, string $id)
    {
        $item = Item::findOrFail($id);

        // DELETE CLOUDINARY IMAGES FOR COLORS
        if ($item->color) {
            foreach ($item->color as $col) {
                if (!empty($col['images'])) {
                    foreach ($col['images'] as $url) {
                        $publicId = basename(parse_url($url, PHP_URL_PATH));
                        $publicId = explode('.', $publicId)[0];
                        cloudinary()->uploadApi()->destroy('products/' . $publicId);
                    }
                }
            }
        }

        $item->delete();

        $queryParams = $request->only(['page']);

        return redirect()->route('item_backend.index', $queryParams)
            ->with('success', '✅ Item deleted successfully!');
    }
}
