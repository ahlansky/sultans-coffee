<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * =====================
     * TAMPILKAN DAFTAR MENU (WEB)
     * =====================
     */
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * =====================
     * FORM TAMBAH MENU (WEB)
     * =====================
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * =====================
     * SIMPAN MENU BARU (WEB)
     * =====================
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload gambar
        $path = $request->file('image')->store('menus', 'public');

        Menu::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $path,
            'is_active'   => true,
        ]);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Kopi Sultan berhasil ditambahkan 👑');
    }

    /**
     * =====================
     * FORM EDIT MENU (WEB)
     * =====================
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * =====================
     * UPDATE MENU (WEB)
     * =====================
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
        ];

        // Jika upload gambar baru
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu Sultan berhasil diperbarui ☕');
    }

    /**
     * =====================
     * HAPUS MENU (WEB)
     * =====================
     */
    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()
            ->back()
            ->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * =====================
     * HAPUS MENU (API ANDROID - ADMIN)
     * DELETE /api/admin/menus/{id}
     * =====================
     */
    public function destroyApi($id)
    {
        // 🔐 Validasi Admin
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'message' => 'Kopi tidak ditemukan'
            ], 404);
        }

        // 🗑️ Hapus file gambar
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        // 🗑️ Hapus menu
        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kopi dihapus dari kerajaan! ☕👑'
        ]);
    }
}
