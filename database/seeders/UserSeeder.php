<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUser = new User();
        $newUser->name = 'Alex';
        $newUser->email = 'alex@mail.ru';
        $newUser->password = Hash::make('test');
        $newUser->created_at = Carbon::now();
        $newUser->updated_at = Carbon::now();
        $newUser->save();

        $newUser = new User();
        $newUser->name = 'SecondUser';
        $newUser->email = 'test@mail.ru';
        $newUser->password = Hash::make('test');
        $newUser->created_at = Carbon::now();
        $newUser->updated_at = Carbon::now();
        $newUser->save();
    }
}
