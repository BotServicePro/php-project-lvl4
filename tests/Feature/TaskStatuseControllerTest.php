<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class TaskStatuseControllerTest extends TestCase
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

        $this->id = TaskStatus::find(1)->id;
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

        $response->assertSeeTextInOrder(
            [
                'ID',
                __('interface.name'),
                __('interface.createDate'),
            ],
            true
        );
        $response->assertDontSeeText(
            [
                __('interface.createStatus'),
                __('interface.settings')],
            true
        );

        $this->signIn();

        $response = $this->get('/task_statuses');
        $response->assertSeeTextInOrder(
            [
                __('interface.createStatus'),
                __('interface.settings')],
            true
        );
    }

    // авторизация
    //protected function signIn($user = null)
    protected function signIn(): TaskStatuseControllerTest
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $this;
    }

    public function testTaskStatuseAdd(): void
    {
        $response = $this->get(route('task_statuses.create')); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();
        $response = $this->get(route('task_statuses.create')); // вход на страницу авторизованным юзером
        $response->assertStatus(200);


        $response->assertSeeTextInOrder(
            [
                __('interface.createStatus')],
            true
        );


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

    public function testTaskStatuseEdit(): void
    {
        $response = $this->get(route('task_statuses.edit', ['task_status' => $this->id]));
        $response->assertStatus(403);

        $this->signIn();
        $response = $this->get(route('task_statuses.edit', ['task_status' => $this->id]));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.editStatus')],
            true
        );

        // формируем даные для записи
        $taskData = [
            'name' => 'ОБНОВЛЁННЫЙ статус',
        ];

        // формируем запрос
        $response = $this->patch(route('task_statuses.update', ['task_status' => $this->id]), $taskData);
        $response->assertSessionHasNoErrors();

        $updatedTaskStatus = TaskStatus::where('id', 1)->first();

        $this->assertEquals($taskData['name'], $updatedTaskStatus->name);
        $this->assertEquals(1, $updatedTaskStatus->id);
    }

    public function testTaskStatuseDelete(): void
    {
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->id]));
        $response->assertStatus(403);

        $this->signIn();
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));

        $deletedTask = TaskStatus::where('id', '=', 1)->first();
        $this->assertNull($deletedTask);
    }
}
