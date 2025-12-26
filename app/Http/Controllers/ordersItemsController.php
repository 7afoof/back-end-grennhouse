<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdersItems;

class OrdersItemsController extends Controller
{
    // عرض جميع العناصر
    public function index()
    {
        $items = OrdersItems::with(['order', 'product'])->get();
        return response()->json([
            'data' => $items,
            'message' => $items->count() > 0 ? 'All Order Items' : 'No Order Items Found'
        ], 200);
    }

    // إنشاء عنصر جديد
    public function store(Request $request)
    {
        $request->validate([
            // 'id'=> 'required|numeric|unique:order_items,id',
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
            'total'      => 'required|numeric|min:0'
        ]);

        $item = OrdersItems::create([
            // 'id' => $request->id,
            'order_id'   => $request->order_id,
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'price'      => $request->price,
            'total'      => $request->total
        ]);

        return response()->json([
            'data' => $item,
            'message' => 'Order Item created successfully'
        ], 201);
    }

    // عرض عنصر واحد
    public function show($id)
    {
        $item = OrdersItems::with(['order', 'product'])->find($id);
        if (!$item) {
            return response()->json(['message' => 'Order Item not found'], 404);
        }
        return response()->json(['data' => $item], 200);
    }

    // تعديل عنصر
    public function update(Request $request, $id)
    {
        $item = OrdersItems::find($id);
        if (!$item) {
            return response()->json(['message' => 'Order Item not found'], 404);
        }

        $request->validate([
            'order_id'   => 'sometimes|exists:orders,id',
            'product_id' => 'sometimes|exists:products,id',
            'quantity'   => 'sometimes|integer|min:1',
            'price'      => 'sometimes|numeric|min:0',
            'total'      => 'sometimes|numeric|min:0'
        ]);

        $item->update($request->all());

        return response()->json([
            'data' => $item,
            'message' => 'Order Item updated successfully'
        ], 200);
    }

    // حذف عنصر
    public function destroy($id)
    {
        $item = OrdersItems::find($id);
        if (!$item) {
            return response()->json(['message' => 'Order Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Order Item deleted successfully'], 200);
    }
}
