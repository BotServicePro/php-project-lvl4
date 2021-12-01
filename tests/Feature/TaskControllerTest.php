<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    /** @var int */
    public $id;
    /**
     * @var Collection|Model
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $totalRecords = 5;
        $this->user = User::factory()->create();
        TaskStatus::factory()->count($totalRecords)->create();
        Task::factory()->create();
        $this->id = Task::find(1)->id;
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
        $response = $this->get(route('tasks.edit', ['task' => $this->id]));
        $response->assertStatus(403);
        $response =  $this->actingAs($this->user)->get(route('tasks.edit', ['task' => $this->id]));
        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $taskData = Task::factory()->make()->toArray();
        $response = $this->patch(route('tasks.update', ['task' => $this->id]), $taskData);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->patch(route('tasks.update', ['task' => $this->id]), $taskData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route('tasks.destroy', ['task' => $this->id]));
        $response->assertStatus(403);
        $this->assertDatabaseHas('tasks', ['id' => $this->id]);

        $response = $this->actingAs($this->user)->delete(route('tasks.destroy', ['task' => $this->id]));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('tasks', ['id' => $this->id]);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', ['task' => $this->id]));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.showTask')],
            true
        );
    }
}
