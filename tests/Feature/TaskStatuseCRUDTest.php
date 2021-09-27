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
//        $tasks = TaskStatus::all();
//        foreach ($tasks as $task) {
//            var_dump($task->id);
//        }
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
        //
    }
}
