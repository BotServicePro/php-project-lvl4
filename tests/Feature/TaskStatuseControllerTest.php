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
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
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
        $taskData = ['name' => 'Тестовый статус'];
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
        $response->assertSeeTextInOrder(
            [
                __('interface.editStatus')],
            true
        );
    }

    public function testUpdate(): void
    {
        $taskData = [
            'name' => 'ОБНОВЛЁННЫЙ статус',
        ];

        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', ['task_status' => $this->id]), $taskData);
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

        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', ['task_status' => $this->id]));
        $this->assertDatabaseMissing('task_statuses', ['id' => $this->id]);
        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
    }
}
