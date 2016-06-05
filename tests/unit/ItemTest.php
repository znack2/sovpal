<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{

    public function test_Create_Item_by_Shop()
    {
        $this->actingAs($this->issuer->fresh());
        $this->addElement();
        $this->addTags();
    }    

    public function test_Create_Item_by_Owner()
    {
        $this->actingAs($this->issuer->fresh());
        $this->addElement();
        $this->addTags();
    }    

    public function addElement()
        $this->assertTrue(true);
    }    

    public function addTags()
    {
        $this->assertTrue(true);
    }    
}
