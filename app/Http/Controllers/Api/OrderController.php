<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.menu')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json(['success' => true, 'data' => $orders]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $cartItems = Cart::with('menu')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong'], 400);
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->menu->price * $item->qty;
        });

        DB::beginTransaction();
        try {
            $outletId = $request->outlet_id ?? 1;
            if (!Outlet::find($outletId)) {
                throw new \Exception("Outlet ID {$outletId} belum ada di database.");
            }

            $order = Order::create([
                'user_id'     => $userId,
                'outlet_id'   => $outletId,
                'total_price' => $totalPrice,
                'status'      => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $item->menu_id,
                    'qty'      => $item->qty,
                    'price'    => $item->menu->price,
                    'sugar'    => $item->sugar,
                    'ice'      => $item->ice,
                ]);
            }

            Cart::where('user_id', $userId)->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pesanan Berhasil!', 'order_id' => $order->id], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function allOrders()
    {
        try {
            if (auth()->user()->role !== 'admin') {
                return response()->json(['success' => false, 'message' => 'Bukan Admin'], 403);
            }

            // Pastikan relasi 'user', 'items.menu', dan 'outlet' ADA di model Order
            $orders = Order::with(['user', 'items.menu', 'outlet'])->latest()->get();

            return response()->json(['success' => true, 'data' => $orders]);

        } catch (\Exception $e) {
            // Jika Error 500, Android akan menampilkan pesan error aslinya
            return response()->json(['success' => false, 'message' => 'Error API: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatusApi(Request $request)
    {
        if (auth()->user()->role !== 'admin') return response()->json(['message' => 'Forbidden'], 403);

        $order = Order::find($request->order_id);
        if (!$order) return response()->json(['message' => 'Order tidak ditemukan'], 404);

        $order->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status Updated!']);
    }
}