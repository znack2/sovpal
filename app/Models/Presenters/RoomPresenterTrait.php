<?php namespace App\Models\Presenters;

trait RoomPresenterTrait
{
    public function getRoomName()
        {
            logger()->info(__METHOD__);
            return $this->type == 'room' 
                 ? $this->name 
                 : $this->tags()->where('type','room')->first()->name;
        }
}

    