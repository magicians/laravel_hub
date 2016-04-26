<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'avatar' => $faker->imageUrl(256,256),
        'password' => bcrypt(str_random(10)),
        'points' => $faker->randomNumber(),
        'gold' => $faker->randomNumber(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Discussion::class, function (Faker\Generator $faker) {
    $user_ids = App\User::lists('id')->toArray();
    return [
        'title' => $faker->sentence(),
        'contents' => $faker->paragraph(),
        'user_id' => $faker->randomElement($user_ids),
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $user_ids = App\User::lists('id')->toArray();
    $discussion_ids = App\Discussion::lists('id')->toArray();
    return [
        'comment' => $faker->sentence(),
        'user_id' => $faker->randomElement($user_ids),
        'discussion_id' => $faker->randomElement($discussion_ids),
    ];
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    $user_ids = App\User::lists('id')->toArray();
    return [
        'message' => $faker->sentence(),
        'user_id' => 1,
        'from_user_id' => $faker->randomElement($user_ids),
    ];
});
