<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\LabelTask;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabelTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LabelTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'task_id' => Task::all()->pluck('id')->random(),
            'label_id' => Label::all()->pluck('id')->random(),
        ];
    }
}
