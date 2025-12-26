<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerReview;
use App\Models\Sellers;
use App\Models\UsersGreenHouse;

class SellerReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index()
    {
        $reviews = SellerReview::with(['user', 'seller'])->get();

        return response()->json([
            'data' => $reviews,
            'message' => $reviews->count() > 0 ? 'All Reviews' : 'No Reviews Found'
        ], 200);
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:usersgreenhouse,id',
            'seller_id' => 'required|exists:sellers,id',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'nullable|string'
        ]);

        $review = SellerReview::create([
            'user_id'   => $request->user_id,
            'seller_id' => $request->seller_id,
            'rating'    => $request->rating,
            'comment'   => $request->comment,
        ]);

        return response()->json([
            'data' => $review,
            'message' => 'Review added successfully'
        ], 201);
    }

    /**
     * Display the specified review.
     */
    public function show(string $id)
    {
        $review = SellerReview::with(['user', 'seller'])->find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found'
            ], 404);
        }

        return response()->json([
            'data' => $review
        ], 200);
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, string $id)
    {
        $review = SellerReview::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found'
            ], 404);
        }

        $request->validate([
            'rating'  => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string'
        ]);

        $review->update($request->only(['rating', 'comment']));

        return response()->json([
            'data' => $review,
            'message' => 'Review updated successfully'
        ], 200);
    }

    /**
     * Remove the specified review.
     */
    public function destroy(string $id)
    {
        $review = SellerReview::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found'
            ], 404);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully'
        ], 200);
    }
}
