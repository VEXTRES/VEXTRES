<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Contact;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        

        User::create([
            'name' => 'uriel sanchez',
            'email' => 'uriel.ss@hotmail.com',
            'password' => '123456789'
        ]);
    }
}
