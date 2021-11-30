<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(rand(10, 100)),
            'status_id' => TaskStatus::all()->pluck('id')->random(),
            'created_by_id' => User::all()->pluck('id')->random() ?? null,
            'assigned_to_id' => User::all()->pluck('id')->random() ?? null
        ];
    }
}
