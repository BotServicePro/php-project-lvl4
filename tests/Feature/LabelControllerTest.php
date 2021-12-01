<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\LabelTask;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    /** @var int */
    private $id;
    /**
     * @var Collection|Model
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $totalRecords = 5;
        $this->user = User::factory()->create();
        Label::factory()->create();
        TaskStatus::factory()->count($totalRecords)->create();
        Task::factory()->create();
        $this->id = Label::find(1)->id;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get(route('labels.create'));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.createLabel')],
            true
        );
    }

    public function testStore(): void
    {
        $labelData = Label::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('labels.store'), $labelData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $labelData);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('labels.edit', ['label' => $this->id]));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->get(route('labels.edit', ['label' => $this->id]));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.editLabel')],
            true
        );
    }

    public function testUpdate(): void
    {
        $labelData = Label::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->patch(route('labels.update', ['label' => $this->id]), $labelData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $labelData);
    }
    public function testDestroy(): void
    {
        $newLabelNotInUse = Label::factory()->create();
        $labelNotInUseId = $newLabelNotInUse->id;
        $response = $this->delete(route('labels.destroy', ['label' => $labelNotInUseId]));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->delete(route('labels.destroy', ['label' => $labelNotInUseId]));
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
