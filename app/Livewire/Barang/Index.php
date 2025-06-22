<?php
// app/Livewire/Barang/Index.php
namespace App\Livewire\Barang;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\Penghapusan;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    public $search = ''; // properti untuk pencarian
    public $sortField = 'created_at'; // kolom untuk sorting
    public $sortDirection = 'desc'; //arah sort
    public $selectedBarang = null;
    public $showDetail = false;
    public $showDeleteModal = false;
    public $barangToDelete = null;

    public $barangRusak = false;

    public $deleteReason = '';

    public $showModal=false;

    protected $listeners = ['barangSaved' => 'refreshData'];

    function sortBy($field)
    {
    if ($this->sortField === $field) {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' :'asc'; // arah sorting
        } else {
        $this->sortField = $field;
        $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openDetail($barangId)
    {
        $this->selectedBarang = Barang::with(['kategori', 'lokasi'])->find($barangId);
        $this->showDetail = true;
    }

    public function closeDetail()
    {
        $this->showDetail = false;
        $this->selectedBarang = null;
    }

    public function confirmDelete($barangId, $rusak)
    {
        $barang = Barang::find($barangId);
        
        // Check if item is in mutation process
        if ($barang->isInMutation()) {
            session()->flash('error', 'Barang sedang dalam proses mutasi dan tidak dapat dihapus.');
            return;
        }
        if ($rusak) {
            $this->barangRusak = $barang;
            if ($this->barangRusak->jumlah <= 0) {
                session()->flash('error', 'Stok barang sudah habis, tidak bisa menghapus.');
                $this->barangRusak= null;
            }else{
                $this->showDeleteModal = true;
            }
        }else {
            $this->barangToDelete = $barang;
            $this->showDeleteModal = true;
        }
    }

    public function hapusBarangRusak(){
            // Validate delete reason
            $this->validate([
                'deleteReason' => 'required|string|min:3'
            ], [
                'deleteReason.required' => 'Alasan penghapusan harus diisi',
                'deleteReason.min' => 'Alasan penghapusan minimal 3 karakter'
            ]);
    
            try {
                $this->barangRusak->update([
                    'jumlah'=> 0
                ]);
    
                Penghapusan::create([
                    'barang_id'=> $this->barangRusak->id,
                    'alasan'=> $this->deleteReason,
                    'tanggal' => now()->toDateString()
                ]);
                
                session()->flash('success', 'Barang rusak berhasil dihapus.');
                $this->resetDeleteModal();
            } catch (\Exception $e) {
                session()->flash('error', 'Terjadi kesalahan saat menghapus barang.');
            }
        }


    public function deleteBarang()
    {
        try {
            $this->barangToDelete->delete();
            session()->flash('success', 'Barang berhasil dihapus.');
            $this->resetDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus barang.');
        }
    }

    public function resetDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->barangToDelete = null;
        $this->barangRusak = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetDeleteModal();
        $this->closeDetail();
    }

    public function refreshData()
    {
        // Refresh pagination data
        $this->resetPage();
    }

    public function render()
    {
        $dataBarang = Barang::with(['kategori', 'lokasi'])
            ->where(function($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_barang', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.barang.index', compact('dataBarang'));
    }
}
