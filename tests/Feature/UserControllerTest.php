<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_user_forms_and_list(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('backend.user.index'))
            ->assertOk()
            ->assertSee('Data User');

        $this->get(route('backend.user.create'))->assertOk();
        $this->get(route('backend.user.edit', $admin))->assertOk();
    }

    public function test_authenticated_user_can_create_update_and_delete_a_user(): void
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $this->post(route('backend.user.store'), [
            'nama' => 'User Tes',
            'email' => 'user@example.com',
            'role' => '2',
            'status' => '1',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'hp' => '081234567890',
        ])->assertRedirect(route('backend.user.index'));

        $user = User::where('email', 'user@example.com')->firstOrFail();
        $this->assertSame('User Tes', $user->nama);
        $this->assertTrue(password_verify('Password123!', $user->password));

        $this->put(route('backend.user.update', $user), [
            'nama' => 'Nama Diperbarui',
            'email' => 'user@example.com',
            'role' => '1',
            'status' => '0',
            'hp' => '081234567890',
        ])->assertRedirect(route('backend.user.index'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nama' => 'Nama Diperbarui',
            'role' => 1,
            'status' => 0,
        ]);

        $this->delete(route('backend.user.destroy', $user))
            ->assertRedirect(route('backend.user.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
