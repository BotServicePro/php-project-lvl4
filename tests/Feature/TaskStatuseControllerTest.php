<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class TaskStatuseControllerTest extends TestCase
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
        $this->user = User::factory()->create();
        TaskStatus::factory()->count(4)->create();
        $this->id = TaskStatus::find(1)->id;
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
        $response = $this->get(route('task_statuses.edit', ['task_status' => $this->id]));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', ['task_status' => $this->id]));
        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $taskData = TaskStatus::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', [
            'task_status' => $this->id
        ]), $taskData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('task_statuses', $taskData);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->id]));
        $response->assertStatus(403);
        $this->assertDatabaseHas('task_statuses', ['id' => $this->id]);
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', ['task_status' => $this->id]));
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->id]);
        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
    }
}
