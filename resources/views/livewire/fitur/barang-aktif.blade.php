<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="border-b border-zinc-200 pb-6 dark:border-zinc-700">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ __('Laporan Barang Aktif') }}
                    </h1>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Daftar barang aktif dalam inventaris.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Filter dan Search -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Search -->
            <div>
                <flux:input 
                    wire:model.live="search" 
                    label="Cari Barang" 
                    placeholder="Cari berdasarkan nama barang atau kode barang..."
                    type="text" 
                />
            </div>

            <!-- Filter Lokasi -->
            <div>
                <flux:select 
                    wire:model.live="filterLokasi"
                    label="Filter Lokasi"
                    placeholder="Semua Lokasi"
                >
                    <option value="">Semua Lokasi</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }} - {{ $lokasi->gedung }}</option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid gap-4 md:grid-cols-3">
            <!-- Total Barang -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Barang</h3>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $totalBarang }}</p>
                    </div>
                </div>
            </div>

            <!-- Barang Aktif -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Barang Aktif</h3>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalAktif }}</p>
                    </div>
                </div>
            </div>

            <!-- Barang Tidak Aktif -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Barang Tidak Aktif</h3>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $totalTidakAktif }}</p>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Tabel Barang Aktif -->
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
                        <th class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300">
                            Lokasi
                        </th>
                        <th wire:click="sortBy('jumlah')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300">
                            Jumlah Barang
                            @if($sortField === 'jumlah')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Status
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
                                {{ $barang->lokasi->nama_lokasi }} - {{ $barang->lokasi->gedung }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                                {{ $barang->jumlah }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-center">
                                @if($barang->isActive())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Tidak Aktif
                                    </span>
                                @endif
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
</div>
