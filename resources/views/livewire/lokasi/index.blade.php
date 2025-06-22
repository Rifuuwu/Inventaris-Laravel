@if($showDeleteModal && $lokasiToDelete)
        <div class="bg-zinc-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-zinc-800">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Hapus Lokasi</h3>
                    <p class="mb-4 text-zinc-700 dark:text-zinc-300">Yakin ingin menghapus Lokasi <strong>{{ $lokasiToDelete->nama_lokasi }} - {{ $lokasiToDelete->gedung }}</strong>?</p>
                    
                    <div class="flex justify-center space-x-2">
                        <flux:button 
                                    wire:click="closeDeleteModal" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Batal') }}
                        </flux:button>
                        <flux:button 
                                    wire:click="deleteLokasi" 
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
@if(!$showDeleteModal)
<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="border-b border-zinc-200 pb-6 dark:border-zinc-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Manajemen Lokasi') }}
                    </h1>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Kelola daftar lokasi dan gedung untuk inventaris barang.') }}
                    </p>
                </div>
                <!-- Add Button -->
                <flux:button href="lokasi/create" wire:click variant="primary">
                    {{ __('Tambah Lokasi') }}
                </flux:button>
            </div>
        </div>

        <!-- Search -->
        <flux:input 
            wire:model.live="search" 
            label="Cari Lokasi" 
            placeholder="Cari berdasarkan nama lokasi atau gedung..."
            type="text" 
        />

        <!-- Flash message -->
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

        <!-- Tabel Lokasi -->
        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
            <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th wire:click="sortBy('nama_lokasi')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300">
                            Nama Lokasi
                            @if($sortField === 'nama_lokasi')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sortBy('gedung')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300">
                            Gedung
                            @if($sortField === 'gedung')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-800">
                    @forelse($dataLokasi as $lokasi)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-zinc-900 dark:text-zinc-100 text-center">
                                {{ $lokasi->nama_lokasi }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ $lokasi->gedung }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium space-x-2 text-center">
                                <flux:button 
                                    href="lokasi/{{ $lokasi->id }}/edit"
                                    wire:navigate
                                    variant="ghost" 
                                    size="sm"
                                >
                                    {{ __('Edit') }}
                                </flux:button>

                                <flux:button 
                                    wire:click="openDeleteModal({{ $lokasi->id }})" 
                                    variant="danger" 
                                    size="sm"
                                >
                                    {{ __('Hapus') }}
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                Tidak ada data lokasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $dataLokasi->links() }}
        </div>
    </div>
</div>
@endif