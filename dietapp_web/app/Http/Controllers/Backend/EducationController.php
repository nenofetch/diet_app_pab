<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Education;

class EducationController extends Controller
{
    public function index()
    {
        // get data
        $data['educations'] = Education::all();

        return view('backend.educations.index', $data);
    }

    public function create()
    {
        return view('backend.educations.add');
    }

    public function store(Request $request)
    {
        // validaton
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required|max:255',
            'link' => 'required',
            'description' => 'required',
        ]);

        // process upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('public/educations');
            $thumbnailName = basename($thumbnailPath);
        } else {
            $thumbnailName = '';
        }

        // insert to table
        Education::create([
            'thumbnail' => $thumbnailName,
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
        ]);

        return redirect('educations')->with('message', 'Edukasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // get data
        $data['education'] = Education::find($id);

        return view('backend.educations.edit', $data);
    }

    public function update(Request $request,$id)
    {
        // validaton
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
            'title' => 'required|max:255',
            'link' => 'required',
            'description' => 'required',
        ]);

        // get data by id
        $education = Education::find($id);

        // proces upload thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($education->thumbnail && Storage::exists('public/educations/' . $education->thumbnail)) {
                Storage::delete('public/educations/' . $education->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('public/educations');
            $thumbnailName = basename($thumbnailPath);
        } else {
            $thumbnailName = $education->thumbnail;
        }

        // update to table
        $education->update([
            'thumbnail' => $thumbnailName,
            'title' => $request->title,
            'link' => $request->link,
            'description' => $request->description,
        ]);

        return redirect('educations')->with('message', 'Edukasi berhasil diubah!');
    }

    public function destroy($id)
    {
        // get data by id
        $education = Education::find($id);

        // proses delete thumbnail
        if ($education->thumbnail) {
            Storage::delete('public/educations/' . $education->thumbnail);
        }

        // delete data
        $education->delete();

        return response()->json(['message' => 'Edukasi berhasil dihapus!']);
    }
}
