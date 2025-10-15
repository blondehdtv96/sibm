<?php

namespace Database\Factories;

use App\Models\PpdbSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PpdbSetting>
 */
class PpdbSettingFactory extends Factory
{
    protected $model = PpdbSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = now()->addMonth();
        $endDate = $startDate->copy()->addMonths(2);
        
        return [
            'registration_start' => $startDate->format('Y-m-d'),
            'registration_end' => $endDate->format('Y-m-d'),
            'requirements' => json_encode([
                'Birth Certificate',
                'Family Card (KK)',
                'Student Photo 3x4',
                'Report Card from Previous School',
                'Health Certificate',
            ]),
            'status' => 'inactive',
        ];
    }

    /**
     * Indicate that the PPDB is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'registration_start' => now()->subWeek()->format('Y-m-d'),
            'registration_end' => now()->addMonth()->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the PPDB is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
