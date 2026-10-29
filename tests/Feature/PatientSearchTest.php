<?php

namespace Tests\Feature;

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_directory_lists_records(): void
    {
        Patient::factory()->create(['first_name' => 'Ama', 'last_name' => 'Mensah']);

        $response = $this->get('/patients');

        $response->assertStatus(200);
        $response->assertSee('Ama Mensah');
    }

    public function test_patient_directory_filters_by_search_term(): void
    {
        Patient::factory()->create(['first_name' => 'Ama', 'last_name' => 'Mensah']);
        Patient::factory()->create(['first_name' => 'Kojo', 'last_name' => 'Boateng']);

        $response = $this->get('/patients?q=Ama');

        $response->assertOk();
        $response->assertSee('Ama Mensah');
        $response->assertDontSee('Kojo Boateng');
    }

    public function test_patient_directory_shows_empty_state(): void
    {
        Patient::factory()->create();

        $this->get('/patients?q=not-a-patient')
            ->assertOk()
            ->assertSee('No patients matched');
    }

    public function test_csv_export_respects_current_filters(): void
    {
        Patient::factory()->create(['first_name' => 'Ama', 'last_name' => 'Mensah', 'status' => 'active']);
        Patient::factory()->create(['first_name' => 'Kojo', 'last_name' => 'Boateng', 'status' => 'inactive']);

        $response = $this->get('/patients/export?q=Ama&status=active');

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $response->assertDownload();
        $this->assertStringContainsString('Ama', $response->streamedContent());
        $this->assertStringNotContainsString('Kojo', $response->streamedContent());
    }
}
