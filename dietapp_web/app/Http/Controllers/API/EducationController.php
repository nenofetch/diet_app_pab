<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Helpers\ResponseFormatter;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::all();

        return ResponseFormatter::success(['educations' => $educations], 'Data berhasil ditampilkan!');
    }
}
