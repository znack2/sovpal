<?php namespace Tests\Controller;

use Tests/TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthController extends TestCase
{

// 1)home route - check login user 
// 2)If not redirect to login with flash.
// 3)After login redirect back home page.
// 4)If login fails redirect back to login with flash.


    public function Register()
    {
        $response = $this->call('GET', 'login');
        $this->assertTrue($response->isOk());
        View::shouldReceive('make')->with('login');
    }    
/**
 *
 *
 */
    public function getConfirmation()
    {
        $this->assertTrue(true);
    }    
/**
 *
 *
 */
    public function postLogin()
    {
        $this->assertTrue(true);
    }    
/**
 *
 *
 */
    public function postRegistr()
    {
        $this->assertTrue(true);
    }    
/**
 *
 *
 */
    public function postConfirmation()
    {
        $this->assertTrue(true);
    }
/**
 *
 *
 */
    public function Logout()
    {
        $this->assertTrue(true);
    }
}

    public function it_redirects_back_to_form_if_login_fails()
    {
        // $credentials = [
        //     'email' => 'test@test.com',
        //     'password' => 'secret',
        // ];

        // Auth::shouldReceive('attempt')
        //      ->once()
        //      ->with($credentials)
        //      ->andReturn(false);

        // $this->call('POST', 'login', $credentials);

        // $this->assertRedirectedToAction(
        //     'AuthenticationController@login', 
        //     null, 
        //     ['flash_message']
        // );
    }

    public function it_redirects_to_home_page_after_user_logs_in()
    {
        // $credentials = [
        //     'email' => 'test@test.com',
        //     'password' => 'secret',
        // ];

        // Auth::shouldReceive('attempt')
        //      ->once()
        //      ->with($credentials)
        //      ->andReturn(true);

        // $this->call('POST', 'login', $credentials);

        // $this->assertRedirectedTo('home');
    }

// ---home---

    public function it_redirects_to_login_if_user_is_not_authenticated()
    {
        // Auth::shouldReceive('check')->once()->andReturn(false);

        // $response = $this->call('GET', 'home');

        // // Check that you're redirecting to a specific controller action with a flash message
        // $this->assertRedirectedToAction('AuthenticationController@login', null, ['flash_message'] );

        // // Only check that you're redirecting to a specific URI
        // $this->assertRedirectedTo('login');

        // // Just check that you don't get a 200 OK response.
        // $this->assertFalse($response->isOk());

        // // Make sure you've been redirected.
        // $this->assertTrue($response->isRedirection());
    }

    public function it_returns_home_page_if_user_is_authenticated()
    {
        // Auth::shouldReceive('check')->once()->andReturn(true);
        // $this->call('GET', 'home');
        // $this->assertResponseOk();
    }