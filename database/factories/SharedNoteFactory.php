<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Note;
use App\Models\User;
use App\Models\SharedNote;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(SharedNote::class, function (Faker $faker) {
    return [
        SharedNote::EMAIL_ATTRIBUTE => function () {
            return User::inRandomOrder()->first()->{User::EMAIL_ATTRIBUTE};
        },
        SharedNote::SLUG_ATTRIBUTE => function () {
            return Note::inRandomOrder()->first()->{Note::SLUG_ATTRIBUTE};
        },
    ];
});
