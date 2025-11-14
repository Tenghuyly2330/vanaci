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
        ]);
        $slug = Str::slug($validated['type'], '-');
        Type::create([
            'type' => $validated['type'],
            'slug' => $slug,
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
        ]);
        $type = Type::findOrFail($id);
        $slug = Str::slug($validated['type'], '-');

        $type->update([
            'type' => $validated['type'],
            'slug' => $slug,
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
