<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = [
            'image' => $user->image,
            'name' => $user->name,
            'email' => $user->email,
        ];

        return ResponseFormatter::success($data, 'Data berhasil ditampilkan!');
    }
}
