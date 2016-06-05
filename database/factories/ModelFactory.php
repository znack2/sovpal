<?php

use App\Models\Item\Item;
use App\Models\Group\Group;
use App\Models\User\User;
use App\Models\_partials\Element;
use App\Models\_partials\Address;

$factory->define(Item::class,function (Faker\Generator $faker) {
   return [
       'user_id'           => '',
       'title'             => $faker->unique()->name,
       'description'       => $faker->text,
       'element_id'        => $faker->numberBetween(1,90),
   ];
});

$factory->defineAs(Item::class, 'item' ,function (Faker\Generator $faker) use ($factory){

  $item = $factory->raw(Item::class);

    return array_merge($item, [
        'user_id'           => 2,
        'type'              => 'item',
        'order_condition'   => $faker->text,
        'default_price'     => $faker->numberBetween(500,50000),
      ]);
});

$factory->defineAs(Item::class, 'tool' ,function (Faker\Generator $faker) use ($factory){

  $item = $factory->raw(Item::class);
   return array_merge($item, [
      'user_id'           => 3,
      'type'              => 'tool',
      'condition'         => $faker->randomElement(['best', 'good','normal','poor']),
      'order_condition'   => $faker->text,
   ]);
});

$factory->defineAs(Item::class, 'material' ,function (Faker\Generator $faker) use ($factory){

  $item = $factory->raw(Item::class);
   return array_merge($item, [
      'user_id'           => 3,
      'type'              => 'material',
      'qty'               => $faker->text,
      'order_condition'   => $faker->text,
   ]);
});

$factory->defineAs(Item::class, 'material_private' ,function (Faker\Generator $faker) use ($factory){

  $item = $factory->raw(Item::class);
   return array_merge($item, [
      'type'              => 'material',
      'private'           => $faker->boolean,
   ]);
});

$factory->defineAs(Item::class, 'tool_private' ,function (Faker\Generator $faker) use ($factory){

  $item = $factory->raw(Item::class);
   return array_merge($item, [
        'type'              => 'tool',
        'private'           => $faker->boolean,
   ]);
});

$factory->defineAs(Item::class, 'item_premium' ,function (Faker\Generator $faker) use ($factory){

  $item = $factory->raw(Item::class);
   return array_merge($item, [
        'type'              => 'item',
        'premium'           => $faker->boolean,
   ]);
});










$factory->define(Group::class ,function (Faker\Generator $faker){
        return [
              'price'                 => $faker->numberBetween(500,50000),
              'item_id'               => Item::where('type','item')->first()->id,
              'user_id'               => '1',
              'type'                  => 'item',
              'user_need'             => $faker->randomElement(['1','10','25','50','100','500']),
              'owner_count'            => $faker->numberBetween(1,100),
              'expires'               => $faker->dateTimeBetween($startDate = 'now', $endDate = '+ 25 days') ,
              'progress'              => $faker->numberBetween(1,100),
              'premium'               => $faker->boolean,
        ];
});






$factory->define(User::class,function (Faker\Generator $faker) {
    return [
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email'         => $faker->safeEmail,
        'language'      => $faker->randomElement(['ru', 'en']),
        'password'      => bcrypt(str_random(10)),
        'remember_token'=> str_random(10),
        'gender'        => $faker->boolean,
    ];
});

$factory->define(Address::class, function (Faker\Generator $faker) {
    return [
        'street' => $faker->streetName,
        'house'  => $faker->buildingNumber,
        'corpus' => $faker->bothify('##??'),
    ];
});

$factory->defineAs(User::class, 'owner' ,function (Faker\Generator $faker) use ($factory){

    $item = $factory->raw(User::class);

    return array_merge($item, [
        'type'          => 'owner',
        'own_remont'    => $faker->boolean,
    ]);
});

$factory->defineAs(User::class, 'profi' ,function (Faker\Generator $faker) use ($factory){

    $item = $factory->raw(User::class);

    return array_merge($item, [
        'type'          => 'profi',
        'hour_cost'     => $faker->text,
        'education'     => $faker->text,
    ]);
});

$factory->defineAs(User::class, 'shop' ,function (Faker\Generator $faker) use ($factory){

    $item = $factory->raw(User::class);

    return array_merge($item, [
        'type'          => 'shop',
    ]);
});

