<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    /** @var int */
    private $id;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
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

        $this->actingAs($this->user)->get(route('tasks.create'));
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $taskData = [
            'name' => 'Тестовая задача',
            'description' => 'Описание тестовой задачи',
            'status_id' => 1,
            'created_by_id' => 1,
            'assigned_to_id' => 1,
            ];

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
        $response->assertSeeTextInOrder(
            [
                __('interface.editTask')],
            true
        );
    }

    public function testUpdate(): void
    {
        $taskData = [
            'name' => 'ОБНОВЛЁННое название задачи',
            'description' => 'новое описание',
            'status_id' => 2,
            'created_by_id' => 1,
            'assigned_to_id' => 2,
        ];
        $response = $this->patch(route('tasks.update', ['task' => $this->id]), $taskData);
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->patch(route('tasks.update', ['task' => $this->id]), $taskData);
        $response->assertSessionHasNoErrors();
        $updatedTask = Task::find(1);
        $this->assertEquals($taskData['name'], $updatedTask->name);
        $this->assertEquals($taskData['description'], $updatedTask->description);
        $this->assertEquals($taskData['status_id'], $updatedTask->status_id);
        $this->assertEquals($this->id, $updatedTask->id);
        $this->assertEquals($taskData['assigned_to_id'], $updatedTask->assigned_to_id);
    }

    public function testDestroy(): void
    {
        Task::factory()->create();
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
