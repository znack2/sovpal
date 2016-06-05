<?php namespace App\Models\Presenters;

use Carbon;

trait ItemPresenterTrait
{   
    public function getCurrentGroup() 
        {
            logger()->info(__METHOD__);
            if(count($this->groups()->get()) != 0)
                {
                    return trans('sovpal.closeGroup') . $this->groups()->where('active','true')
                        ->whereBetween('expires', [Carbon::now(),Carbon::now()
                        ->addMonth(1)])
                        ->get(['expires']);
                }
            return trans('sovpal.noGroup');
        }

    public function returnDate()
        {
            logger()->info(__METHOD__);
            if($this->users()->first())
                {
                    $how_long = $this->users()->last()->pivot->how_long;
                    return trans('sovpal.returnDate').Carbon::parse($how_long)->diffInDays();
                }
            return trans('sovpal.FreeToOrder');
        }

    public function leftMaterials()
        {
            logger()->info(__METHOD__);
            $default_qty = $this->qty;

            if($this->users()->first())
            {
                $take_qty = $this->users()->last()->pivot->qty;
                return $default_qty - $take_qty;
            }
            return $default_qty;
        }

    public function checkAdd($user)
        {
            logger()->info(__METHOD__);
            return $this->users()->get()->contains($user->id) ? true : false;
             // $exist = $this->users()->whereHas('items', function($query) use($user) {
             //     $query->where('user_id', $user->id);})->get();
        } 
}

    