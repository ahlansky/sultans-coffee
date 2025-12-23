<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Sultans Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- ================= SIDEBAR ================= -->
    <aside class="basis-64 min-w-[16rem] bg-[#2D1B08] text-white flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            Sultans <span class="text-[#C5A059]">Admin</span>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="block py-2.5 px-4 rounded transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-[#C5A059] text-white' : 'hover:bg-gray-700 text-gray-400' }}">
                📊 Dashboard
            </a>

            <a href="{{ route('admin.menus.index') }}"
               class="block py-2.5 px-4 rounded transition
               {{ request()->routeIs('admin.menus.*') ? 'bg-[#C5A059] text-white' : 'hover:bg-gray-700 text-gray-400' }}">
                ☕ Kelola Menu
            </a>

            <a href="#"
               class="block py-2.5 px-4 rounded transition hover:bg-gray-700 text-gray-400">
                📁 Kategori
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full text-left py-2.5 px-4 text-red-400 hover:text-red-300 font-bold">
                    🚪 Logout
                </button>
            </form>
        </div>
    </aside>
    <!-- ================= END SIDEBAR ================= -->


    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1 overflow-y-auto p-6 md:p-10">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">
                Daftar Menu Kopi ☕
            </h1>

            <a href="{{ route('admin.menus.create') }}"
               class="bg-yellow-600 text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-yellow-700 transition">
                + Tambah Kopi Baru
            </a>
        </div>

        <!-- FLASH MESSAGE -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4 shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4">Gambar</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse($menus as $menu)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4">
                            <img src="{{ asset('storage/' . $menu->image) }}"
                                 class="w-16 h-16 rounded-lg object-cover shadow-sm">
                        </td>

                        <td class="p-4 font-bold text-gray-800">
                            {{ $menu->name }}
                        </td>

                        <td class="p-4 text-gray-500">
                            {{ $menu->category->name ?? '-' }}
                        </td>

                        <td class="p-4 font-semibold">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-4 font-bold text-xs">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}"
                                   class="text-blue-600 hover:underline">
                                    EDIT
                                </a>

                                <form action="{{ route('admin.menus.destroy', $menu->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus kopi ini, Sultan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        HAPUS
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-6 text-gray-500">
                            Belum ada menu kopi ☕
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </main>
    <!-- ================= END MAIN CONTENT ================= -->

</body>
</html>
