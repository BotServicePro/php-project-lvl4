<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuseNames = ['новый', 'в работе', 'на тестировании', 'завершен'];
        foreach ($statuseNames as $name) {
            $status = new TaskStatus();
            $status->name = $name;
            $status->save();
        }
    }
}
