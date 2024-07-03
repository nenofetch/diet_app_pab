<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Snack;
use App\Models\Drink;
use App\Models\Sport;
use App\Models\Education;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'foods' => Food::count(),
            'snacks' => Snack::count(),
            'drinks' => Drink::count(),
            'sports' => Sport::count(),
            'educations' => Education::count(),
            'users' => User::count(),
        ];

        return view('backend.dashboard.index', $data);
    }
}
