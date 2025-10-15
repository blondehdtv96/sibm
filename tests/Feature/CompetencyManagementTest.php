<?php

namespace Tests\Feature;

use App\Models\Competency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompetencyManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_competencies_index(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/competencies');

        $response->assertStatus(200);
        $response->assertViewIs('admin.competencies.index');
    }

    public function test_admin_can_create_competency(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/competencies', [
            'name' => 'New Competency',
            'description' => 'Competency description',
            'status' => 'active',
            'sort_order' => 1,
        ]);

        $response->assertRedirect('/admin/competencies');
        $this->assertDatabaseHas('competencies', [
            'name' => 'New Competency',
        ]);
    }

    public function test_admin_can_update_competency(): void
    {
        $competency = Competency::factory()->create();

        $response = $this->actingAs($this->admin)->put("/admin/competencies/{$competency->id}", [
            'name' => 'Updated Competency',
            'description' => 'Updated description',
            'status' => 'active',
            'sort_order' => 1,
        ]);

        $response->assertRedirect('/admin/competencies');
        $this->assertDatabaseHas('competencies', [
            'id' => $competency->id,
            'name' => 'Updated Competency',
        ]);
    }

    public function test_admin_can_delete_competency(): void
    {
        $competency = Competency::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/competencies/{$competency->id}");

        $response->assertRedirect('/admin/competencies');
        $this->assertDatabaseMissing('competencies', ['id' => $competency->id]);
    }

    public function test_public_can_view_competencies_list(): void
    {
        Competency::factory()->active()->count(3)->create();

        $response = $this->get('/competencies');

        $response->assertStatus(200);
        $response->assertViewIs('public.competencies.index');
    }

    public function test_public_can_view_single_competency(): void
    {
        $competency = Competency::factory()->active()->create();

        $response = $this->get("/competencies/{$competency->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('public.competencies.show');
        $response->assertViewHas('competency', $competency);
    }
}
