<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User\User;
use App\Models\_partials\Permission;
use App\Models\_partials\Role;

class AuthTest extends PHPUnit_Framework_TestCase
{
    use DatabaseTransactions;
    use CreateUser, CreateRole, CreatePermission, CreateBusiness;

	protected $user;

	//method before each test in this class
    public function setUp()
    {
    	$this->user = new User('first_name'=>'znack');
    	$this->user = new Item('first_name'=>'znack');
    	$this->user = new Group('first_name'=>'znack');
    }

    public function test_a_user_has_fields()
    {
    	$this->user->createItem($this->item);
    	$this->group->addUser($this->user);

        $this->assertEquals('Znack',$this->user->first_name);
        // $this->assertEquals('Znack',$this->user->last_name);
        // $this->assertEquals('Znack',$this->user->name);
        // $this->assertEquals('Znack',$this->user->name);
        // $this->assertEquals('Znack',$this->user->name);
    }


  


    public function test_Login()
    {
        $this->visit('/page/landing');
        //incorrect
        $this->type('ghvghcghcgh', 'email');
        $this->type('hvghcghcghc', 'password');
        $this->check('remember');
        $this->press('Вход');
        $this->see('ghvghcghcgh');
        //corect
        $this->type('ghvghcghcgh', 'email');
        $this->type('hvghcghcghc', 'password');
        $this->check('remember');
        $this->press('Вход');
        $this->seePageIs('/page/landing');
        $this->dontSee('Beta');

        //2

        $this->visit('/page/landing')
             ->see(trans('sovpal.forms.Register_title'))

             
         // EMPTY 
             ->seeElement("[name='email']")
             ->seeElement("[name='password']")
             ->seeElement("[name='remember']")
         ->press('Complete')
             ->see('name filed is required')
             ->see('email filed is required')
             ->see('password filed is required')


         // ERROR 
             ->seeElement("[name='email']")
             ->seeElement("[name='password']")
             ->check("[name='remember']")
         ->press('Complete')
             ->see('name must be a valid email address')
             ->see('email must be a valid email address')
             ->see('password must be a valid email address')


         // CORRECT
             ->seeElement("[name='email']")
             ->seeElement("[name='password']")
             ->check("[name='remember']")
         ->press('Complete')
            ->seePageIs('/')
            ->see('success');

        //3
            
        $this->visit('/');
        $this->click('Login');
        $this->see('Login')    // Form header
             ->see('Email')    // Login Form field
             ->see('Password') // Login Form field
             ->see('Github')   // oAuth button
             ->see('Facebook') // oAuth button
             ->see('Google');  // oAuth button
    }    


    public function test_Password_Remind()
    {
        $this->visit('/auth/password/reset');
        $this->see('ghvghcghcgh');
        $this->type('dfbdfbfdb', 'email');
        $this->press('Вход');
        $this->see('ghvghcghcgh');
    }

    
    public function Logout()
    {

    }
    
    public function ChangePassword()
    {

    }    
}


//first all test without errors
//second all test empty forms
//third all test with wrong input




    public function it_presents_the_welcome_page()
    {
        $this->visit('/');
        $this->see('The booking app for successful professionals')
             ->see('Let\'s begin')
             ->see('Login');
    }


    public function it_presents_the_register_page()
    {
        $this->visit('/');
        $this->click('Let\'s begin');
        $this->see('We are going to build your profile') // Form header
             ->see('Your Email')      // Login Form field
             ->see('A password')      // Login Form field
             ->see('Repeat password') // Login Form field
             ->see('Register');       // Submit button
    }


    public function it_presents_the_register_page_through_login()
    {
        $this->visit('/auth/login');
        $this->click('Not registered yet');
        $this->see('We are going to build your profile') // Form header
             ->see('Your Email')      // Login Form field
             ->see('A password')      // Login Form field
             ->see('Repeat password') // Login Form field
             ->see('Register');       // Submit button
    }

   public function a_user_may_register_for_an_account_but_must_confirm_their_email_address()
        {
            // When we register...
            $this->visit('register')
                 ->type('JohnDoe', 'name')
                 ->type('john@example.com', 'email')
                 ->type('password', 'password')
                 ->press('Register');
        
            // We should have an account - but one that is not yet confirmed/verified.
            $this->see('Please confirm your email address.')
                 ->seeInDatabase('users', ['name' => 'JohnDoe', 'verified' => 0]);
        
            $user = User::whereName('JohnDoe')->first();
        
            // You can't login until you confirm your email address.
            $this->login($user)
                 ->see('Could not sign you in.');
        
            // Like this...
            $this->visit("register/confirm/{$user->token}")
                 ->see('You are now confirmed. Please login.')
                 ->seeInDatabase('users', ['name' => 'JohnDoe', 'verified' => 1]);
        }
    

    public function a_user_may_login()
        {
            $this->login()
                 ->see('Lesson complete. Good job!')
                 ->onPage('dashboard');
        }
    
    protected function login($user = null)
        {
            $user = $user ?: $this->factory->create('App\User', ['password' => 'password']);
        
            return $this->visit('login')
                        ->type($user->email, 'email')
                        ->type('password', 'password') // You might want to change this.
                        ->press('Sign In');
        }


        

    public function a_permission_belongs_to_many_roles()
    {
        $permission = $this->createPermission();
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $permission->roles());
    }
    
    public function a_role_may_belong_to_a_user()
    {
        $user = $this->createUser();
        $role = $this->createRole();
        $user->roles()->save($role);
        $this->assertTrue($user->hasRole($role->name));
        $this->assertTrue($user->hasRole($user->roles));
    }

    public function a_role_establishes_permissions()
    {
        $role = $this->createRole();
        $this->assertInstanceOf(Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $role->permissions());
    }

    public function a_role_gives_permissions()
    {
        $permission = $this->createPermission();
        $role = $this->createRole();
        $role->givePermissionTo($permission);
        $this->assertInstanceOf(Permission::class, $role->permissions()->first());
    }

    public function it_rejects_unregistered_email()
    {
        $this->visit(route('user.agenda'));
             ->seePageIs('/auth/login');
             ->click('Forgot password');
             ->type('unregistered@example.org', 'email');
             ->press('Send me the reset link');
             ->see('We can\'t find a user with that e-mail address.');
    }

    public function it_provides_password_reset_to_registered_email()
    {
        $this->user = $this->createUser();
        $this->visit(route('user.agenda'));
            ->seePageIs('/auth/login');
            ->click('Forgot password');
            ->type($this->user->email, 'email');
            ->press('Send me the reset link');
            ->see('We have e-mailed your password reset link');
    }

    public function it_resets_the_password()
    {
        $this->it_provides_password_reset_to_registered_email();

        $passwordReset = DB::table('password_resets')->select('token')->where('email', $this->user->email)->first();

        $this->visit('/auth/password/reset/'.$passwordReset->token);
            ->type($this->user->email, 'email');
            ->type('nevermind', 'password');
            ->type('nevermind', 'password_confirmation');
            ->press('Reset password');
            ->assertEquals($this->user->email, auth()->user()->email);
    }

    public function it_rejects_invalid_token()
    {
        $this->it_provides_password_reset_to_registered_email();
            ->visit('/auth/password/reset/'.'an-invalid-token');
            ->type($this->user->email, 'email');
            ->type('nevermind', 'password');
            ->type('nevermind', 'password_confirmation');
            ->press('Reset password');
            ->see('This password reset token is invalid');
    }

    public function it_provides_successful_registration()
    {
        $user = $this->makeUser();
        $this->visit('auth/register')
            ->seeRegistrationFormFields()
            ->type($user->name, 'name')
            ->type($user->username, 'username')
            ->type($user->email, 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press('Register')
            ->see('Well done! Please tell us what would you like to do');
    }

    public function it_denies_no_password_registration()
    {
        $user = $this->makeUser();

        $this->visit('auth/register')
            ->seeRegistrationFormFields()
            ->type($user->name, 'name')
            ->type($user->username, 'username')
            ->type($user->email, 'email')
            ->press('Register')
            ->see('The password field is required.');
    }

    /////////////
    // Helpers //
    /////////////

    protected function seeRegistrationFormFields()
    {
        $this->see('Hi! We are going to build your profile')
            ->see('Your name')
            ->see('Username')
            ->see('Your Email')
            ->see('A password')
            ->see('Repeat password')
            ->see('Register');
    }


    public function it_provides_successful_login()
    {
        $user = $this->createUser(['email' => 'test@example.org', 'password' => bcrypt('password')]);

        $this->visit('auth/login');
             ->see('Login');
             ->see('Password');
             ->see('Remember me');
             ->type($user->email, 'email');
             ->type('password', 'password');
             ->press('Login');
             ->see('Well done! Please tell us what would you like to do');
    }

    public function it_provides_logout()
    {
        $user = $this->createUser();

        $this->actingAs($user);
            ->visit('auth/logout');
            ->seePageIs('/');
            ->see('Login');
    }

    public function it_denies_bad_login()
    {
        $user = $this->createUser(['email' => 'test@example.org', 'password' => bcrypt('password')]);
        
        $this->visit('auth/login');
            ->see('Login');
            ->see('Password');
            ->see('Remember me');
            ->type($user->email, 'email');
            ->type('BAD PASSWORD!', 'password');
            ->press('Login');
            ->see('These credentials do not match our records');
    }

    public function it_requests_login_when_attempting_to_access_a_protected_page()
    {
        $this->visit(route('user.agenda'));
            ->seePageIs('/auth/login');
            ->see('Login');
            ->see('Password');
            ->see('Remember me');
    }


    public function it_shows_the_default_wizard_for_business_owner()
    {
        $owner = $this->createUser();
        $business = $this->createBusiness();
        $business->owners()->save($owner);
        $this->actingAs($owner);
        $this->visit(route('home'));
        $this->see($business->name);
        $this->seePageIs($business->slug.'/manage/dashboard');
    }

    public function it_shows_the_terms_and_conditions()
    {
        $user = $this->createUser();
        $this->actingAs($user);
            ->visit(route('wizard.terms'));
            ->see('TERMS AND CONDITIONS');
    }

    public function it_shows_the_pricing_table()
    {
        $user = $this->createUser();
        $this->actingAs($user);
             ->visit(route('wizard.pricing'));
             ->see('Ideal for freelancers');
    }

    public function it_shows_the_wizard_welcome()
    {
        $user = $this->createUser();
        $this->actingAs($user);
             ->visit(route('wizard.welcome'));
             ->see('Please tell us what would you like to do');
    }




    protected function setLanguageAndGoToRegister()
    {
        return $this->visit('/lang/en_US.utf8')
                    ->visit('/auth/register');
    }

    public function testRegistrationSuccess()
    {
        $this->setLanguageAndGoToRegister()
             ->type('John', '#name')
             ->type('test@timegrid.io', '#email')
             ->type('password', '#password')
             ->type('password', '#password_confirmation')
             ->press('Register')
             ->see('I run a business');
    }

    public function testRegistrationPasswordMissmatch()
    {
        $this->setLanguageAndGoToRegister()
             ->type('John', '#name')
             ->type('test@timegrid.io', '#email')
             ->type('password', '#password')
             ->type('wrong', '#password_confirmation')
             ->press('Register')
             ->see('Please confirm your password correctly');
    }




//    public function it_fails_to_submit_an_invalid_token_post()
//    {
//        // Given I am a not authenticated user (guest)
//
//        // And I visit the homepage
//        $this->visit('/auth/login');
//
//        // And I fill the login form
//        $this->type('test@example.org', 'email')
//             ->type('password', 'password');
//
//        // And my session expired so as a token was invalidated
//        session()->regenerateToken();
//
//        // And I submit the form
//        $this->press('Login');
//
//        // Then I should see a message asking for resubmit
//        $this->see('please submit your form again');
//    }