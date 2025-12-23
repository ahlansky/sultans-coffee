<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('menu')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cartItems
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1',
        ]);

        // Opsional: Cek jika item yang sama dengan custom yang sama sudah ada, tinggal update QTY
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'qty' => $request->qty,
            'sugar' => $request->sugar, // dari input Android
            'ice' => $request->ice,     // dari input Android
        ]);

        return response()->json(['message' => 'Masuk keranjang Sultan!', 'data' => $cart], 201);
    }

    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->delete();
            return response()->json(['message' => 'Item dihapus']);
        }
        return response()->json(['message' => 'Item tidak ditemukan'], 404);
    }
}