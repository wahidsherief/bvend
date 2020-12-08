<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\MLTransaction;
use App\Category;
use App\Brand;
use App\VendorRegistration;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];

});

	$factory->define(MLTransaction::class,function(Faker $faker){
    	
		return [
    	'machine_id' => 1,
    	'user_id' => rand(1,10),
    	'vendor_id' => rand(1,10),
    	'invoice_no' => rand(10,20),
    	'payment_id' => 1,
    	'bkash_trx_id' => Str::random(10),
    	'total_amount' => rand(40,100),
    	'discount' => rand(10,20),
    	'payment_method_id' => rand(1,10),
    	'status' => 1

		];
    });

    $factory->define(VendorRegistration::class,function(Faker $faker){
        return [
        'business_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'business_phone' =>$faker->phoneNumber,
        'is_approved' => 0,
        ];
        
    });
    
    $factory->define(Category::class,function(Faker $faker){
        return [
        'category_name' => $faker->word,
        ];
        
    });
    
    $factory->define(Brand::class,function(Faker $faker){
        return [
        'brand_name' => $faker->word,
        'logo' => $faker->word,
        ];
        
    });

