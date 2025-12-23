<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * =========================
     * CUSTOMER
     * Pilih outlet (simpan ke session)
     * =========================
     */
    public function select(Request $request)
    {
        $request->validate([
            'outlet_id'   => 'required|exists:outlets,id',
            'outlet_name' => 'required|string'
        ]);

        // Simpan ke session
        session([
            'selected_outlet_id'   => $request->outlet_id,
            'selected_outlet_name' => $request->outlet_name,
        ]);

        return redirect()->route('home');
    }

    /**
     * =========================
     * ADMIN
     * Daftar outlet
     * =========================
     */
    public function index()
    {
        $outlets = Outlet::latest()->get();
        return view('admin.outlets.index', compact('outlets'));
    }

    /**
     * =========================
     * ADMIN
     * Tambah outlet baru
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string'
        ]);

        Outlet::create([
            'name'    => $request->name,
            'address' => $request->address
        ]);

        return redirect()
            ->back()
            ->with('success', 'Cabang Sultan berhasil ditambahkan 👑');
    }
}
