<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class TaskStatuseCRUDTest extends TestCase
{
    /** @var int */
    private $id;

    protected function setUp(): void
    {
        parent::setUp();

        $statuseNames = ['новый', 'в работе', 'на тестировании', 'завершен'];
        foreach ($statuseNames as $name) {
            $status = new TaskStatus();
            $status->name = $name;
            $status->save();
        }

        //$this->id = TaskStatus::where('id', '=', 1)->get();
        foreach(TaskStatus::where('id', '=', 1)->get() as $item) {
            $this->id = $item->id;
        }
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskStatusePages()
    {
        $response = $this->get('/task_statuses');
        $response->assertStatus(200);
    }

    // авторизация
    protected function signIn($user = null)
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $this;
    }

    public function testTaskStatuseAdd()
    {
        $response = $this->get('/task_statuses/create'); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();
        $response = $this->get('/task_statuses/create'); // вход на страницу авторизованным юзером
        $response->assertStatus(200);

        // формируем даные для записи
        $taskData = ['name' => 'Тестовый статус'];

        // формируем запрос
        $response = $this->post(route('task_statuses.store'), $taskData);
        $response->assertSessionHasNoErrors();

        // проверяем редирект после успешного добавления нового статуса
        $response->assertRedirect(route('task_statuses.index'));

        // проверяем в базе наличие нового статуса
        $this->assertDatabaseHas('task_statuses', $taskData);
    }

    public function testTaskStatuseEdit()
    {
        $response = $this->get("/task_statuses/{$this->id}/edit"); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();

        $response = $this->get("/task_statuses/{$this->id}/edit"); // вход на страницу авторизованным юзером
        $response->assertStatus(200);

        // формируем даные для записи
        $taskData = [
            'name' => 'ОБНОВЛЁННЫЙ статус',
        ];

        // формируем запрос
        //$response = $this->patch(route('task_statuses.update'), $taskData);
        $response = $this->patch("task_statuses/{$this->id}", $taskData);
        $response->assertSessionHasNoErrors();

        foreach(TaskStatus::where('id', '=', 1)->get() as $item) {
            $updatedTask = $item;
        }

        $this->assertEquals($taskData['name'], $updatedTask->name);
        $this->assertEquals(1, $updatedTask->id);
    }

    public function testTaskStatuseDelete()
    {
        $response = $this->delete("task_statuses/{$this->id}");
        $response->assertStatus(403);

        $this->signIn();
        $response = $this->delete("task_statuses/{$this->id}");
        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));

        $deletedTask = TaskStatus::where('id', '=', 1)->get()->toArray();
        $this->assertEquals([], $deletedTask);
    }
}
