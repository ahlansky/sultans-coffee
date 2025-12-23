<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sultans Coffee - Admin Dashboard</title>
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
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-extrabold text-gray-800">
                Sultans <span class="text-yellow-600">Dashboard</span>
            </h1>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('admin.menus.index') }}"
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2 rounded-lg shadow-md font-bold transition">
                    ☕ Kelola Menu Kopi
                </a>

                <span class="bg-white px-4 py-2 rounded-lg shadow-sm border text-sm font-medium text-gray-600">
                    Admin Panel
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-red-50 text-red-600 px-4 py-2 rounded-lg font-bold hover:bg-red-100 transition border border-red-200">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>

        <!-- FLASH MESSAGE -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-xl mb-6 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-yellow-600">
                <p class="text-gray-500 text-sm font-semibold uppercase">Total Menu</p>
                <h3 class="text-4xl font-bold">{{ $totalMenus }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border-l-8 border-gray-800">
                <p class="text-gray-500 text-sm font-semibold uppercase">Total Pesanan</p>
                <h3 class="text-4xl font-bold">{{ $totalOrders }}</h3>
            </div>
        </div>

        <!-- TABEL PESANAN -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border">
            <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">10 Pesanan Terbaru</h2>
                <span class="text-xs text-gray-400 italic">
                    *Status otomatis tersimpan saat diubah
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b text-gray-400 text-sm uppercase">
                            <th class="p-4">Order ID</th>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Detail Pesanan</th>
                            <th class="p-4">Total</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4">Waktu</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 align-top">
                            <td class="p-4 font-bold text-yellow-700">
                                #{{ $order->id }}
                            </td>

                            <td class="p-4">
                                <div class="font-semibold">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                            </td>

                            <td class="p-4 text-sm">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($order->items as $item)
                                        <li>
                                            <strong>{{ $item->qty }}x</strong>
                                            {{ $item->menu->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            <td class="p-4 font-bold text-green-700">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>

                            <td class="p-4 text-center">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                            onchange="this.form.submit()"
                                            class="text-xs font-bold uppercase py-2 px-3 rounded-xl border cursor-pointer">
                                        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                        <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                                        <option value="ready" {{ $order->status=='ready'?'selected':'' }}>Ready</option>
                                        <option value="done" {{ $order->status=='done'?'selected':'' }}>Done</option>
                                        <option value="canceled" {{ $order->status=='canceled'?'selected':'' }}>Canceled</option>
                                    </select>
                                </form>
                            </td>

                            <td class="p-4 text-gray-400 text-sm">
                                {{ $order->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400">
                                Belum ada pesanan ☕
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <!-- ================= END MAIN CONTENT ================= -->

</body>
</html>
