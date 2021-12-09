<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        TaskStatus::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }
    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskData = Task::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $taskData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testEdit(): void
    {
        $task = Task::factory()->create();
        $response =  $this->actingAs($this->user)->get(route('tasks.edit', $task));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $task = Task::factory()->create();
        $newTaskData = Task::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->patch(route('tasks.update', $task), $newTaskData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $newTaskData);
    }

    public function testDestroy(): void
    {
        $task = Task::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', $task));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
    }

    public function testShow(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', $task));
        $response->assertOk();
    }
}
