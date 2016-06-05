<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTest extends TestCase
{

    public function test_Create_Room()
    {
        $this->addTags();
    }    

    public function addTags()
    {
        $this->assertTrue(true);
    }    



    public function test_Remove_Room()
    {
        $this->assertTrue(true);
    }

    public function test_add_element_to_Room()
    {
        $this->assertTrue(true);
    }

    public function test_remove_element_from_Room()
    {
        $this->assertTrue(true);
    }

}
