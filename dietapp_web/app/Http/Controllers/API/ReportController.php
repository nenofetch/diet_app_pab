<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;
use Carbon\Carbon;
use App\Helpers\ResponseFormatter;

class ReportController extends Controller
{
    public function index()
    {
        // Set locale to Indonesian
        Carbon::setLocale('id');

        // Calculate the start date of the last week
        $lastWeek = now()->subWeek();

        // Loop for 7 days, including blanks
        for ($i = 0; $i < 7; $i++) {
            $date = $lastWeek->addDay();

            // Retrieve data from database based on date
            $histories = History::whereDate('created_at', $date->toDateString())->get();

            // Convert calories to integers
            $histories->transform(function ($history) {
                $history->calories = intval($history->calories);
                return $history;
            });

            // Count the calories
            $totalCalories = $histories->sum('calories');

            // Add data to an array
            $calories[] = [
                'day' => $date->translatedFormat('l'),
                'total' => $totalCalories,
            ];

            // Sort data by day of the week
            $calories = collect($calories)->sortBy(function ($item) {
                return array_search($item['day'], ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            })->values()->all();

            // Convert carbohydrates to integers
            $histories->transform(function ($history) {
                $history->carbohydrates = intval($history->carbohydrates);
                return $history;
            });

            // Count the carbohydrates
            $totalCarbohydrates = $histories->sum('carbohydrates');

            // Add data to an array
            $carbohydrates[] = [
                'day' => $date->translatedFormat('l'),
                'total' => $totalCarbohydrates,
            ];

            // Sort data by day of the week
            $carbohydrates = collect($carbohydrates)->sortBy(function ($item) {
                return array_search($item['day'], ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            })->values()->all();

            // Convert protein to integers
            $histories->transform(function ($history) {
                $history->protein = intval($history->protein);
                return $history;
            });

            // Count the protein
            $totalProtein = $histories->sum('protein');

            // Add data to an array
            $protein[] = [
                'day' => $date->translatedFormat('l'),
                'total' => $totalProtein,
            ];

            // Sort data by day of the week
            $protein = collect($protein)->sortBy(function ($item) {
                return array_search($item['day'], ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            })->values()->all();

            // Convert fat to integers
            $histories->transform(function ($history) {
                $history->fat = intval($history->fat);
                return $history;
            });

            // Count the fat
            $totalFat = $histories->sum('fat');

            // Add data to an array
            $fat[] = [
                'day' => $date->translatedFormat('l'),
                'total' => $totalFat,
            ];

            // Sort data by day of the week
            $fat = collect($fat)->sortBy(function ($item) {
                return array_search($item['day'], ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            })->values()->all();
        }

        $data = [
            'calories' => $calories,
            'carbohydrates' => $carbohydrates,
            'protein' => $protein,
            'fat' => $fat
        ];

        return ResponseFormatter::success($data, 'Data berhasil ditampilkan!');
    }

    public function show()
    {
        // Get where category breakfast
        $breakfast = History::where('category', 'Makan Pagi')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'asc')->get();

        // Get where category lunch
        $lunch = History::where('category', 'Makan Siang')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'asc')->get();

        // Get where category dinner
        $dinner = History::where('category', 'Makan Malam')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'asc')->get();

        // Get where category snack
        $snack = History::where('category', 'Cemilan')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'asc')->get();

        // Get where category drink
        $drink = History::where('category', 'Minuman')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'asc')->get();

        $data = [
            'breakfast' => $breakfast,
            'lunch' => $lunch,
            'dinner' => $dinner,
            'snack' => $snack,
            'drink' => $drink,
        ];

        return ResponseFormatter::success($data, 'Data berhasil ditampilkan!');
    }
}
