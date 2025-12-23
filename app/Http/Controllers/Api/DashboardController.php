<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * =====================
     * API: DASHBOARD ADMIN
     * GET /api/dashboard-admin
     * =====================
     */
    public function index(Request $request)
    {
        // =====================
        // VALIDASI ROLE ADMIN
        // =====================
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Sultan Admin yang boleh melihat omset!'
            ], 403);
        }

        /**
         * =====================
         * 1️⃣ OMSET HARI INI
         * =====================
         * Catatan:
         * - Status disesuaikan dengan sistem order
         * - Jika kamu pakai "served", ganti dari "done"
         */
        $omsetHariIni = Order::whereDate('created_at', Carbon::today())
            ->whereIn('status', ['served', 'done'])
            ->sum('total_price');

        /**
         * =====================
         * 2️⃣ OMSET BULAN INI
         * =====================
         */
        $omsetBulanIni = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereIn('status', ['served', 'done'])
            ->sum('total_price');

        /**
         * =====================
         * 3️⃣ PESANAN PENDING
         * =====================
         */
        $pesananPending = Order::where('status', 'pending')->count();

        /**
         * =====================
         * 4️⃣ TOTAL MENU
         * =====================
         */
        $totalMenus = Menu::count();

        /**
         * =====================
         * 5️⃣ MENU TERLARIS (TOP 3)
         * =====================
         */
        $menuTerlaris = OrderItem::select(
                'menu_id',
                DB::raw('SUM(qty) as total_qty')
            )
            ->groupBy('menu_id')
            ->orderByDesc('total_qty')
            ->with('menu:id,name')
            ->take(3)
            ->get();

        /**
         * =====================
         * RESPONSE JSON
         * =====================
         */
        return response()->json([
            'success' => true,
            'message' => 'Data Statistik Kesultanan Coffee',
            'data' => [
                'omset_today'    => (int) $omsetHariIni,
                'omset_month'    => (int) $omsetBulanIni,
                'pending_orders' => $pesananPending,
                'total_menus'    => $totalMenus,
                'top_menus'      => $menuTerlaris
            ]
        ]);
    }
}
