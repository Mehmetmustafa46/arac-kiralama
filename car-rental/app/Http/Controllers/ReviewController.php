<?php


namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Car;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Yorum başarıyla eklendi!');
    }
}
