<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'метка 1', 'description' => 'описание метки 1'],
            ['name' => 'метка 2', 'description' => 'описание метки 2'],
            ['name' => 'метка 3', 'description' => 'описание метки 3'],
            ['name' => 'метка 4', 'description' => 'описание метки 4'],
            ['name' => 'метка 5', 'description' => 'описание метки 5'],
            ['name' => 'метка 6', 'description' => 'описание метки 6'],
            ['name' => 'метка 7', 'description' => 'описание метки 7'],
        ];

        foreach ($data as $label) {
            $newLabel = new Label();
            $newLabel->name = $label['name'];
            $newLabel->description = $label['description'];
            $newLabel->save();
        }
    }
}
