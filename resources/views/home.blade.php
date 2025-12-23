<div x-data="{ openModal: false, selectedMenu: {} }">
    
    <!-- Loop Menu (Update dari kode sebelumnya) -->
    @foreach($cat->menus as $menu)
    <div class="flex items-center justify-between border-b pb-4 mb-4">
        <div class="flex-1">
            <h3 class="font-semibold text-gray-800">{{ $menu->name }}</h3>
            <p class="text-xs text-gray-500 line-clamp-2">{{ $menu->description }}</p>
            <p class="mt-2 font-bold text-gray-900">Rp {{ number_format($menu->price) }}</p>
        </div>
        <div class="ml-4 relative">
            <img src="{{ asset('storage/'.$menu->image) }}" class="w-20 h-20 object-cover rounded-xl">
            <!-- Tombol Tambah memicu Modal -->
            <button 
                @click="openModal = true; selectedMenu = {id: {{ $menu->id }}, name: '{{ $menu->name }}', price: {{ $menu->price }} }"
                class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-white border border-yellow-600 text-yellow-600 px-4 py-1 rounded-lg text-xs font-bold shadow-sm">
                TAMBAH
            </button>
        </div>
    </div>
    @endforeach

    <!-- MODAL CUSTOMIZATION (ALA APP) -->
    <div x-show="openModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         class="fixed inset-0 z-50 flex items-end justify-center bg-black bg-opacity-50">
        
        <div @click.away="openModal = false" class="bg-white w-full max-w-md rounded-t-3xl p-6">
            <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto mb-4"></div>
            
            <h3 class="text-xl font-bold text-gray-800" x-text="selectedMenu.name"></h3>
            <p class="text-sm text-gray-500 mb-6">Sesuaikan pesanan Sultan-mu</p>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="menu_id" :value="selectedMenu.id">

                <!-- Pilihan Sugar -->
                <div class="mb-4">
                    <p class="font-bold mb-2">Sugar Level</p>
                    <div class="flex gap-2">
                        <label class="flex-1">
                            <input type="radio" name="sugar" value="Normal" class="hidden peer" checked>
                            <span class="block text-center border p-2 rounded-lg peer-checked:bg-yellow-600 peer-checked:text-white">Normal</span>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="sugar" value="Less Sugar" class="hidden peer">
                            <span class="block text-center border p-2 rounded-lg peer-checked:bg-yellow-600 peer-checked:text-white">Less</span>
                        </label>
                    </div>
                </div>

                <!-- Pilihan Ice -->
                <div class="mb-6">
                    <p class="font-bold mb-2">Ice Level</p>
                    <div class="flex gap-2">
                        <label class="flex-1">
                            <input type="radio" name="ice" value="Normal" class="hidden peer" checked>
                            <span class="block text-center border p-2 rounded-lg peer-checked:bg-yellow-600 peer-checked:text-white">Normal</span>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="ice" value="Less Ice" class="hidden peer">
                            <span class="block text-center border p-2 rounded-lg peer-checked:bg-yellow-600 peer-checked:text-white">Less</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full bg-yellow-600 text-white font-bold py-3 rounded-xl shadow-lg">
                    Tambah ke Keranjang - Rp <span x-text="selectedMenu.price"></span>
                </button>
            </form>
        </div>
    </div>
</div>