<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Review;

class ReviewController extends Controller
{
    public function show(Place $place)
    {
        $reviews = $place->reviews;
        return view('places.show', compact('place', 'reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'content' => 'required|string',
        ]);

        $review = new Review();
        $review->place_id = $request->place_id;
        $review->content = $request->content;
        $review->user_id = auth()->id();
        $review->save();

        return redirect()->back()->with('success', 'Reseña creada exitosamente.');
    }

    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403, 'No tienes permiso para eliminar esta reseña.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Reseña eliminada exitosamente.');
    }
}
