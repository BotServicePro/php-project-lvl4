<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;

    protected function setUp(): void
    {
        parent::setUp();
        $totalRecords = 5;
        User::factory()->count($totalRecords)->create();
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
        $response = $this->get('/tasks');
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                'ID',
                __('interface.status'),
                __('interface.name'),
                __('interface.author'),
                __('interface.employee'),
                __('interface.createDate'),
            ],
            true
        );
        $response->assertDontSeeText(
            [
            __('interface.createTask'),
            __('interface.settings')],
            true
        );

        $this->signIn();

        $response = $this->get('/tasks');
        $response->assertSeeTextInOrder(
            [
            __('interface.createTask'),
            __('interface.settings')],
            true
        );
    }

    // авторизация
    protected function signIn(): TaskControllerTest
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);
        return $this;
    }

    public function testCreate(): void
    {
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(403);

        $this->signIn();
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);

        $taskData = [
            'name' => 'Тестовая задача',
            'description' => 'Описание тестовой задачи',
            'status_id' => 1,
            'created_by_id' => 1,
            'assigned_to_id' => 1,
            ];

        $response = $this->post(route('tasks.store'), $taskData);
        $response->assertSessionHasNoErrors();

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('tasks.edit', ['task' => $this->id]));
        $response->assertStatus(403);

        $this->signIn();

        $response = $this->get(route('tasks.edit', ['task' => $this->id]));
        $response->assertStatus(200);

        $taskData = [
            'name' => 'ОБНОВЛЁННое название задачи',
            'description' => 'новое описание',
            'status_id' => 2,
            'created_by_id' => 1,
            'assigned_to_id' => 2,
        ];

        $response = $this->patch(route('tasks.update', ['task' => $this->id]), $taskData);
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

        $this->signIn();

        $response = $this->delete(route('tasks.destroy', ['task' => $this->id]));
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
