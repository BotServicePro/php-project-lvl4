<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelCRUDTest extends TestCase
{
    /** @var int */
    private $id;

    protected function setUp(): void
    {
        parent::setUp();

        // ПЕРВОЕ создаем нового юзера
        User::factory()->create();

        // ВТОРОЕ создаем метку
        $labelData = new Label();
        $labelData->name = 'новая метка';
        $labelData->description = 'описание метки';
        $labelData->save();

        $labelData = new Label();
        $labelData->name = 'вторая метка';
        $labelData->description = 'описание второй метки';
        $labelData->save();

        $labelData = new Label();
        $labelData->name = 'третья метка';
        $labelData->description = 'описание третей метки';
        $labelData->save();

         (int) $this->id = Label::find(1)->id;
    }

    // авторизация
    protected function signIn($user = null)
    {
        $this->actingAs(User::find(1));
        return $this;
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLabelPages()
    {
        $response = $this->get('/labels');
        $response->assertStatus(200);
    }

    public function testLabelAdd()
    {
        $response = $this->get('/labels/create'); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();

        $response = $this->get(route('labels.create')); // вход на страницу авторизованным юзером
        $response->assertStatus(200);

        // формируем даные для записи
        $labelData = [
            'name' => 'Тестовая метка',
            'description' => 'Описание тестовой метки',
        ];

        // формируем запрос
        $response = $this->post(route('labels.store'), $labelData);
        $response->assertSessionHasNoErrors();

        // проверяем редирект после успешного добавления нового статуса
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $labelData);
    }

    public function testLabelEdit()
    {
        $response = $this->get("/labels/{$this->id}/edit"); // вход на страницу авторизованным юзером
        $response->assertStatus(403); // в случае если НЕ авторизованы

        $this->signIn();

        $response = $this->get("/labels/{$this->id}/edit"); // вход на страницу авторизованным юзером
        $response->assertStatus(200);

        // формируем даные для записи
        $labelData = [
            'name' => 'ОБНОВЛЁННое название задачи',
            'description' => 'новое описание',
        ];

        // формируем запрос
        $response = $this->patch("/labels/{$this->id}", $labelData);
        $response->assertSessionHasNoErrors();

        $updatedLabel = Label::find(1);

        $this->assertEquals($labelData['name'], $updatedLabel->name);
        $this->assertEquals($labelData['description'], $updatedLabel->description);
        $this->assertEquals($this->id, $updatedLabel->id);
    }

    public function testLabelDelete()
    {
        $response = $this->delete("/labels/{$this->id}");
        $response->assertStatus(403);

        $this->signIn();

        $response = $this->delete("/labels/{$this->id}");
        $response->assertStatus(302);
        $response->assertRedirect(route('labels.index'));

        $deletedLabel = Label::where('id', '=', 1)->get()->toArray();
        $this->assertEquals([], $deletedLabel);
    }

    public function testLabelShow()
    {
        $response = $this->get("labels/{$this->id}");
        $response->assertStatus(403);
    }
}
