<?php

namespace Database\Seeders;

use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;

class PpdbRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Create pending registrations
        PpdbRegistration::factory()->pending()->count(10)->create();

        // Create verified registrations
        PpdbRegistration::factory()->verified()->count(5)->create([
            'verified_by' => $admin->id,
        ]);

        // Create rejected registrations
        PpdbRegistration::factory()->rejected()->count(2)->create([
            'verified_by' => $admin->id,
        ]);
    }
}
