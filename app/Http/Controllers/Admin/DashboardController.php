<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama Dashboard Admin
     */
    public function index()
    {
        // Ambil 10 pesanan terbaru beserta user
        $orders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Statistik dashboard
        $totalMenus  = Menu::count();
        $totalOrders = Order::count();

        // Kirim ke view admin.dashboard
        return view('admin.dashboard', compact(
            'orders',
            'totalMenus',
            'totalOrders'
        ));
    }

    /**
     * Update status pesanan (pending, processing, ready, done, canceled)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,done,canceled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Status pesanan #' . $order->id . ' berhasil diperbarui!'
            );
    }
}
