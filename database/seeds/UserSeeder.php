<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            User::NAME_ATTRIBUTE => 'Name',
            User::SURNAME_ATTRIBUTE => 'Surname',
            User::EMAIL_ATTRIBUTE => 'test@test.com',
            User::PASSWORD_ATTRIBUTE => Hash::make('password'),
        ]);
    }
}
