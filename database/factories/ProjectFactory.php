<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence,
        'owner_id' => function(){
            return factory('App\User')->create()->id;
        }
    ];
});
