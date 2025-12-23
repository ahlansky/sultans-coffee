<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create($request->all());

        return back()->with('success', 'Kategori baru berhasil ditambah!');
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        Category::destroy($id);

        return back()->with('success', 'Kategori dihapus!');
    }
}
