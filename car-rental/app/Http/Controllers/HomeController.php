<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularVehicles = Vehicle::where('status', 'available')
            ->orderBy('daily_rate', 'asc')
            ->take(3)
            ->get();

        return view('home', compact('popularVehicles'));
    }
} 