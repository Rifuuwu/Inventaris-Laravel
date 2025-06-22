<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="border-b border-zinc-200 pb-6 dark:border-zinc-700">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">
                {{ $isEdit ? __('Edit Lokasi') : __('Tambah Lokasi') }}
            </h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                {{ $isEdit ? __('Perbarui informasi lokasi.') : __('Tambahkan lokasi baru untuk inventaris.') }}
            </p>
        </div>

        <!-- Form Card -->
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <div class="p-6">
                <form wire:submit="save" class="space-y-6">
                    <!-- Form Fields -->
                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Nama Lokasi -->
                        <div>
                            <flux:input 
                                wire:model="nama_lokasi"
                                label="Nama Lokasi"
                                placeholder="Masukkan nama lokasi"
                                required
                            />
                            @error('nama_lokasi')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gedung -->
                        <div>
                            <flux:input 
                                wire:model="gedung"
                                label="Gedung"
                                placeholder="Masukkan nama gedung"
                                required
                            />
                            @error('gedung')
                                <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

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
                        >
                            {{ $isEdit ? __('Perbarui') : __('Simpan') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
