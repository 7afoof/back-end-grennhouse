<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sellers;
use App\Models\UsersGreenHouse;

class SellersController extends Controller
{
    /**
     * Display a listing of the sellers.
     */
    public function index()
    {
        $sellers = Sellers::with('user')->get();

        return response()->json([
            'data' => $sellers,
            'message' => $sellers->count() > 0 ? 'All Sellers' : 'No Sellers Found'
        ], 200);
    }

    /**
     * Store a newly created seller.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:usersgreenhouse,id',
            'store_name' => 'required|string',
            'phone' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'subscription_type' => 'required|string',
            'subscription_expires_at' => 'required|date',
            'latitude' => 'required',
            'longitude' => 'required',
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'banner' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // =========================
        // 📸 UPLOAD LOGO
        // =========================
        $logo = $request->file('logo');
        $logoName = time() . '_logo_' . $logo->getClientOriginalName();
        $logo->move(public_path('logos'), $logoName);
        $logoPath = '/logos/' . $logoName;

        // =========================
        // 🖼️ UPLOAD BANNER
        // =========================
        $banner = $request->file('banner');
        $bannerName = time() . '_banner_' . $banner->getClientOriginalName();
        $banner->move(public_path('banners'), $bannerName);
        $bannerPath = '/banners/' . $bannerName;

        // =========================
        // 🏪 CREATE SELLER
        // =========================
        $seller = Sellers::create([
            'user_id' => $request->user_id,
            'store_name' => $request->store_name,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'description' => $request->description,
            'subscription_type' => $request->subscription_type,
            'subscription_expires_at' => $request->subscription_expires_at,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'logo' => $logoPath,
            'banner' => $bannerPath,
            'rating' => 0,
        ]);

        return response()->json([
            'data' => $seller,
            'message' => 'Seller created successfully'
        ], 201);
    }


    /**
     * Display the specified seller.
     */
    public function show(string $id)
    {
        $seller = Sellers::with('user')->find($id);

        if (!$seller) {
            return response()->json([
                'message' => 'Seller not found'
            ], 404);
        }

        return response()->json([
            'data' => $seller
        ], 200);
    }

    /**
     * Update the specified seller.
     */
    public function update(Request $request, string $id)
    {
        $seller = Sellers::find($id);

        if (!$seller) {
            return response()->json([
                'message' => 'Seller not found'
            ], 404);
        }

        $request->validate([
            'store_name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string',
            'city' => 'sometimes|string',
            'address' => 'sometimes|string',
            'description' => 'sometimes|string',
            'rating' => 'sometimes|numeric|min:0|max:5',
        ]);

        $seller->update($request->only([
            'store_name',
            'phone',
            'city',
            'address',
            'description',
            'rating'
        ]));

        return response()->json([
            'data' => $seller,
            'message' => 'Seller updated successfully'
        ], 200);
    }

    /**
     * Remove the specified seller.
     */
    public function destroy(string $id)
    {
        $seller = Sellers::find($id);

        if (!$seller) {
            return response()->json([
                'message' => 'Seller not found'
            ], 404);
        }

        $seller->delete();

        return response()->json([
            'message' => 'Seller deleted successfully'
        ], 200);
    }
}
