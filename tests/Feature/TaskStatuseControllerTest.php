<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskStatuseControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var int */
    private $id;
    /**
     * @var Collection|Model
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.createStatus')],
            true
        );
    }

    public function testStore(): void
    {
        $taskData = TaskStatus::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $taskData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $taskData);
    }

    public function testEdit(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', ['task_status' => $taskStatus->id]));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', ['task_status' => $taskStatus->id]));
        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $newTaskData = TaskStatus::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', [
            'task_status' => $taskStatus->id
        ]), $newTaskData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', $newTaskData);
    }

    public function testDestroy(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $taskStatus->id]));
        $response->assertStatus(403);
        $this->assertDatabaseHas('task_statuses', ['id' => $taskStatus->id]);
        $response = $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', ['task_status' => $taskStatus->id]));
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
    }
}
