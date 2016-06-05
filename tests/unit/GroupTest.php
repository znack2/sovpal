<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GroupTest extends TestCase
{
    public function test_Create_Group()
    {
        $this->addItem();
        $this->addTags();
        $this->assertViewHas('foo', 'bar');
    }    

    public function addItem()
        $this->assertTrue(true);
    }    

    public function addTags()
    {
        $this->assertTrue(true);
    }    



    public function test_Remove_Group()
    {
        $this->assertTrue(true);
    }

    public function test_Join_Group()
    {
        $this->assertTrue(true);
    }

    public function test_Withdrow_Group()
    {
        $this->assertTrue(true);
    }
}
