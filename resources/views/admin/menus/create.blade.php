<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Menu Sultan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 md:p-12">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Menu <span class="text-yellow-600">Sultans Coffee</span></h1>
        
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="name" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-yellow-600 outline-none" placeholder="Contoh: Es Kopi Sultan Aren" required>
            </div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Kategori</label>
                <select name="category_id" class="w-full border p-3 rounded-xl outline-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Harga (Rupiah)</label>
                <input type="number" name="price" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-yellow-600 outline-none" placeholder="25000" required>
            </div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                <textarea name="description" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-yellow-600 outline-none" rows="3"></textarea>
            </div>

            <div class="mb-8">
                <label class="block font-bold text-gray-700 mb-2">Foto Kopi (JPG/PNG)</label>
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-yellow-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-yellow-700 transition duration-300">Simpan Menu</button>
                <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>