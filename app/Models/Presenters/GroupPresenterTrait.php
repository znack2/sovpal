<?php namespace App\Models\Presenters;

use App\Models\Item\Item;
use App\Models\_partials\Image;
use DB;
use Carbon\Carbon;

trait GroupPresenterTrait
{
/**
 *
 *  join group
 *  
 *
 */
     public function getMembers()
        {     
          return $this->users()->paginate(15);
        }  

    public function checkJoin($user)
        {
            logger()->info(__METHOD__);
            $users = $this->users()->get();
            return $users->contains($user->id) ? true : false;
        }   


    public function WhenjoinGroup($user_id)
        {
            logger()->info(__METHOD__);
            $result = DB::connection('mysql')
                    ->table('group_user')
                    ->where('group_id',$this->id)
                    ->where('user_id',$user_id)
                    ->first();
            return Carbon::parse($result->created_at)->diffForHumans();
        }



    public function getItem() 
        {
            logger()->info(__METHOD__);
            return Item::where('id',$this->item_id)->get();
         } 



    public function getItem_image()
        {
           logger()->info(__METHOD__);
   //      $imagged = Imagged::where('imagged_id',$this->item_id)
       //          ->where('imagged_type','item')
       //          ->first();
       // if($imagged)
       //      {
       //         $image =  Image::find($imagged->id)->get(['url']);  
       //         $result = isset($image) ? $image : 'default'; 
       //      }
       //      return $result;
            return 'default.png';
        }



    public function getExpires() 
        {
          logger()->info(__METHOD__);
            $Date = Carbon::parse($this->expires)->diffInDays();

            if($Date == 1)
              {
                $days = trans('sovpal.days');
              }
            elseif($Date > 1 && $Date < 5)
              {
                $days = trans('sovpal.days2');
              }
            else
              {
                $days = trans('sovpal.days3');
              }
            
            return trans('sovpal.Expire').$Date.$days;
        }         



    public function leftUsers() 
        {
        logger()->info(__METHOD__);
        return $this->users() 
          ? trans('sovpal.left').$this->user_need - $this->user_count.trans('sovpal.people')
          : trans('sovpal.complete');
        }
}

    