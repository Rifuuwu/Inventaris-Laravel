<?php
// app/Livewire/Barang/Form.php
namespace App\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\RiwayatMutasi;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $barangId;
    public $nama = '';
    public $kode_barang = '';
    public $kategori_id = '';
    public $lokasi_id = '';
    public $jumlah = '';
    public $isEdit = false;
    public $isMutasi = false;
    public $originalLokasiId = '';
    public $newLokasiId = '';
    public $tanggalMutasi = '';

    protected function rules()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'kode_barang' => $this->isEdit ? 
                'required|string|max:255|unique:barang,kode_barang,' . $this->barangId :
                'required|string|max:255|unique:barang,kode_barang',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'jumlah' => 'required|integer|min:1'
        ];

        if ($this->isMutasi) {
            $rules = [
                'newLokasiId' => 'required|exists:lokasi,id|different:originalLokasiId',
                'tanggalMutasi' => 'required|date',
            ];
        }

        return $rules;
    }

    protected $messages = [
        'nama.required' => 'Nama barang harus diisi',
        'kode_barang.required' => 'Kode barang harus diisi',
        'kategori_id.required' => 'Kategori harus dipilih',
        'lokasi_id.required' => 'Lokasi harus dipilih',
        'jumlah.required' => 'Jumlah harus diisi',
        'jumlah.min' => 'Jumlah minimal 1',
        'newLokasiId.required' => 'Lokasi tujuan harus dipilih',
        'newLokasiId.different' => 'Lokasi tujuan harus berbeda dengan lokasi asal',
        'tanggalMutasi.required' => 'Tanggal mutasi harus diisi',
        'tanggalMutasi.date' => 'Format tanggal tidak valid'
    ];

    public function mount($id = null)
    {
        // Deteksi apakah ini mutasi berdasarkan URL
        $this->isMutasi = request()->routeIs('barang.mutasi');
        
        if ($id) {
            $this->barangId = $id;
            
            if ($this->isMutasi) {
                $this->loadBarangForMutasi();
            } else {
                $this->isEdit = true;
                $this->loadBarang();
            }
        }

        // Set default tanggal mutasi
        if ($this->isMutasi) {
            $this->tanggalMutasi = now()->toDateString();
        }
    }

    public function loadBarang()
    {
        $barang = Barang::findOrFail($this->barangId);
        $this->nama = $barang->nama;
        $this->kode_barang = $barang->kode_barang;
        $this->kategori_id = $barang->kategori_id;
        $this->lokasi_id = $barang->lokasi_id;
        $this->originalLokasiId = $barang->lokasi_id;
        $this->jumlah = $barang->jumlah;
    }

    public function loadBarangForMutasi()
    {
        $barang = Barang::with(['kategori', 'lokasi'])->findOrFail($this->barangId);
        $this->nama = $barang->nama;
        $this->kode_barang = $barang->kode_barang;
        $this->kategori_id = $barang->kategori_id;
        $this->originalLokasiId = $barang->lokasi_id;
        $this->jumlah = $barang->jumlah;
        
        // Set lokasi tujuan ke lokasi yang sama dulu (akan diubah user)
        $this->newLokasiId = $barang->lokasi_id;
    }

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                if ($this->isMutasi) {
                    // Handle mutasi logic
                    $barang = Barang::findOrFail($this->barangId);
                    
                    // Update lokasi barang
                    $barang->update([
                        'lokasi_id' => $this->newLokasiId,
                    ]);

                    // Simpan riwayat mutasi
                    RiwayatMutasi::create([
                        'barang_id' => $barang->id,
                        'asal' => $this->originalLokasiId,
                        'tujuan' => $this->newLokasiId,
                        'tanggal' => $this->tanggalMutasi,
                    ]);

                    session()->flash('success', 'Barang berhasil dimutasi.');
                    
                } elseif ($this->isEdit) {
                    // Handle edit logic
                    $barang = Barang::findOrFail($this->barangId);
                    
                    $barang->update([
                        'nama' => $this->nama,
                        'kode_barang' => $this->kode_barang,
                        'kategori_id' => $this->kategori_id,
                        'lokasi_id' => $this->lokasi_id,
                        'jumlah' => $this->jumlah
                    ]);

                    session()->flash('success', 'Data barang berhasil diperbarui.');
                    
                } else {
                    // Handle create logic
                    Barang::create([
                        'nama' => $this->nama,
                        'kode_barang' => $this->kode_barang,
                        'kategori_id' => $this->kategori_id,
                        'lokasi_id' => $this->lokasi_id,
                        'jumlah' => $this->jumlah
                    ]);

                    session()->flash('success', 'Barang berhasil ditambahkan.');
                }
            });

            return $this->redirectRoute('barang.index', navigate: true);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return $this->redirectRoute('barang.index', navigate: true);
    }

    public function render()
    {
        $kategoriList = Kategori::orderBy('nama_kategori')->get();
        $lokasiList = Lokasi::orderBy('nama_lokasi')->get();

        return view('livewire.barang.form', compact('kategoriList', 'lokasiList'));
    }
}
