<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VisitTest extends TestCase
{
  public function test_Landing()
    {

        public function test404ErrorPage()
        {
            $response = $this->call('GET', '/language/123');
            $this->assertEquals(404, $response->status());
        }

    
        $this->visit('/page/landing');
        // disable middleware only for this test
        // use WithoutMiddleware;

        $this->see('ЧАСТО ЗАДАВАЕМЫЕ ВОПРОСЫ');
            $this->click('About Us');
            $this->seePageIs('/about-us');
            $this->see('Мы всегда на связи');
            $this->visit('/page/landing');

        $this->see('КОНТАКТНАЯ ИНФОРМАЦИЯ');
            $this->click('Contacts');
            $this->seePageIs('/page/contacts');
            $this->see('Мы всегда на связи');
            $this->type('sdsgsdg', 'name');
            $this->type('sdgsdgsdg', 'email');
            $this->type('dsgsdgsdgsdg', 'message');
            $this->press('Отправить');
            $this->seePageIs('/page/contacts');
            $this->visit('/page/landing');

        $this->see('ВХОД');
            $this->click('About Us');
            $this->seePageIs('/about-us');
            $this->see('ВХОД');
            $this->visit('/page/landing');

        $this->see('РЕГИСТРАЦИЯ');
            $this->click('About Us');
            $this->seePageIs('/about-us');
            $this->see('РЕГИСТРАЦИЯ');
            $this->visit('/page/landing');

        $this->see('БЕЗОПАСНОСТЬ');
            $this->click('About Us');
            $this->seePageIs('/about-us');
            $this->see('БЕЗОПАСНОСТЬ');
            $this->visit('/page/landing');

        $this->see('ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ');
            $this->click('About Us');
            $this->seePageIs('/about-us');
            $this->see('ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ');
            $this->visit('/page/landing');

        $this->see('ВЛАДЕЛЬЦАМ');
            $this->click('About Us');
            $this->seePageIs('/page/owners');
            $this->see('Отличный способ сэкономить.');
            $this->visit('/page/landing');

        $this->see('ДИЗАЙНЕРАМ');
            $this->click('About Us');
            $this->seePageIs('/page/designers');
            $this->see('Отличный способ рассказать о своих товарах.');
            $this->visit('/page/landing');

        $this->see('МАГАЗИНАМ');
            $this->click('About Us');
            $this->seePageIs('/page/shops');
            $this->see('Отличный способ рассказать о своих товарах.');
            $this->visit('/page/landing');

        //premium
        //blog
    }       

       public function test_if_can_render_the_homepage()
    {
        $this->visit('/')
            ->see('Antvel eCommerce')
            ->assertResponseOk();
    }
    public function test_if_the_homepages_are_equal()
    {
        $this->assertEquals(
            $this->visit('/'),
            $this->visit('home')
        );
    }
    public function test_about_page()
    {
        $this->visit('/')
            ->click(trans('company.about_us'))
            ->seePageIs('about')
            ->see(trans('company.about_us'))
            ->assertResponseOk();
    }
    public function test_refunds_page()
    {
        $this->visit('/')
            ->click(trans('company.refund_policy'))
            ->seePageIs('refunds')
            ->see(trans('company.refund_policy'))
            ->assertResponseOk();
    }
    public function test_privacy_page()
    {
        $this->visit('/')
            ->click(trans('company.privacy_policy'))
            ->seePageIs('privacy')
            ->see(trans('company.privacy_policy'))
            ->assertResponseOk();
    }
    public function test_terms_page()
    {
        $this->visit('/')
            ->click(trans('company.terms_of_service'))
            ->seePageIs('terms')
            ->see(trans('company.terms_of_service'))
            ->assertResponseOk();
    }
    public function test_account_links_on_homepage_as_a_guest()
    {
        $this->visit('/')
            ->click(trans('user.login'))
            ->seePageIs('auth/login')
            ->see(trans('user.sign_in_your_account'))
            ->assertResponseOk();
        $this->visit('/')
            ->click(trans('user.register'))
            ->seePageIs('auth/register')
            ->see(trans('user.set_up_new_account'))
            ->assertResponseOk();
    }
    public function test_wish_list_links_as_a_guest()
    {
        $this->visit('wishes')
            ->see(trans('user.sign_in_your_account'))
            ->assertResponseOk();
        $this->visit('/')
            ->click(trans('user.your_wishlist'))
            ->see(trans('user.sign_in_your_account'))
            ->assertResponseOk();
    }
}