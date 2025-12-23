<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * =====================
     * API: LIST MENU (PUBLIC)
     * GET /api/menus
     * =====================
     */
    public function index()
    {
        // Ambil kategori beserta menu di dalamnya
        $categories = Category::with('menus')->get();

        return response()->json([
            'success' => true,
            'data'    => $categories
        ], 200);
    }

    /**
     * =====================
     * API: TAMBAH MENU (ADMIN)
     * POST /api/admin/menus
     * =====================
     */
    public function storeApi(Request $request)
    {
        // 🔐 Cek apakah Admin
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // ✅ Validasi input
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // 📸 Simpan gambar ke storage
            $path = $request->file('image')->store('menus', 'public');

            // 💾 Simpan ke database
            $menu = Menu::create([
                'category_id' => $request->category_id,
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => $request->price,
                'image'       => $path,
                'is_active'   => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kopi baru berhasil diracik Sultan! ☕👑',
                'data'    => $menu
            ], 201);

        } catch (\Exception $e) {

            // Jika gagal, hapus gambar agar storage bersih
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
