<?php

namespace Tests\Feature;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdukControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_update_a_product(): void
    {
        $user = User::factory()->create();
        $kategoriId = \DB::table('kategori')->insertGetId([
            'nama_kategori' => 'Kategori Tes',
        ]);
        $produk = Produk::create([
            'kategori_id' => $kategoriId,
            'user_id' => $user->id,
            'status' => 0,
            'nama_produk' => 'Produk Lama',
            'detail' => 'Detail produk',
            'harga' => 10000,
            'stok' => 5,
            'berat' => 1,
            'foto' => 'produk.jpg',
        ]);

        $this->actingAs($user)
            ->put(route('backend.produk.update', $produk), [
                'nama_produk' => 'Produk Baru',
                'kategori_id' => $kategoriId,
                'status' => 1,
                'detail' => 'Detail diperbarui',
                'harga' => 15000,
                'berat' => 1.5,
                'stok' => 8,
            ])
            ->assertRedirect(route('backend.produk.index'));

        $this->assertDatabaseHas('produk', [
            'id' => $produk->id,
            'user_id' => $user->id,
            'nama_produk' => 'Produk Baru',
            'status' => 1,
        ]);
    }
}
