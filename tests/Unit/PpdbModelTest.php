<?php

namespace Tests\Unit;

use App\Models\PpdbRegistration;
use App\Models\PpdbSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpdbModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_ppdb_registration_can_be_created(): void
    {
        $registration = PpdbRegistration::factory()->create([
            'student_name' => 'Test Student',
        ]);

        $this->assertDatabaseHas('ppdb_registrations', [
            'student_name' => 'Test Student',
        ]);
    }

    public function test_ppdb_registration_has_unique_registration_number(): void
    {
        $registration1 = PpdbRegistration::factory()->create();
        $registration2 = PpdbRegistration::factory()->create();

        $this->assertNotEquals($registration1->registration_number, $registration2->registration_number);
    }

    public function test_ppdb_registration_has_default_pending_status(): void
    {
        $registration = PpdbRegistration::factory()->create();

        $this->assertEquals('pending', $registration->status);
    }

    public function test_ppdb_registration_can_be_verified(): void
    {
        $admin = User::factory()->admin()->create();
        $registration = PpdbRegistration::factory()->verified()->create([
            'verified_by' => $admin->id,
        ]);

        $this->assertEquals('verified', $registration->status);
        $this->assertNotNull($registration->verified_at);
        $this->assertEquals($admin->id, $registration->verified_by);
    }

    public function test_ppdb_registration_can_be_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        $registration = PpdbRegistration::factory()->rejected()->create([
            'verified_by' => $admin->id,
        ]);

        $this->assertEquals('rejected', $registration->status);
        $this->assertNotNull($registration->verified_at);
    }

    public function test_ppdb_registration_belongs_to_verifier(): void
    {
        $admin = User::factory()->admin()->create();
        $registration = PpdbRegistration::factory()->verified()->create([
            'verified_by' => $admin->id,
        ]);

        $this->assertInstanceOf(User::class, $registration->verifier);
        $this->assertEquals($admin->id, $registration->verifier->id);
    }

    public function test_ppdb_setting_can_be_created(): void
    {
        $setting = PpdbSetting::factory()->create();

        $this->assertDatabaseHas('ppdb_settings', [
            'id' => $setting->id,
        ]);
    }

    public function test_ppdb_setting_can_be_active(): void
    {
        $setting = PpdbSetting::factory()->active()->create();

        $this->assertEquals('active', $setting->status);
    }

    public function test_ppdb_setting_has_registration_dates(): void
    {
        $setting = PpdbSetting::factory()->create();

        $this->assertNotNull($setting->registration_start);
        $this->assertNotNull($setting->registration_end);
    }
}
