<?php

namespace App\Livewire\Lokasi;

use App\Models\Lokasi;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Form extends Component
{
    #[Validate('required|string|max:255')]
    public $nama_lokasi = '';

    #[Validate('required|string|max:255')]
    public $gedung = '';

    public $lokasi_id = null;
    public $isEdit = false;

    public function mount($lokasi = null)
    {
        if ($lokasi) {
            $this->lokasi_id = $lokasi;
            $this->isEdit = true;
            $this->loadLokasi();
        }
    }

    public function loadLokasi()
    {
        $lokasi = Lokasi::findOrFail($this->lokasi_id);
        $this->nama_lokasi = $lokasi->nama_lokasi;
        $this->gedung = $lokasi->gedung;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            $lokasi = Lokasi::findOrFail($this->lokasi_id);
            $lokasi->update([
                'nama_lokasi' => $this->nama_lokasi,
                'gedung' => $this->gedung,
            ]);
            session()->flash('success', 'Lokasi berhasil diperbarui.');
        } else {
            Lokasi::create([
                'nama_lokasi' => $this->nama_lokasi,
                'gedung' => $this->gedung,
            ]);
            session()->flash('success', 'Lokasi berhasil ditambahkan.');
        }

        return $this->redirectRoute('lokasi.index', navigate: true);
    }

    public function cancel()
    {
        return $this->redirectRoute('lokasi.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.lokasi.form');
    }
}
