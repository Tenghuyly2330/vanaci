<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

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
        'file' => 'required|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:51200',
    ]);

    $folder = public_path('assets/banner');
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $file = $request->file('file');
    $extension = $file->extension(); // <-- FIXED (READ BEFORE MOVE)

    $fileName = time() . '_' . uniqid() . '.' . $extension;
    $file->move($folder, $fileName);

    $fileType = in_array($extension, ['mp4', 'mov', 'webm']) ? 'video' : 'image';

    Banner::create([
        'file' => $fileName,
        'file_type' => $fileType,
    ]);

    return redirect()->route('banner.index')->with('success', 'Created successfully.');
}


    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit', compact('banner'));
    }


   public function update(Request $request, $id)
{
    $validated = $request->validate([
        'file' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:51200',
    ]);

    $banner = Banner::findOrFail($id);
    $folder = public_path('assets/banner');

    // If new file uploaded
    if ($request->hasFile('file')) {

        // Delete old file
        if ($banner->file && file_exists($folder . '/' . $banner->file)) {
            unlink($folder . '/' . $banner->file);
        }

        // Prepare new file
        $file = $request->file('file');
        $extension = $file->extension(); // <-- GET EXT BEFORE MOVE

        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $file->move($folder, $fileName);

        // Detect type (image OR video)
        $fileType = in_array($extension, ['mp4', 'mov', 'webm']) ? 'video' : 'image';

    } else {
        // No new file uploaded → keep old one
        $fileName = $banner->file;
        $fileType = $banner->file_type;
    }

    // Update record
    $banner->update([
        'file' => $fileName,
        'file_type' => $fileType,
    ]);

    return redirect()->route('banner.index')->with('success', 'Updated successfully.');
}



    public function delete($id)
    {
        $banner = Banner::findOrFail($id);

        $folder = public_path('assets/banner');

        if ($banner->file && file_exists($folder . '/' . $banner->file)) {
            unlink($folder . '/' . $banner->file);
        }

        $banner->delete();

        return redirect()->route('banner.index')->with('success', 'Deleted successfully.');
    }
}
