<!-- Meta untuk PWA / Mobile -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
<link rel="manifest" href="/manifest.json">
<body class="bg-gray-50 pb-20"> <!-- pb-20 supaya konten gak ketutup nav bawah -->

    <!-- Konten Utama -->
    <main class="max-w-md mx-auto bg-white min-h-screen shadow-lg">
        @yield('content')
    </main>

    <!-- Bottom Navigation (Hanya muncul di User) -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 flex justify-around items-center max-w-md mx-auto">
        <a href="/home" class="flex flex-col items-center text-pink-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-xs">Home</span>
        </a>
        <a href="/orders" class="flex flex-col items-center text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <span class="text-xs">Pesanan</span>
        </a>
        <a href="/profile" class="flex flex-col items-center text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-xs">Akun</span>
        </a>
    </nav>
</body>