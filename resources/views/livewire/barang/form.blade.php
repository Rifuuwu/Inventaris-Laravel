<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="border-b border-zinc-200 pb-6 dark:border-zinc-700">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                @if($isMutasi)
                    {{ __('Mutasi Barang') }}
                @elseif($isEdit)
                    {{ __('Edit Barang') }}
                @else
                    {{ __('Tambah Barang') }}
                @endif
            </h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                @if($isMutasi)
                    {{ __('Pindahkan barang ke lokasi baru.') }}
                @elseif($isEdit)
                    {{ __('Perbarui informasi barang.') }}
                @else
                    {{ __('Tambahkan barang baru untuk inventaris.') }}
                @endif
            </p>
        </div>

        <!-- Flash Messages -->
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

        <!-- Form Card -->
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <div class="p-6">
                <form wire:submit="save" class="space-y-6">
                    
                    @if($isMutasi)
                        <!-- Mutasi Form -->
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Informasi Barang (Read Only) -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Informasi Barang</h3>
                                <div class="grid gap-4 md:grid-cols-2 bg-zinc-50 dark:bg-zinc-700 p-4 rounded-md">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Kode Barang</label>
                                        <p class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $kode_barang }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nama Barang</label>
                                        <p class="mt-1 text-sm text-zinc-900 dark:text-zinc-100">{{ $nama }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Lokasi Asal -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Lokasi Asal</label>
                                <div class="bg-zinc-100 dark:bg-zinc-600 p-3 rounded-md">
                                    @php
                                        $lokasiAsal = $lokasiList->find($originalLokasiId);
                                    @endphp
                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $lokasiAsal ? $lokasiAsal->nama_lokasi . ' - ' . $lokasiAsal->gedung : 'Lokasi tidak ditemukan' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Lokasi Tujuan -->
                            <div>
                                <flux:select 
                                    wire:model="newLokasiId"
                                    label="Lokasi Tujuan"
                                    placeholder="Pilih lokasi tujuan"
                                    required
                                >
                                    <option value="">Pilih Lokasi Tujuan</option>
                                    @foreach($lokasiList as $lokasi)
                                        <option value="{{ $lokasi->id }}" {{ $lokasi->id == $originalLokasiId ? 'disabled' : '' }}>
                                            {{ $lokasi->nama_lokasi }} - {{ $lokasi->gedung }}
                                            {{ $lokasi->id == $originalLokasiId ? ' (Lokasi Saat Ini)' : '' }}
                                        </option>
                                    @endforeach
                                </flux:select>
                                @error('newLokasiId')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Mutasi -->
                            <div>
                                <flux:input 
                                    wire:model="tanggalMutasi"
                                    label="Tanggal Mutasi"
                                    type="date"
                                    required
                                />
                                @error('tanggalMutasi')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @else
                        <!-- Form Fields Normal (Create/Edit) -->
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Nama Barang -->
                            <div>
                                <flux:input 
                                    wire:model="nama"
                                    label="Nama Barang"
                                    placeholder="Masukkan nama barang"
                                    required
                                />
                                @error('nama')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kode Barang -->
                            <div>
                                <flux:input 
                                    wire:model="kode_barang"
                                    label="Kode Barang"
                                    placeholder="Masukkan kode barang"
                                    required
                                />
                                @error('kode_barang')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <flux:select 
                                    wire:model="kategori_id"
                                    label="Kategori"
                                    placeholder="Pilih kategori"
                                    required
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoriList as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </flux:select>
                                @error('kategori_id')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lokasi -->
                            <div>
                                <flux:select 
                                    wire:model="lokasi_id"
                                    label="Lokasi"
                                    placeholder="Pilih lokasi"
                                    required
                                >
                                    <option value="">Pilih Lokasi</option>
                                    @foreach($lokasiList as $lokasi)
                                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }} - {{ $lokasi->gedung }}</option>
                                    @endforeach
                                </flux:select>
                                @error('lokasi_id')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jumlah -->
                            <div class="md:col-span-2">
                                <flux:input 
                                    wire:model="jumlah"
                                    label="Jumlah"
                                    placeholder="Masukkan jumlah barang"
                                    type="number"
                                    min="1"
                                    required
                                />
                                @error('jumlah')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 border-t border-zinc-200 pt-6 dark:border-zinc-700">
                        <flux:button 
                            wire:click="cancel" 
                            variant="ghost"
                            type="button"
                        >
                            {{ __('Batal') }}
                        </flux:button>
                        
                        <flux:button 
                            type="submit" 
                            variant="primary"
                            dusk="simpan-button"
                        >
                            @if($isMutasi)
                                {{ __('Mutasi') }}
                            @elseif($isEdit)
                                {{ __('Perbarui') }}
                            @else
                                {{ __('Simpan') }}
                            @endif
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
