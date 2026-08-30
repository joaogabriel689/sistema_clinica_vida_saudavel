<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Clinica;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClinicaCustomizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_logo_and_banner_to_s3(): void
    {
        $this->withoutMiddleware();

        $disk = env('FILESYSTEM_DISK', 's3');
        Storage::fake($disk);

        $admin = User::factory()->create(['role' => 'admin']);
        $clinica = Clinica::create([
            'nome' => 'Clínica Saúde S3',
            'endereco' => 'Rua S3 100',
            'telefone' => '11999990000',
            'cnpj' => '99.888.777/0001-55',
            'slug' => 'clinica-saude-s3',
            'user_id' => $admin->id,
        ]);
        $admin->update(['clinica_id' => $clinica->id]);

        $logoFile = UploadedFile::fake()->image('logo_teste.jpg', 300, 300);
        $bannerFile = UploadedFile::fake()->image('banner_teste.png', 1200, 400);

        $response = $this->actingAs($admin)->post(route('admin.update_clinica'), [
            'nome' => 'Clínica Saúde S3 Modificada',
            'telefone' => '11999990000',
            'endereco' => 'Rua S3 100',
            'cnpj' => '99.888.777/0001-55',
            'cor_primaria' => '#2563eb',
            'descricao' => 'Nova descrição personalizada',
            'logo_file' => $logoFile,
            'banner_file' => $bannerFile,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $clinica->refresh();
        $this->assertEquals('Clínica Saúde S3 Modificada', $clinica->nome);
        $this->assertEquals('#2563eb', $clinica->cor_primaria);
        $this->assertNotNull($clinica->logo_url);
        $this->assertNotNull($clinica->banner_url);

        // Verifica a existência do arquivo no Storage fake
        Storage::disk($disk)->assertExists('logos/' . $logoFile->hashName());
        Storage::disk($disk)->assertExists('banners/' . $bannerFile->hashName());
    }
}
