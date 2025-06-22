<?php

namespace App\Livewire\Lokasi;

use App\Models\Lokasi;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;

    public $search = ''; // properti untuk pencarian
    public $sortField = 'created_at'; // kolom untuk sorting
    public $sortDirection = 'desc'; //arah sort

    public $showDeleteModal = false;

    public $lokasiToDelete = null;

    public function openDeleteModal($id)
    {
        $this->lokasiToDelete = Lokasi::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteLokasi()
    {
        try {
            $this->lokasiToDelete->delete();
            session()->flash('success', 'Lokasi berhasil dihapus.');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus lokasi.');
        }

    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->lokasiToDelete = null;
    }

     function sortBy($field)
    {
    if ($this->sortField === $field) {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' :'asc'; // arah sorting
        } else {
        $this->sortField = $field;
        $this->sortDirection = 'asc';
    }
    }

    public function render()
    {
        $dataLokasi = Lokasi::when($this->search, fn($q) =>
        $q->where('nama_lokasi', 'like', '%' . $this->search . '%')
        ->orWhere('gedung', 'like', '%' . $this->search . '%')
        )
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10); 
        return view('livewire.lokasi.index',compact('dataLokasi'));
    }
}