<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User\User;
use App\Models\_partials\Permission;
use App\Models\_partials\Role;

use Carbon\Carbon;

class AuthTest extends PHPUnit_Framework_TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateRole, CreatePermission, CreateBusiness;

    // dont use middleware for all class
     // use WithoutMiddleware;

    // use DatabaseMigrations;


	protected $user;

	//method before each test in this class
    public function setUp()
    {
    	$this->user = new User('first_name'=>'znack');
    	$this->user = new Item('first_name'=>'znack');
    	$this->user = new Group('first_name'=>'znack');
    }



    public function testLogin()
    {
        $response = $this->call('GET', '/');
        // $response = $this->call('GET', '/', ['name' => 'Taylor']);

        // 1)
        //dont use middleware just for this method
        // $this->withoutMiddleware();

        // 2)
        //->make() just create ->create() save it
        // $user = factory(User::class)->make();

        // 3)
        //check event is used but not really used
         // $this->expectsEvents(App\Events\UserRegistered::class);
         // $this->withoutEvents();

        // 4)
        // pretend use mock facade
        // Cache::shouldReceive('get')->once()->with('key')->andReturn('value');

        $this->assertTrue(true);
        // $this->seeInDatabase('users', ['email' => 'sally@example.com']);
    }





    public function test_Register()
    {
        // $this->withoutMiddleware();

        $user = $this->createUser(['email' => 'guest@example.org', 'password' => bcrypt('demoguest'), 'username' => 'alariva']);
        $role = $this->createRole();
        $user->assignRole($role->name);
        $this->assertCount(1, $user->roles);
        $this->seeInDatabase('users', ['email' => $user->email, 'id' => $user->id, 'username' => $user->username]);
        // $this->assertEquals(strlen($user->username), 32);

        //2

        $this->visit('/page/landing');
        //incorrect

        //correct
        $user = factory(User::class)->create();

        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('/')
             ->see('Hello, '.$user->name);

        $this->type('owner', 'user_type');
        $this->type('profi', 'user_type');
        $this->type('shop', 'user_type');
        $this->type('fdbfdbdfgb', 'first_name');
        $this->type('dbfdbfdb', 'last_name');
        $this->type('dfbfdbdf', 'street');
        $this->type('fdbfdbdfb', 'house');
        $this->type('dfbfdbdfb', 'corpus');
        $this->type('dfbdfbfdb', 'email');
        $this->type('dfbfdbdfb', 'password');
        $this->type('dfbfdbdfb', 'password_confirmation');
        $this->check('terms');
        $this->press('Создать');
        $this->see('ghvghcghcgh');
        $this->dontSee('Beta');

            //3


        $this->visit('/auth/registration')
             ->see(trans('sovpal.forms.Register_title'))


         // EMPTY 
             ->select($value, $elementName)
             ->seeElement("[name='owner']")
             ->seeElement("[name='profi']")
             ->seeElement("[name='shop']")

             ->seeElement("[name='first_name']")
             ->seeElement("[name='first_name']")
             ->seeElement("[name='last_name']")
             ->seeElement("[name='street']")
             ->seeElement("[name='house']")
             ->seeElement("[name='corpus']")
             ->seeElement("[name='email']")
             ->seeElement("[name='password']")
             ->seeElement("[name='password_confirmation']")
             ->seeElement("[name='terms']")
         ->press('Complete')
             ->see('name filed is required')
             ->see('email filed is required')
             ->see('password filed is required')


         // ERROR 
             ->type('anton','first_name')
             ->type('anton','last_name')
             ->type('anton','street')
             ->type('anton','house')
             ->type('anton','corpus')
             ->type('anton','email')
             ->type('anton','password')
             ->type('anton','password_confirmation')
             ->check('terms')
         ->press('Complete')
             ->see('name must be a valid email address')
             ->see('email must be a valid email address')
             ->see('password must be a valid email address')


         // CORRECT
             ->type('anton','first_name')
             ->type('anton','last_name')
             ->type('anton','street')
             ->type('anton','house')
             ->type('anton','corpus')
             ->type('anton','email')
             ->type('anton','password')
             ->type('anton','password_confirmation')
             ->check('terms')
         ->press('Complete')
             ->seePageIs('/')
             ->see('success');

             //4 checking the session for errors after a POST request:
         $response = $this->post('account@signup', array(
            'username' => 'validusername',
            'email' => 'some@validemail.com',
            'password' => 'passw0rd',
            'password_confirm' => 'passw0rd',
        ));
                
        $this->assertEquals('302', $response->foundation->getStatusCode());
        $session_errors = \Laravel\Session::instance()->get('errors')->all();
        $this->assertNotEmpty($session_errors);
        $this->assertNull($session_errors);
    }     
}