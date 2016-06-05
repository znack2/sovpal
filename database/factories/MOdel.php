<?php

//  // $date = $faker->dateTimeBetween('today', 'today +7 days')->format('Y-m-d');
//  // Carbon::parse(date('Y-m-d 08:00:00', strtotime('today +2 days'))),
//  // 'birthdate'      => \Carbon\Carbon::now()->subYears(30)->format('m/d/Y'),
//  // 'date'      => date('Y-m-d', strtotime($date)),
//  // 'start_at'  => date('Y-m-d 00:00:00', strtotime($date)),


// $sampleInstance = app(App\Sample::class);
// $factory->define(App\User::class, function (Faker\Generator $faker, $attributes=array()) use($sampleInstance){
//     //...$attributes received      
//     return ['name' => $sampleInstance->doSomething(),];
// });



// $users = User::all();
// 'user_id' => $faker->unique()->randomElement($users->lists('id')),




//  // == room ====================================================================================================

  $factory->defineAs(App\Models\Room\Room::class, 'default' , function (Faker\Generator $faker) {

       $description = $faker->text;
       $type        = $faker->randomElement(['room'.'project']);
       $area        = $faker->numberBetween(1,100);
       $step        = $faker->randomElement(['demontaj','construction','finish','painting','furniture']);

      return [
          'type'                => $type,
          'description'         => $description,
          'area'                => $faker->numberBetween(30,200),
          'end_remont'          => $faker->dateTimeBetween('today', 'today +7 days')->format('Y-m-d'),
          'start_remont'        => $faker->dateTimeBetween('today', 'today +7 days')->format('Y-m-d'),
          'step'                => $step,
          'designer_id'         => factory(App\Models\User\User::class)->create()->id,
          'user_id'             => factory(App\Models\User\User::class)->create()->id,
          'meta_title'          => $type . $area .$step, 
          'meta_keywords'       => $faker->randomElement(['user_style','user_area','user_type','user_step']),
          'meta_description'    => $description
      ];    
  });   

//  // == post ====================================================================================================

  $factory->define(App\Models\Post\Post::class,function (Faker\Generator $faker) {

      return [
          'user_id'       => factory(App\Models\User\User::class)->create()->id,
          'room_id'       => factory(App\Models\Room\Room::class,'default')->create()->id,
          'title'         => $faker->sentence(4),
          'body'          => $faker->text,
          'type'          => $faker->randomElement(['post', 'news','tip','ad','unknown']),
          'difficulty'    => $faker->randomElement(['unknown', 'easy', 'medium', 'hard']),
          'area'          => $faker->randomElement(['wall', 'floor', 'ceiling','unknown']),
          'link'          => $faker->url,
      ];
  });


