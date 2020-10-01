<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Note;
use App\Models\User;
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

$factory->define(Note::class, function (Faker $faker) {
    $data = [
        Note::TITLE_ATTRIBUTE => $faker->realText(100),
        Note::BODY_ATTRIBUTE => $faker->realText(1000, 2),
        Note::SLUG_ATTRIBUTE => $faker->slug,
        Note::USER_ID_ATTRIBUTE => function () {
            User::where(User::EMAIL_ATTRIBUTE, 'test@test.com')->first()->getKey();
        },
        Note::PRIVACY_STATUS_ATTRIBUTE => function () {
            return rand(Note::PRIVATE, Note::PUBLIC);
        },
    ];

    $data[Note::PREVIEW_BODY_ATTRIBUTE] =  mb_substr(strip_tags($data[Note::BODY_ATTRIBUTE]), 0, 500);

    return $data;
});
