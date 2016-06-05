
<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VisitTest extends TestCase
{
 public function test_Profile()
    {
        $this->visit('/page/landing')
             ->see(trans('sovpal.forms.Register_title'))

             
         // EMPTY 
             ->seeElement("[name='email']")
             ->seeElement("[name='password']")
             ->seeElement("[name='remember']")
             ->attach($pathToFile, $elementName)
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
    }
}