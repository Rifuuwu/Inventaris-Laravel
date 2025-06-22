<?php

namespace App\Livewire\Fitur;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\Lokasi;

class BarangAktif extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filterLokasi = '';

    protected $paginationTheme = 'tailwind';

    function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterLokasi()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Barang::with(['kategori', 'lokasi'])
            ->where(function($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_barang', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterLokasi, function($query) {
                $query->where('lokasi_id', $this->filterLokasi);
            });

        // Get all items for counting (without pagination)
        $allItems = $query->get();
        
        // Count active and inactive items
        $totalBarang = $allItems->count();
        $totalAktif = $allItems->filter(function($barang) {
            return $barang->isActive();
        })->count();
        $totalTidakAktif = $totalBarang - $totalAktif;
        
        // Get paginated data
        $dataBarang = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $lokasiList = Lokasi::orderBy('nama_lokasi')->get();
        
        // Get selected location name
        $selectedLokasi = $this->filterLokasi ? 
            $lokasiList->find($this->filterLokasi) : null;

        return view('livewire.fitur.barang-aktif', compact(
            'dataBarang', 
            'lokasiList', 
            'totalBarang', 
            'totalAktif', 
            'totalTidakAktif', 
            'selectedLokasi'
        ));
    }
}
