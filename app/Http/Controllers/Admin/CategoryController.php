<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::join('types', 'categories.type_id', '=', 'types.id')
            ->select('categories.*', 'types.type as type_name');

        // Filter by type if type_id is present
        if ($request->has('type_id') && $request->type_id != '') {
            $query->where('categories.type_id', $request->type_id);
        }

        // Pagination (10 per page)
        // $data['categories'] = $query->paginate(2)->withQueryString();

        $data['categories'] = $query->get();
        $data['types'] = Type::all();

        return view('admin.categories.index', $data);
    }



    public function create()
    {
        $data['types'] = Type::get();
        return view('admin.categories.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required',
        ]);

        // Get type
        $type = Type::findOrFail($request->type_id);
        $typeSlug = Str::slug($type->type);
        $categorySlug = Str::slug($request->input('name'));

        // Combine slugs
        $slug = "{$typeSlug}-{$categorySlug}";

        $data = $request->only(['name', 'type_id']);
        $data['slug'] = $slug;

        $i = Category::create($data);

        if ($i) {
            return redirect()->route('category.index')->with('success', 'Created successfully!');
        } else {
            return redirect()->route('category.create')
                ->with('error', 'Failed to create.')
                ->withInput();
        }
    }

    public function edit(string $id)
    {
        $data['category'] = Category::findOrFail($id);
        $data['types'] = Type::get();
        return view('admin.categories.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required',
        ]);

        // Get type
        $type = Type::findOrFail($request->type_id);
        $typeSlug = Str::slug($type->type);
        $categorySlug = Str::slug($request->input('name'));

        // Combine slugs
        $slug = "{$typeSlug}-{$categorySlug}";

        $data = $request->only(['name', 'type_id']);
        $data['slug'] = $slug;

        $i = Category::where('id', $id)->update($data);

        if ($i) {
            return redirect()->route('category.index')->with('success', 'Updated successfully!');
        } else {
            return redirect()->route('category.edit', $id)
                ->with('error', 'Failed to update.')
                ->withInput();
        }
    }

    public function delete(string $id)
    {
        $i = Category::where('id', $id)->delete();

        if ($i) {
            return redirect()->route('category.index');
        } else {
            return redirect()->back();
        }
    }
}
