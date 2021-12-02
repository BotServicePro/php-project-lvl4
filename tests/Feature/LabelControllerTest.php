<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\LabelTask;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Collection|Model
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        TaskStatus::factory()->create();
        Task::factory()->create();
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
        $label = Label::factory()->create();
        $response = $this->get(route('labels.edit', ['label' => $label->id]));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('labels.edit', ['label' => $label->id]));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(
            [
                __('interface.editLabel')],
            true
        );
    }

    public function testUpdate(): void
    {
        $label = Label::factory()->create();
        $newLabelData = Label::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->patch(route('labels.update', ['label' => $label->id]), $newLabelData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $newLabelData);
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

        $label = Label::factory()->create();
        $labelInUse = LabelTask::factory()->create();
        $response = $this->delete(route('labels.destroy', ['label' => $labelInUse->id]));
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function testShow(): void
    {
        $response = $this->get(route('labels.show', ['label' => 1]));
        $response->assertStatus(403);
        $label = Label::factory()->create();
        $response = $this->get(route('labels.show', ['label' => $label->id]));
        $response->assertStatus(403);
    }
}
