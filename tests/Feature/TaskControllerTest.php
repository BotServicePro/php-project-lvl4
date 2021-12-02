<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Collection|Model
     */
    private $user;

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
    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }
    public function testCreate()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('tasks.create'));
        $response->assertStatus(200);
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
        $response = $this->get(route('tasks.edit', ['task' => $task->id]));
        $response->assertStatus(403);
        $response =  $this->actingAs($this->user)->get(route('tasks.edit', ['task' => $task->id]));
        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $task = Task::factory()->create();
        $newTaskData = Task::factory()->make()->toArray();
        $response = $this->patch(route('tasks.update', ['task' => $task->id]), $newTaskData);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->patch(route('tasks.update', ['task' => $task->id]), $newTaskData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $newTaskData);
    }

    public function testDestroy(): void
    {
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', ['task' => $task->id]));
        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', ['task' => $task->id]));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
    }

    public function testShow(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', ['task' => $task->id]));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.showTask')],
            true
        );
    }
}
