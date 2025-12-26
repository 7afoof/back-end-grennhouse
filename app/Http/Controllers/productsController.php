<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Sellers;

class ProductsController extends Controller
{
    // عرض جميع المنتجات مع بيانات Seller
    public function index()
    {
        $products = Products::with('seller')->get();
        return response()->json([
            'data' => $products,
            'message' => $products->count() > 0 ? 'All Products' : 'No Products Found'
        ], 200);
    }

    // إنشاء منتج جديد
    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'category' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5'
        ]);

        $data = $request->except('image');

        // ⬇️ upload image f public/products
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // smiya unique
            $image->move(public_path('products'), $imageName);
            $data['image'] = '/products/' . $imageName; // path li ghadi tkhzan f DB
        }

        $product = Products::create($data);

        return response()->json([
            'data' => $product,
            'message' => 'Product created successfully'
        ], 201);
    }

    // عرض منتج واحد مع بيانات Seller
    public function show($id)
    {
        $product = Products::with('seller')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['data' => $product], 200);
    }

    // تعديل منتج
    public function update(Request $request, $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'category' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $data = $request->except('image');

        // ✅ إلا تبدلات الصورة
        if ($request->hasFile('image')) {

            // 🧹 حذف الصورة القديمة
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // ⬆️ رفع الصورة الجديدة
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('products'), $imageName);

            // 📝 تخزين المسار الجديد
            $data['image'] = '/products/' . $imageName;
        }

        $product->update($data);

        return response()->json([
            'data' => $product,
            'message' => 'Product updated successfully'
        ], 200);
    }


    // حذف منتج
    public function destroy($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // 🧹 حذف الصورة من public/products
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        // ❌ حذف المنتج من DB
        $product->delete();

        return response()->json([
            'message' => 'Product and image deleted successfully'
        ], 200);
    }
}
