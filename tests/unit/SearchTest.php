<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{

    public function test_Search_Users()
    {
        $this->visit('/page/landing');
        $this->type('dsgfdsgdsgdsg', 'street');
        $this->press('');
        $this->dontSee('Beta');
    }

    public function test_SearchItems()
    {
    }

    public function test_SearchGroups()
    {
    }

    public function test_ifEmptyItems()
    {
    }
    
    public function test_ifEmptyGroups()
    {
    }
}
