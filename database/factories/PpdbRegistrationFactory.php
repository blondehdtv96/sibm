<?php

namespace Database\Factories;

use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PpdbRegistration>
 */
class PpdbRegistrationFactory extends Factory
{
    protected $model = PpdbRegistration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_number' => 'PPDB' . date('Y') . fake()->unique()->numberBetween(1000, 9999),
            'student_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'birth_date' => fake()->dateTimeBetween('-15 years', '-12 years')->format('Y-m-d'),
            'address' => fake()->address(),
            'parent_name' => fake()->name(),
            'parent_phone' => fake()->phoneNumber(),
            'documents' => json_encode([
                'birth_certificate' => 'documents/sample-birth-cert.pdf',
                'family_card' => 'documents/sample-family-card.pdf',
                'photo' => 'documents/sample-photo.jpg',
            ]),
            'status' => 'pending',
            'verified_at' => null,
            'verified_by' => null,
            'notes' => null,
        ];
    }

    /**
     * Indicate that the registration is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Indicate that the registration is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => User::factory()->admin(),
            'notes' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the registration is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'verified_at' => null,
            'verified_by' => null,
        ]);
    }
}
