<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sport;
use App\Helpers\ResponseFormatter;

class SportController extends Controller
{
    public function index()
    {
        $sports = Sport::all();

        return ResponseFormatter::success(['sports' => $sports], 'Data berhasil ditampilkan!');
    }
}
