<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TaskCRUDTest extends TestCase
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;

    protected function setUp(): void
    {
        parent::setUp();

        // ПЕРВОЕ создаем нового юзера
        User::factory()->create();

        // ВТОРОЕ создаем статус
        $statusData = new TaskStatus();
        $statusData->name = 'статус в разработке';
        $statusData->save();

        $statusData = new TaskStatus();
        $statusData->name = 'статус завершен';
        $statusData->save();

        // ТРЕТЬЕ создаем задачу
        $taskData = new Task();
        $taskData->name = 'задача';
        $taskData->description = 'описание';
        $taskData->created_by_id = 1;
        $taskData->assigned_to_id = 1;
        $taskData->status_id = 1;
        $taskData->save();

        $this->id = $taskData->id;
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskPages()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }

    // авторизация
    protected function signIn($user = null): TaskCRUDTest
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);
        return $this;
    }

    public function testTaskAdd(): void
    {
        $response = $this->get(route('tasks.create')); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();
        $response = $this->get(route('tasks.create')); // вход на страницу авторизованным юзером
        $response->assertStatus(200);

        // формируем даные для записи
        $taskData = [
            'name' => 'Тестовая задача',
            'description' => 'Описание тестовой задачи',
            'status_id' => 1,
            'created_by_id' => 1,
            'assigned_to_id' => 1,
            ];

        // формируем запрос
        $response = $this->post(route('tasks.store'), $taskData);
        $response->assertSessionHasNoErrors();

        // проверяем редирект после успешного добавления нового статуса
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testTaskEdit(): void
    {
        $response = $this->get(route('tasks.edit', ['task' => $this->id])); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();

        $response = $this->get(route('tasks.edit', ['task' => $this->id])); // вход на страницу авторизованным юзером
        $response->assertStatus(200);

        // формируем даные для записи
        $taskData = [
            'name' => 'ОБНОВЛЁННое название задачи',
            'description' => 'новое описание',
            'status_id' => 2,
            'created_by_id' => 1,
            'assigned_to_id' => 2,
        ];

        // формируем запрос
        $response = $this->patch(route('tasks.update', ['task' => $this->id]), $taskData);
        $response->assertSessionHasNoErrors();

        $updatedTask = Task::find(1);

        $this->assertEquals($taskData['name'], $updatedTask->name);
        $this->assertEquals($taskData['description'], $updatedTask->description);
        $this->assertEquals($taskData['status_id'], $updatedTask->status_id);
        $this->assertEquals($this->id, $updatedTask->id);
        $this->assertEquals($taskData['assigned_to_id'], $updatedTask->assigned_to_id);
    }

    public function testTaskDelete(): void
    {
        $response = $this->delete(route('tasks.destroy', ['task' => $this->id]));
        $response->assertStatus(403);

        $this->signIn();

        $response = $this->delete(route('tasks.destroy', ['task' => $this->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('tasks.index'));

        $deletedTask = Task::where('id', 1)->first();
        $this->assertNull($deletedTask);
    }

    public function testTaskShow(): void
    {
        // возможно придеться дописать тест с использованием фикстур и фейковой страницы
        $response = $this->get(route('tasks.show', ['task' => $this->id]));
        $response->assertStatus(200);
    }
}
