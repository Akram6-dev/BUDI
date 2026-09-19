<?php

namespace Tests\Feature;

use App\Models\Tamu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuestFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_form_renders_successfully(): void
    {
        $response = $this->get('/guest-form');
        $response->assertStatus(200);
        $response->assertSee('Formulir Kehadiran Tamu');
        $response->assertSee('Instansi');
        $response->assertSee('Sekolah');
        $response->assertSee('Senang');
    }

    public function test_legacy_photo_and_signature_routes_redirect_to_guest_form(): void
    {
        $this->get('/guest-photo')->assertRedirect('/guest-form');
        $this->get('/guest-signature')->assertRedirect('/guest-form');
    }

    public function test_submit_fails_without_required_fields(): void
    {
        $response = $this->post('/guest-form', []);
        $response->assertSessionHasErrors(['nama', 'status', 'ulasan', 'foto_base64']);
        $this->assertEquals(0, Tamu::count());
    }

    public function test_successful_instansi_guest_submission(): void
    {
        Storage::fake('public');

        $sampleBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $response = $this->post('/guest-form', [
            'nama' => 'Rahmat Hidayat',
            'status' => 'instansi',
            'instansi' => 'Dinas Pendidikan Jawa Barat',
            'ulasan' => 'senang',
            'foto_base64' => $sampleBase64,
            'tanda_tangan_base64' => $sampleBase64,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tamu', [
            'nama' => 'Rahmat Hidayat',
            'status' => 'instansi',
            'instansi' => 'Dinas Pendidikan Jawa Barat',
            'ulasan' => 'senang',
        ]);

        $tamu = Tamu::first();
        $this->assertNotNull($tamu);
        Storage::disk('public')->assertExists($tamu->foto);
        Storage::disk('public')->assertExists($tamu->tanda_tangan);
    }

    public function test_successful_sekolah_guest_submission(): void
    {
        Storage::fake('public');

        $sampleBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $response = $this->post('/guest-form', [
            'nama' => 'Annisa Putri',
            'status' => 'sekolah',
            'asal_sekolah' => 'SMKN 1 Subang',
            'ulasan' => 'biasa',
            'foto_base64' => $sampleBase64,
            'tanda_tangan_base64' => null,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('tamu', [
            'nama' => 'Annisa Putri',
            'status' => 'sekolah',
            'asal_sekolah' => 'SMKN 1 Subang',
            'ulasan' => 'biasa',
        ]);
    }
}

