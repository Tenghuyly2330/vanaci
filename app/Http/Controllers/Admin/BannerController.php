<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
   public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));

    }
    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
    ]);


    // Upload image
    $imageName = null;
    if ($request->hasFile('image')) {
        $folder = public_path('assets/banner');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move($folder, $imageName);
    }

    Banner::create([
        'image' => $imageName,
    ]);

    return redirect()->route('banner.index')->with('success', 'Created successfully.');
}



public function edit(string $id)
{
    $banner = Banner::findOrFail($id);
    return view('admin.banner.edit', compact('banner'));
}



public function update(Request $request, string $id)
{
    $validated = $request->validate([
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
    ]);

    $banner = Banner::findOrFail($id);

    // If new image uploaded
    if ($request->hasFile('image')) {

        // create folder if not exist
        $folder = public_path('assets/banner');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // delete old image
        if ($banner->photo && file_exists($folder . '/' . $banner->image)) {
            unlink($folder . '/' . $banner->image);
        }

        // upload new image
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move($folder, $imageName);
    } else {
        // keep old image
        $imageName = $banner->image;
    }

    $banner->update([
        'image' => $imageName,
    ]);

    return redirect()->route('banner.index')->with('success', 'Updated successfully.');
}


    public function delete(string $id)
    {
        $i = Banner::where('id', $id)->delete();
        if($i){
            return redirect()->route('banner.index')->with('success', 'Deleted successfully');
        } else {
            return redirect()->route('banner.index')->with('error', 'Fail to delete data');
        }
    }
}
