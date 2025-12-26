<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerFeedback;
use App\Models\Sellers;

class SellerFeedbackController extends Controller
{
    // عرض جميع feedbacks مع بيانات الـ Seller
    public function index()
    {
        $feedbacks = SellerFeedback::with('seller')->get();
        return response()->json([
            'data' => $feedbacks,
            'message' => $feedbacks->count() > 0 ? 'All feedbacks' : 'No feedbacks found'
        ], 200);
    }

    // إنشاء feedback جديد
    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'rating'    => 'required|integer|min:1|max:5',
            'message'   => 'required|string',
            'name'      => 'required|string'
        ]);

        $feedback = SellerFeedback::create([
            'seller_id' => $request->seller_id,
            'rating'    => $request->rating,
            'message'   => $request->message,
            'status'    => 'pending',
            'name'      => $request->name,
        ]);

        return response()->json([
            'data' => $feedback,
            'message' => 'Feedback created successfully'
        ], 201);
    }

    // عرض feedback واحد مع بيانات الـ Seller
    public function show($id)
    {
        $feedback = SellerFeedback::with('seller')->find($id);
        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }
        return response()->json(['data' => $feedback], 200);
    }

    // تعديل feedback
    public function update(Request $request, $id)
    {
        $feedback = SellerFeedback::find($id);
        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        $request->validate([
            'rating'  => 'sometimes|integer|min:1|max:5',
            'message' => 'sometimes|string',
            'status'  => 'sometimes|string',
            'name'    => 'sometimes|string'
        ]);

        $feedback->update($request->only(['rating', 'message', 'status', 'name']));

        return response()->json([
            'data' => $feedback,
            'message' => 'Feedback updated successfully'
        ], 200);
    }

    // حذف feedback
    public function destroy($id)
    {
        $feedback = SellerFeedback::find($id);
        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }
        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted successfully'], 200);
    }
}
