<?php

namespace Tests\Feature;

use App\Models\PpdbRegistration;
use App\Models\PpdbSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpdbManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_ppdb_settings(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/ppdb-settings');

        $response->assertStatus(200);
        $response->assertViewIs('admin.ppdb-settings.index');
    }

    public function test_admin_can_create_ppdb_setting(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/ppdb-settings', [
            'registration_start' => now()->format('Y-m-d'),
            'registration_end' => now()->addMonth()->format('Y-m-d'),
            'requirements' => json_encode(['Birth Certificate', 'Family Card']),
            'status' => 'active',
        ]);

        $response->assertRedirect('/admin/ppdb-settings');
        $this->assertDatabaseHas('ppdb_settings', [
            'status' => 'active',
        ]);
    }

    public function test_admin_can_view_ppdb_registrations(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/ppdb-registrations');

        $response->assertStatus(200);
        $response->assertViewIs('admin.ppdb-registrations.index');
    }

    public function test_admin_can_view_single_registration(): void
    {
        $registration = PpdbRegistration::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/ppdb-registrations/{$registration->id}");

        $response->assertStatus(200);
        $response->assertViewIs('admin.ppdb-registrations.show');
        $response->assertViewHas('registration', $registration);
    }

    public function test_admin_can_verify_registration(): void
    {
        $registration = PpdbRegistration::factory()->pending()->create();

        $response = $this->actingAs($this->admin)->patch("/admin/ppdb-registrations/{$registration->id}/verify");

        $response->assertRedirect();
        $this->assertDatabaseHas('ppdb_registrations', [
            'id' => $registration->id,
            'status' => 'verified',
        ]);
    }

    public function test_admin_can_reject_registration(): void
    {
        $registration = PpdbRegistration::factory()->pending()->create();

        $response = $this->actingAs($this->admin)->patch("/admin/ppdb-registrations/{$registration->id}/reject", [
            'notes' => 'Incomplete documents',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ppdb_registrations', [
            'id' => $registration->id,
            'status' => 'rejected',
        ]);
    }

    public function test_public_can_view_ppdb_form_when_active(): void
    {
        PpdbSetting::factory()->active()->create();

        $response = $this->get('/ppdb/register');

        $response->assertStatus(200);
        $response->assertViewIs('public.ppdb.register');
    }

    public function test_public_cannot_register_when_ppdb_inactive(): void
    {
        PpdbSetting::factory()->inactive()->create();

        $response = $this->get('/ppdb/register');

        $response->assertStatus(200);
        $response->assertViewIs('public.ppdb.not-started');
    }

    public function test_public_can_submit_ppdb_registration(): void
    {
        PpdbSetting::factory()->active()->create();

        $response = $this->post('/ppdb/register', [
            'student_name' => 'Test Student',
            'email' => 'student@example.com',
            'phone' => '081234567890',
            'birth_date' => '2010-01-01',
            'address' => 'Test Address',
            'parent_name' => 'Parent Name',
            'parent_phone' => '081234567891',
        ]);

        $response->assertRedirect('/ppdb/success');
        $this->assertDatabaseHas('ppdb_registrations', [
            'student_name' => 'Test Student',
            'email' => 'student@example.com',
        ]);
    }

    public function test_public_can_check_registration_status(): void
    {
        $registration = PpdbRegistration::factory()->create();

        $response = $this->post('/ppdb/check-status', [
            'registration_number' => $registration->registration_number,
            'email' => $registration->email,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('public.ppdb.status');
        $response->assertViewHas('registration', $registration);
    }
}
