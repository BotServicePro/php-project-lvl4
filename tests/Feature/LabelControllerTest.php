<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\LabelTask;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    /** @var int */
    private $id;

    protected function setUp(): void
    {
        parent::setUp();
        $totalRecords = 5;
        User::factory()->count($totalRecords)->create();
        Label::factory()->count($totalRecords)->create();
        TaskStatus::factory()->count($totalRecords)->create();
        Task::factory()->create();
        $this->id = Label::find(1)->id;
    }

    protected function signIn(): LabelControllerTest
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);
        return $this;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/labels');
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                'ID',
                __('interface.name'),
                __('interface.description'),
                __('interface.createDate'),
                ],
            true
        );
        $response->assertDontSeeText(
            [
                __('interface.createLabel'),
                __('interface.settings')],
            true
        );
        $this->signIn();
        $response = $this->get('/labels');
        $response->assertSeeTextInOrder(
            [
                __('interface.createLabel'),
                __('interface.settings')],
            true
        );
    }

    public function testCreate(): void
    {
        $response = $this->get(route('labels.create'));
        $response->assertStatus(403);

        $this->signIn();

        $response = $this->get(route('labels.create'));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.createLabel')],
            true
        );

        $labelData = [
            'name' => 'Тестовая метка',
            'description' => 'Описание тестовой метки',
        ];

        $response = $this->post(route('labels.store'), $labelData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $labelData);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('labels.edit', ['label' => $this->id]));
        $response->assertStatus(403);

        $this->signIn();

        $response = $this->get(route('labels.edit', ['label' => $this->id]));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.editLabel')],
            true
        );
    }

    public function testUpdate(): void
    {
        $this->signIn();

        $labelData = [
            'name' => 'ОБНОВЛЁННое название задачи',
            'description' => 'новое описание',
        ];

        $response = $this->patch(route('labels.update', ['label' => $this->id]), $labelData);
        $response->assertSessionHasNoErrors();

        $updatedLabel = Label::find(1);

        $this->assertEquals($labelData['name'], $updatedLabel->name);
        $this->assertEquals($labelData['description'], $updatedLabel->description);
        $this->assertEquals($this->id, $updatedLabel->id);
    }
    public function testDestroy(): void
    {
        $label = Label::all()->first();
        $labelNotInUseId = $label->id;
        $response = $this->delete(route('labels.destroy', ['label' => $labelNotInUseId]));
        $response->assertStatus(403);

        $this->signIn();

        $response = $this->delete(route('labels.destroy', ['label' => $labelNotInUseId]));
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('labels', ['id' => $labelNotInUseId]);

        $labelInUse = LabelTask::factory()->create()->first();
        $labelInUseId = $labelInUse->label_id;
        $response = $this->delete(route('labels.destroy', ['label' => $labelInUseId]));
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $labelInUseId]);
    }

    public function testShow(): void
    {
        $response = $this->get(route('labels.show', ['label' => 1]));
        $response->assertStatus(403);
    }
}
