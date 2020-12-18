<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

use App\User\Model\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(8)->create();
    }
}
