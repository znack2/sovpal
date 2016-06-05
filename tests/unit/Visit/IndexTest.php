<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VisitTest extends TestCase
{
  public function testIndexGroups()
    {
        $this->visit('/index/groups');
        //search
        $this->type('hgchgchgchg', 'date');
        $this->seePageIs('/index/groups');

        //sort
        $this->press('цена');
        $this->press('дата');

        //checkbox
        $this->check('null');
        $this->seePageIs('/index/groups');
        $this->check('null');
        $this->seePageIs('/index/groups');
        $this->check('null');
        $this->seePageIs('/index/groups');
        $this->check('null');
        $this->seePageIs('/index/groups');

        //sidebar
        $this->press('сантехника');

        $this->see('К нашему сожалению ничего ненайдено,измените условия поиска');
        $this->check('empty_form');
        $this->seePageIs('/index/groups');
        $this->see('You got message');
    }

    public function testIndexOwners()
    {
        $this->visit('/index/users');

        //checkbox
        $this->check('null');
        $this->visit('/index/users');
        $this->check('null');
        $this->visit('/index/users');
        $this->check('null');
        $this->visit('/index/users');
    }

    public function testIndexProfi()
    {
        $this->visit('/index/users');

        //checkbox
        $this->check('null');
        $this->visit('/index/users');

        //sidebar
        $this->press('3д визаулизация');
        $this->press('декор');
        $this->press('работа с документами');
        $this->press('рисунок');
        $this->press('арх надзор');
        $this->press('перепланировка');
        $this->press('закупки');
        $this->press('замер');
    }

    public function testIndexShops()
    {
        $this->visit('/index/users');
        //sidebar
        $this->press('Балкон');
        $this->press('Ванна');
        $this->press('Спальня');
        $this->press('Детская');
        $this->press('Прихожая');
        $this->press('Кухня');
        $this->press('Гостиная');
        $this->press('Кабинет');
        $this->press('Гардероб');

        //checkbox
        $this->check('null');
        $this->seePageIs('/index/users');
    }

    public function testIndexItems()
    {
        $this->visit('/index/items');
        //sidebar
        $this->press('Балкон');
        $this->press('Ванна');
        $this->press('Спальня');
        $this->press('Детская');
        $this->press('Прихожая');
        $this->press('Кухня');
        $this->press('Гостиная');
        $this->press('Кабинет');
        $this->press('Гардероб');

        //checkbox
        $this->check('null');
        $this->seePageIs('/index/items');
    }

    public function testIndexTools()
    {
        $this->visit('/index/items');
        //sidebar
        $this->press('электрика');
        $this->press('ручные');
        $this->press('измерительные');
        $this->press('универсальные');

        //checkbox
        $this->check('null');
        $this->seePageIs('/index/items');
    }

    public function testIndexMaterials()
    {
        $this->visit('/index/items');

        //sidebar
        $this->press('столярные');
        $this->press('декор');
        $this->press('демонтажные');
        $this->press('электрика');
        $this->press('кованные');
        $this->press('монтажные');
        $this->press('другие');
        $this->press('лакокрасочные');
        $this->press('Паркетная доска');
        $this->press('сантехнические');
        $this->press('Керамическая плитка');

        //checkbox
        $this->check('null');
        $this->visit('/index/items');
    }
}