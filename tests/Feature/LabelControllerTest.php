<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertOk();
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
        $response = $this->actingAs($this->user)->get(route('labels.edit', $label));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $label = Label::factory()->create();
        $newLabelData = Label::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->patch(route('labels.update', $label), $newLabelData);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $newLabelData);
    }

    public function testDestroy(): void
    {
        $label = Label::factory()->create();
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', $label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testShow(): void
    {
        $label = Label::factory()->create();
        $response = $this->get(route('labels.show', $label));
        $response->assertForbidden();
    }
}
