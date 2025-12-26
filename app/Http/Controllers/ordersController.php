<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;

class OrdersController extends Controller
{
    // عرض جميع الطلبات مع بيانات User و Seller
    public function index()
    {
        $orders = Orders::with(['user', 'seller', 'orderItems'])->get();
        return response()->json([
            'data' => $orders,
            'message' => $orders->count() > 0 ? 'All Orders' : 'No Orders Found'
        ], 200);
    }

    // إنشاء طلب جديد
    public function store(Request $request)
    {
        $request->validate([
            // 'id' => 'required|numeric|unique:orders,id',
            'user_id' => 'required|exists:usersgreenhouse,id',
            'seller_id' => 'required|exists:sellers,id',
            'firstNameCustomer' => 'required|string|max:255',
            'lastNameCustomer' => 'required|string|max:255',
            'phoneCustomer' => 'required|string|max:20',
            'adressCustomer' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'sometimes|string|in:pending,completed,cancelled'
        ]);

        $order = Orders::create([
            // 'id' => $request->id,
            'user_id' => $request->user_id,
            'seller_id' => $request->seller_id,
            'firstNameCustomer' => $request->firstNameCustomer,
            'lastNameCustomer' => $request->lastNameCustomer,
            'phoneCustomer' => $request->phoneCustomer,
            'adressCustomer' => $request->adressCustomer,
            'total_amount' => $request->total_amount,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'data' => $order,
            'message' => 'Order created successfully'
        ], 201);
    }

    // عرض طلب واحد مع بيانات User و Seller
    public function show($id)
    {
        $order = Orders::with(['user', 'seller', 'orderItems'])->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json(['data' => $order], 200);
    }

    // تعديل طلب
    public function update(Request $request, $id)
    {
        $order = Orders::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $request->validate([
            'user_id' => 'sometimes|exists:usersgreenhouse,id',
            'seller_id' => 'sometimes|exists:sellers,id',
            'firstNameCustomer' => 'sometimes|string|max:255',
            'lastNameCustomer' => 'sometimes|string|max:255',
            'phoneCustomer' => 'sometimes|string|max:20',
            'adressCustomer' => 'sometimes|string|max:255',
            'total_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:pending,delivered,shipped,cancelled'
        ]);

        $order->update($request->all());

        return response()->json([
            'data' => $order,
            'message' => 'Order updated successfully'
        ], 200);
    }

    // حذف طلب
    public function destroy($id)
    {
        $order = Orders::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}











