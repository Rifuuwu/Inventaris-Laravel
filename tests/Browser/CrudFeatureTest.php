<?php

namespace Laravel\Dusk\Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;



class CrudFeatureTest extends DuskTestCase{
    public function testBisaAksesHomePage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPathIs('/')
                    ->assertSee('Laravel');
        });
    }

    public function testBisaAksesLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->assertSee('Log in');
        }); 
    }

    
    public function testBisaLoginBenar()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
            ->assertPathIs('/login')
            ->type('email', 'test@example.com')
            ->type('password', 'password')
            ->press('@login-button')
            ->waitForText('Dashboard')
            ->assertPathIs('/dashboard');
        });
    }
    
    public function testBukaBarang()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/barang')
                    ->assertPathIs('/barang')
                    ->assertSee('Barang');
        });
    }

    public function testTambahBarang()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/barang')
                    ->assertPathIs('/barang')
                    ->press('@tambahbarang-button')
                    ->waitForText('Tambah Barang')
                    ->assertPathIs('/barang/create')
                    ->type('nama', 'cobadusk')
                    ->type('kode_barang', 'BRG-090DUSK')
                    ->select('kategori_id')
                    ->select('lokasi_id')
                    ->type('jumlah', '10')
                    ->press('@simpan-button')
                    ->waitForText('Barang berhasil ditambahkan')
                    ->assertPathIs('/barang')
                    ->assertSee('cobadusk');
        });
    }

    public function testCekBarang()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/barang')
                    ->assertPathIs('/barang')
                    ->assertSee('cobadusk');
        });
    }

    public function testUpdateBarang()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/barang')
                    ->assertPathIs('/barang')
                    ->clickLink('Edit')
                    ->waitForText('Edit Barang')
                    ->assertPathIs('/barang/*/edit')
                    ->type('nama', 'cobaduskupdated')
                    ->press('@simpan-button')
                    ->waitForText('Data barang berhasil diperbarui')
                    ->assertPathIs('/barang')
                    ->assertSee('cobaduskupdated');
        });
    }

    public function testHapusBarang()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/barang')
                    ->assertPathIs('/barang')
                    ->assertSee('cobaduskupdated')
                    ->with('table', function ($table) {
                        $table->assertSee('cobaduskupdated');
                        $table->press('Hapus');
                    })
                    ->waitForText('Yakin')
                    ->press('Hapus')
                    ->waitForText('Barang berhasil dihapus')
                    ->assertPathIs('/barang')
                    ->assertDontSee('cobaduskupdated');
        });
    }

}
