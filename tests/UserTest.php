<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseTransactions;

	protected $user;
	protected $address;


	// any test method
	// -----------
	// Given create
   	// When check method
   	// Then assert


	public function setUp()
	{	
		//for all "test" methods
		$this->item = $this->create();
	}

	protected function create()
	{
		$this->address = Address::first();

		$this->user = factory(User::class)->create([ 
	        'user_id'=>$this->user->id,
	        'element_id'=>$this->element->id,
	    ]);
	}


//fields
 	public function test_it_has_fields()
    {
            'provider_id',
            'provider',
            'activation_code',
            'activated_at',
            'first_name',
            'last_name',
            'level',
            'gender',
            'skills',
            'hour_cost',       
            'education',
            'own_remont',
            'with_designer',
            'phone',
            'phone_code',
            'refund_policy',
            'delivery_policy',
            'birthday',
            'join_count',
            'group_count',
            'room_count',
            'item_count',
            'element_count',
            'language',
            'last_login',
            'active',
       	$this->assertEquals('znack', $this->item->email);
       	$this->assertEquals('znack', $this->item->password);
       	$this->assertEquals('znack', $this->item->type);
       	$this->assertEquals('znack', $this->item->user_need);
       	$this->assertEquals('znack', $this->item->expires);
       	$this->assertEquals('znack', $this->item->item_count);
       	$this->assertEquals('znack', $this->item->user_count);
       	$this->assertEquals('znack', $this->item->type);
       	$this->assertEquals('znack', $this->item->active);
       	$this->assertEquals('znack', $this->item->complete);
       	$this->assertEquals('znack', $this->item->premium);
    }

/*=============================================
=            		Repo methods   	         =
=============================================*/



/*=============================================
=            		Filter items   	      =
=============================================*/


}
