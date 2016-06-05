<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User\User;
use App\Models\Group\Group;
use App\Models\Item\Item;
use App\Models\_partials\Element;

class GroupTest extends TestCase
{
	use DatabaseTransactions;

  protected $group;
  protected $user;
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
		$this->create();
	}

	protected function create()
	{
    $this->element - Element::latest()->first();

    $this->user = factory(User::class)->create();
    $this->user->items()->create(['element_id'=>$this->element->id]);
    $this->user->groups()->create(['item_id'=>$this->item->id,'type'=>'']);
	}

//check all created
    public function test_all_created()
    {
          $stored_users  = User::all();
          $stored_items  = Item::all();
          $stored_groups = Group::all();

          $this->assertEquals($this->user->id, $stored_users[1]->id);
          $this->assertEquals($this->item->id, $stored_items[1]->id);
          $this->assertEquals($this->group->id, $stored_groups[1]->id);

          $this->seeInDatabase('users', ['id' => 1, 'name' => 'The Hobbit']);
          $this->seeInDatabase('items', ['id' => 1, 'name' => 'The Hobbit']);
          $this->seeInDatabase('groups', ['id' => 1, 'name' => 'The Hobbit']);
    }

//has User
  public function test_it_has_User()
    {
        $this->assertEquals($this->user->id, $this->group->user_id);
    }

//has Item
  public function test_it_has_Users_Item()
    {
        $this->assertContains($this->group->item_id, $this->user->items()->pluck('id'));
    }

//check Group's type
  public function test_it_has_Type()
    {
        $this->assertEquals($this->user->id, $this->group->type);
    }

//fields
  public function test_it_has_fields()
    {
        $this->assertEquals('znack', $this->group->price);
        $this->assertEquals('znack', $this->group->user_need);
        $this->assertEquals('znack', $this->group->expires);
    }    

//check active
 	public function test_it_is_active()
    {
       	$this->assertEquals('znack', $this->group->active);
    }

//check group complete
    public function test_it_is_completed()
    {
      $this->assertEquals('znack', $this->group->complete);
      $this->setExpectedException('Exception');
    }

//check group complete
    public function test_it_is_premium()
    {
      $this->assertEquals('znack', $this->group->premium);
    }


/*=============================================
=            		Repo methods   	         =
=============================================*/


//check method "joinGroup"
 	public function test_it_has_users()
    {
		$user2 = factory(User::class)->create();

		$this->group->joinGroup($this->user,'2');

       	//check group has one user1 and method "users"
       	$this->assertCount(1, $this->group->users());

        //check how many items
        $this->assertEquals('2', $this->group->item_count);

        //check how many users
        $this->assertEquals('1', $this->group->user_count);

       	//check group has not user2 
       	$this->assertContains($user2->id, $this->group->users()->pluck('id'));

       	//check total and method "totalUsers"
       	$this->assertEquals(1, $this->group->user_count);
    }

//check method "withdrowFromGroup"
    public function test_it_withdrowFromGroup()
    {
      $this->group->JoinGroup($this->user);
      $this->group->withdrowFromGroup($this->user);

      $this->assertEquals(0, $this->group->user_count);
    }

//check method "RestartGroup"
    public function test_it_RestartGroup()
    {
      $this->group->JoinGroup($this->user);
      $this->group->RestartGroup($this->user);

      $this->assertEquals(0, $this->group->user_count);
    }


/*=============================================
=            		Filter groups   	      =
=============================================*/


//check sort "getExpired" method
    public function test_it_Repository_method_getExpired()
    {
    	//add extra group with params
       	$expired_group = $this->user->groups()->create(['expires'=>Carbon\Carbon::now()]);

       	$groups = Group::getExpired();//->get() inside

       	$this->assertEquals($expired_group->id, $groups->first()->id);
    }

//check sort "getPopular" method
    public function test_it_Repository_method_getPopular()
    {
		$expired_group = factory(Group::class)->create(['expires'=>Carbon\Carbon::now()]);
    }

//check sort "getRecent" method
    public function test_it_Repository_method_getRecent()
    {

    }
    
//check sort "getCompleted" method
    public function test_it_Repository_method_getCompleted()
    {

    }    

//check sort "getSpecificType" method
    public function test_it_Repository_method_getSpecificType()
    {

    }

//check sort "getByItem" method
    public function test_it_Repository_method_getByItem()
    {

    }

//check sort "getByUser" method
    public function test_it_Repository_method_getByUser()
    {

    }

//check sort "getPremium" method
    public function test_it_Repository_method_getPremium()
    {
		    $premium_group = $this->user->groups()->create(['premium'=>'true']);

       	$groups = Group::getPremium();

       	$this->assertEquals($premium_group->id, $groups->first()->id);
    }
}








//test just method 
//phpunit --filter name

//migration for test
//add new database (name/database) to config
//create new Database
//add to phpunit.xml <env name="DB_CONNECTION" value="mysql_testing">
//artisan migration --database mysql_testing