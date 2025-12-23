<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Sultan Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#2D1B08] h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md border-t-8 border-[#C5A059]">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-[#2D1B08]">Sultans <span class="text-[#C5A059]">Coffee</span></h1>
            <p class="text-gray-500 text-sm mt-2">Halaman Khusus Sultan Admin</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-700 mb-2">Email Admin</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#C5A059] focus:ring-2 focus:ring-[#C5A059] outline-none transition" placeholder="admin@sultans.coffee" required>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#C5A059] focus:ring-2 focus:ring-[#C5A059] outline-none transition" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-[#2D1B08] text-[#C5A059] font-extrabold py-4 rounded-xl shadow-lg hover:bg-black transition duration-300">
                MASUK KE DASHBOARD
            </button>
        </form>
    </div>

</body>
</html>