<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = SubCategory::query();

        // Filter by type
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $subcategories = $query->orderBy('created_at', 'asc')->get();

        // Get types for dropdown
        $types = Type::all();

        // If type is selected, show only categories for that type
        if ($request->filled('type_id')) {
            $categories = Category::whereHas('subcategories', function ($q) use ($request) {
                $q->where('type_id', $request->type_id);
            })->get();
        } else {
            $categories = Category::all();
        }

        return view('admin.subcategories.index', compact('subcategories', 'types', 'categories'));
    }

    public function create()
    {
        $types = Type::all();
        $categories = Category::all();

        return view('admin.subcategories.create', compact('types', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:items,slug',
            'type_id' => 'required|exists:types,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Auto slug
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        // CREATE ITEM
        SubCategory::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'type_id' => $validated['type_id'],
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('subcategory.index')->with('success', '✅ Created successfully!');
    }

    public function edit(SubCategory $subcategory)
    {
        $types = Type::all();
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'types', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:items,slug,' . $subcategory->id,
            'type_id' => 'required|exists:types,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $subcategory->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'type_id' => $validated['type_id'],
            'category_id' => $validated['category_id'],
        ]);

        // KEEP PAGE
        $queryParams = $request->only(['page']);

        return redirect()->route('category.index', $queryParams)
            ->with('success', '✅ Updated successfully!');
    }

    public function delete(Request $request, string $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $subcategory->delete();

        $queryParams = $request->only(['page']);

        return redirect()->route('subcategory.index', $queryParams)
            ->with('success', '✅ Deleted successfully!');
    }
}
