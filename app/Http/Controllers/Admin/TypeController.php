<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));

    }
    public function create()
    {
        return view('admin.types.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'type' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $slug = Str::slug($validated['type'], '-');

    // Upload image
    $imageName = null;
    if ($request->hasFile('image')) {
        $folder = public_path('assets/type');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move($folder, $imageName);
    }

    Type::create([
        'type' => $validated['type'],
        'slug' => $slug,
        'image' => $imageName,
    ]);

    return redirect()->route('type.index')->with('success', 'Created successfully.');
}



public function edit(string $id)
{
    $type = Type::findOrFail($id);
    return view('admin.types.edit', compact('type'));
}



public function update(Request $request, string $id)
{
    $validated = $request->validate([
        'type' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
    ]);

    $type = Type::findOrFail($id);
    $slug = Str::slug($validated['type'], '-');

    // If new image uploaded
    if ($request->hasFile('image')) {

        // create folder if not exist
        $folder = public_path('assets/type');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // delete old image
        if ($type->photo && file_exists($folder . '/' . $type->image)) {
            unlink($folder . '/' . $type->image);
        }

        // upload new image
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move($folder, $imageName);
    } else {
        // keep old image
        $imageName = $type->image;
    }

    $type->update([
        'type' => $validated['type'],
        'slug' => $slug,
        'image' => $imageName,
    ]);

    return redirect()->route('type.index')->with('success', 'Updated successfully.');
}


    public function delete(string $id)
    {
        $i = Type::where('id', $id)->delete();
        if($i){
            return redirect()->route('type.index')->with('success', 'Deleted successfully');
        } else {
            return redirect()->route('type.index')->with('error', 'Fail to delete data');
        }
    }
}
