<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User\User;
use App\Models\Item\Item;
use App\Models\_partials\Element;

class ItemTest extends TestCase
{
	use DatabaseTransactions;

	protected $item;
	protected $element;


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
		$this->element = Element::first();

		$this->user = factory(User::class)->create();
		$this->item = factory(Item::class)->create([ 
	        'user_id'=>$this->user->id,
	        'element_id'=>$this->element->id,
	    ]);
	}


//fields
 	public function test_it_has_fields()
    {
       	$this->assertEquals('znack', $this->item->title);
       	$this->assertEquals('znack', $this->item->description);
       	$this->assertEquals('znack', $this->item->default_price);
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



//check method "AddItem"
 	public function test_it_has_users()
    {

    }

//check method "removeItem"
    public function test_it_complete()
    {
    	$this->setExpectedException('Exception');

    }

/*=============================================
=            		Filter items   	      =
=============================================*/


//check sort "getExpired" method
    public function test_it_Repository_method_getExpired()
    {
    	//add extra item with params
       	$expired_item = factory(item::class)->create(['expires'=>Carbon\Carbon::now()]);

       	$items = item::getExpired();//->get() inside

       	$this->assertEquals($expired_item->id, $items->first()->id);
    }

}
