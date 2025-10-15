<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
    }

    public function test_user_has_default_student_role(): void
    {
        $user = User::factory()->create();

        $this->assertEquals('student', $user->role);
    }

    public function test_user_can_be_admin(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertEquals('admin', $user->role);
        $this->assertTrue($user->isAdmin());
    }

    public function test_user_can_be_teacher(): void
    {
        $user = User::factory()->teacher()->create();

        $this->assertEquals('teacher', $user->role);
        $this->assertTrue($user->isTeacher());
    }

    public function test_user_can_be_student(): void
    {
        $user = User::factory()->student()->create();

        $this->assertEquals('student', $user->role);
        $this->assertTrue($user->isStudent());
    }

    public function test_user_has_news_relationship(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->news);
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this->assertNotEquals('password', $user->password);
        $this->assertTrue(\Hash::check('password', $user->password));
    }
}
