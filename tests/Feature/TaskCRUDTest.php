<?php

namespace Tests\Feature;

use App\Models\Task;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class TaskCRUDTest extends TestCase
{
    /** @var int */
    private $id;

    protected function setUp(): void
    {
        parent::setUp();
        // создаем нового юзера
        User::factory()->create();

        $statusData = new TaskStatus();
        $statusData->name = 'тестовый статус';
        $statusData->save();

        foreach (Task::where('id', '=', 1)->get() as $item) {
            $this->id = $item->id;
        }
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
    protected function signIn($user = null)
    {
        $this->actingAs(User::find(1));
        return $this;
    }

    public function testTaskAdd()
    {
        $response = $this->get('/tasks/create'); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();
        $response = $this->get('/tasks/create'); // вход на страницу авторизованным юзером
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

//    public function testTaskStatuseEdit()
//    {
//        $response = $this->get("/tasks/{$this->id}/edit"); // вход на страницу авторизованным юзером
//        $response->assertStatus(403); // в случае если НЕ авторизованы
//
//        $this->signIn();
//
//        $response = $this->get("/tasks/{$this->id}/edit"); // вход на страницу авторизованным юзером
//        $response->assertStatus(200);
//
//        // формируем даные для записи
//        $taskData = [
//            'name' => 'ОБНОВЛЁННЫЙ статус',
//        ];
//
//        // формируем запрос
//        //$response = $this->patch(route('task_statuses.update'), $taskData);
//        $response = $this->patch("task_statuses/{$this->id}", $taskData);
//        $response->assertSessionHasNoErrors();
//
//        foreach(TaskStatus::where('id', '=', 1)->get() as $item) {
//            $updatedTask = $item;
//        }
//
//        $this->assertEquals($taskData['name'], $updatedTask->name);
//        $this->assertEquals(1, $updatedTask->id);
//    }
//
//    public function testTaskStatuseDelete()
//    {
//        $response = $this->delete("task_statuses/{$this->id}");
//        $response->assertStatus(403);
//
//        $this->signIn();
//        $response = $this->delete("task_statuses/{$this->id}");
//        $response->assertStatus(302);
//        $response->assertRedirect(route('task_statuses.index'));
//
//        $deletedTask = TaskStatus::where('id', '=', 1)->get()->toArray();
//        $this->assertEquals([], $deletedTask);
//    }
}
