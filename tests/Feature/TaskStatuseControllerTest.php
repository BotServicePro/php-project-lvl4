<?php

namespace Tests\Feature;

use App\Models\Task;
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

    protected function signIn(): TaskStatuseControllerTest
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $this;
    }

    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(403);

        $this->signIn();
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(200);

        $response->assertSeeTextInOrder(
            [
                __('interface.createStatus')],
            true
        );

        $taskData = ['name' => 'Тестовый статус'];
        $response = $this->post(route('task_statuses.store'), $taskData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $taskData);
    }

    public function testEdit(): void
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

        $taskData = [
            'name' => 'ОБНОВЛЁННЫЙ статус',
        ];

        $response = $this->patch(route('task_statuses.update', ['task_status' => $this->id]), $taskData);
        $response->assertSessionHasNoErrors();

        $updatedTaskStatus = TaskStatus::where('id', 1)->first();
        $this->assertEquals($taskData['name'], $updatedTaskStatus->name);
        $this->assertEquals(1, $updatedTaskStatus->id);
    }

    public function testDestroy(): void
    {
        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->id]));
        $response->assertStatus(403);
        $this->assertDatabaseHas('task_statuses', ['id' => $this->id]);

        $this->signIn();

        $response = $this->delete(route('task_statuses.destroy', ['task_status' => $this->id]));
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->id]);
        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
    }
}
