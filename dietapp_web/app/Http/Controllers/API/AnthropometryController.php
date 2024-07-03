<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Anthropometry;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;

class AnthropometryController extends Controller
{
    public function index(Request $request)
    {
        $weight = $request->weight; // Body weight in kilograms (kg)
        $height = $request->height; // Height in meters (m)

        // Squares height in meters
        $heightSquared = $height * $height;

        // Calculate BMI
        $imt = $weight / $heightSquared;

        $result = '';

        if ($imt < 18.5) {
            $result = 'Underweight';
        } elseif ($imt >= 18.5 && $imt <= 24.9) {
            $result = 'Normal';
        } elseif ($imt >= 25 && $imt <= 29.9) {
            $result = 'Overweight';
        } elseif ($imt >= 30 && $imt <= 34.9) {
            $result = 'Obesity Class I';
        } elseif ($imt >= 35 && $imt <= 39.9) {
            $result = 'Obesity Class II';
        } elseif ($imt >= 40) {
            $result = 'Obesity Class III';
        }

        $data = [
            'imt' => $imt,
            'result' => $result,
        ];



        Anthropometry::create([
            'result' => $result,
            'imt' => $imt,
            'weight' => $weight,
            'height' => $height,
            'user_id' => Auth::user()->id,
        ]);

        return ResponseFormatter::success($data, 'Kalkulasi IMT berhasil!');
    }


    public function store(Request $request)
    {
        $data = $request->all();


    }
}
