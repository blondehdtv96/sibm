<?php

namespace Tests\Unit;

use App\Models\Competency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompetencyModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_competency_can_be_created(): void
    {
        $competency = Competency::factory()->create([
            'name' => 'Test Competency',
        ]);

        $this->assertDatabaseHas('competencies', [
            'name' => 'Test Competency',
        ]);
    }

    public function test_competency_slug_is_unique(): void
    {
        Competency::factory()->create(['slug' => 'unique-competency']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Competency::factory()->create(['slug' => 'unique-competency']);
    }

    public function test_competency_has_default_active_status(): void
    {
        $competency = Competency::create([
            'name' => 'Active Competency',
            'slug' => 'active-competency',
            'description' => 'Description',
        ]);

        $this->assertEquals('active', $competency->status);
    }

    public function test_competency_can_be_inactive(): void
    {
        $competency = Competency::factory()->inactive()->create();

        $this->assertEquals('inactive', $competency->status);
    }

    public function test_competency_scope_active_only_returns_active_competencies(): void
    {
        Competency::factory()->active()->count(4)->create();
        Competency::factory()->inactive()->count(2)->create();

        $activeCompetencies = Competency::active()->get();

        $this->assertCount(4, $activeCompetencies);
        $activeCompetencies->each(function ($competency) {
            $this->assertEquals('active', $competency->status);
        });
    }

    public function test_competency_can_be_ordered_by_sort_order(): void
    {
        Competency::factory()->create(['sort_order' => 3]);
        Competency::factory()->create(['sort_order' => 1]);
        Competency::factory()->create(['sort_order' => 2]);

        $competencies = Competency::ordered()->get();

        $this->assertEquals(1, $competencies->first()->sort_order);
        $this->assertEquals(3, $competencies->last()->sort_order);
    }
}
