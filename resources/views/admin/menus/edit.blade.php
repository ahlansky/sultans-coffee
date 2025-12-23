<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Menu Sultan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 md:p-12">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Menu <span class="text-yellow-600 text-sm italic">#{{ $menu->id }}</span></h1>
        
        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- WAJIB UNTUK UPDATE -->
            
            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ $menu->name }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-yellow-600 outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Kategori</label>
                <select name="category_id" class="w-full border p-3 rounded-xl outline-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $menu->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Harga (Rupiah)</label>
                <input type="number" name="price" value="{{ $menu->price }}" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-yellow-600 outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-yellow-600 outline-none" rows="3">{{ $menu->description }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block font-bold text-gray-700 mb-2">Foto Saat Ini</label>
                <img src="{{ asset('storage/' . $menu->image) }}" class="w-24 h-24 rounded-xl object-cover mb-2 border">
                <p class="text-xs text-gray-400 mb-2">*Biarkan kosong jika tidak ingin mengganti foto</p>
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-yellow-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-yellow-700 transition">Simpan Perubahan</button>
                <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>