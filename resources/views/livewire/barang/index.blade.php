<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="border-b border-zinc-200 pb-6 dark:border-zinc-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Manajemen Barang') }}
                    </h1>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Kelola daftar inventaris barang.') }}
                    </p>
                </div>
                <!-- Add Button -->
                <flux:button href="barang/create" wire:navigate variant="primary">
                    {{ __('Tambah Barang') }}
                </flux:button>
            </div>
        </div>


        <!-- Delete Modal -->
    @if($showDeleteModal && $barangToDelete)
        <div class="bg-zinc-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-zinc-800">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Hapus Barang</h3>
                    <p class="mb-4 text-zinc-700 dark:text-zinc-300">Yakin ingin menghapus barang <strong>{{ $barangToDelete->nama }}</strong>?</p>
                    
                    <div class="flex justify-center space-x-2">
                        <flux:button 
                                    wire:click="closeModal" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Batal') }}
                        </flux:button>
                        <flux:button 
                                    wire:click="deleteBarang" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Hapus') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showDeleteModal && $barangRusak)
        <div class="bg-zinc-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-zinc-800">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Hapus Barang Rusak</h3>
                    <p class="mb-4 text-zinc-700 dark:text-zinc-300">Yakin ingin menghapus barang <strong>{{ $barangRusak->nama }}</strong> karena rusak?</p>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Penghapusan <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="deleteReason" 
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Masukkan alasan penghapusan..."></textarea>
                        @error('deleteReason') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex justify-center space-x-2">
                        <flux:button 
                                    wire:click="closeModal" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Batal') }}
                        </flux:button>
                        <flux:button 
                                    wire:click="hapusBarangRusak" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Hapus') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Detail Modal -->
    @if($showDetail && $selectedBarang && !$showDeleteModal)
        <div class="border-b border-zinc-200 pb-6 dark:border-zinc-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Detail Barang') }}
                    </h1>
            </div>
        </div>
        <div class="bg-zinc-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-zinc-800">
                <div class="mt-3">
                    <div class="space-y-2">
                        <p><strong>Kode:</strong> {{ $selectedBarang->kode_barang }}</p>
                        <p><strong>Nama:</strong> {{ $selectedBarang->nama }}</p>
                        <p><strong>Kategori:</strong> {{ $selectedBarang->kategori->nama_kategori }}</p>
                        <p><strong>Lokasi:</strong> {{ $selectedBarang->lokasi->nama_lokasi }} - {{ $selectedBarang->lokasi->gedung }}</p>
                        <p><strong>Jumlah:</strong> {{ $selectedBarang->jumlah }}</p>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <flux:button 
                                    wire:click="closeModal" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Tutup') }}
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    

    @if(!$showDeleteModal)
        <!-- Search -->
        <flux:input 
            wire:model.live="search" 
            label="Cari Barang" 
            placeholder="Cari berdasarkan nama Barang atau kode barang..."
            type="text" 
        />

        
        @if (session('success'))
            <div class="rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                <div class="text-sm text-green-700 dark:text-green-400">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-md bg-red-50 p-4 dark:bg-red-900/20">
                <div class="text-sm text-red-700 dark:text-red-400">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Tabel Barang -->
        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
            <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            No
                        </th>
                        <th wire:click="sortBy('kode_barang')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300">
                            Kode Barang
                            @if($sortField === 'kode_barang')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sortBy('nama')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300">
                            Nama Barang
                            @if($sortField === 'nama')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sortBy('jumlah')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300">
                            Jumlah Barang
                            @if($sortField === 'jumlah')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-800">
                    @forelse($dataBarang as $barang)
                        <tr class="hover: cursor-pointer" wire:click="openDetail({{ $barang->id }})">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ ($dataBarang->currentPage() - 1) * $dataBarang->perPage() + $loop->iteration }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 text-center">
                                {{ $barang->kode_barang }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ $barang->nama }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ $barang->jumlah }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium space-x-2 text-center"
                                onclick="event.stopPropagation()">
                                <flux:button 
                                    href="barang/{{ $barang->id }}/edit"
                                    wire:navigate
                                    variant="ghost" 
                                    size="sm"
                                    wire:click.stop
                                >
                                    {{ __('Edit') }}
                                </flux:button>

                                <flux:button 
                                    wire:click.stop="confirmDelete({{ $barang->id }},{{ 1 }})" 
                                    variant="primary" 
                                    color="yellow"
                                    size="sm"
                                >
                                    {{ __('Rusak') }}
                                </flux:button>

                                <flux:button 
                                    href="barang/{{ $barang->id }}/mutasi"
                                    wire:navigate
                                    variant="primary" 
                                    color="yellow"
                                    size="sm"
                                >
                                    {{ __('Mutasi') }}
                                </flux:button>

                                <flux:button 
                                    wire:click.stop="confirmDelete({{ $barang->id }},{{ 0 }})" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Hapus') }}
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                Tidak ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        <div class="mt-6">
            {{ $dataBarang->links() }}
        </div>
    </div>
    @endif
</div>