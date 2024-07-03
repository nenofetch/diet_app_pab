<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ResponseFormatter;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user();

        return ResponseFormatter::success(['profile' => $profile], 'Data berhasil ditampilkan!');
    }

    public function update(Request $request)
    {
        // get data
        $profile = Auth::user();

        // check if email unique the user email
        if ($profile->email == $request->email) {
            $rules = 'required|email';
        } else {
            $rules = 'required|email|unique:users';
        }

        // validation
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpg,png,jpeg|image|max:2048',
            'name' => 'required',
            'email' => $rules,
            'password' => 'min:8|confirmed',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'work' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // checking image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/users');

            if ($profile->image != 'default/user.png') {
                Storage::delete('public/users/' . $profile->image);
            }

            $imageName = basename($imagePath);
        } else {
            $imageName = $profile->image;
        }

        // update to table
        $profile->update([
            'image' => $imageName,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'work' => $request->work,
        ]);

        return ResponseFormatter::success(['profile' => $profile], 'Profile berhasil diubah!');
    }
}
