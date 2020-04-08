<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;
use App\User;

$factory->define(Order::class, function (Faker $faker) {
	$user = factory(User::class)->create();
	
    return [
    	'user_id' => $user->id,
    	'barangay_id' => $user->barangay_id,
    	'service_type_id' => mt_rand(1, 8),
        'description' => $faker->text,
        'status' => 'posted'
    ];
});
