<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // сделать через цикл, данные задачи поместить в массив
        $newTask = new Task();
        $newTask->name = 'Самая первая задача';
        $newTask->description = 'Очень важная';
        $newTask->status_id = 1;
        $newTask->assigned_to_id = 1;
        $newTask->created_by_id = 1;
        $newTask->timestamps = Carbon::now();
        $newTask->save();

        $newTask = new Task();
        $newTask->name = 'Самая ВТОРАЯ задача';
        $newTask->description = 'Ну так себе по важности';
        $newTask->status_id = 2;
        $newTask->assigned_to_id = 2;
        $newTask->created_by_id = 2;
        $newTask->timestamps = Carbon::now();
        $newTask->save();
    }
}
