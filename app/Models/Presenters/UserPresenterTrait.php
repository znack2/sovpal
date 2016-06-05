<?php namespace App\Models\Presenters;

trait UserPresenterTrait
{
//level
  public function getLevel()
        {
            logger()->info(__METHOD__);
            if($this->type == 'owner')
                {
                    switch ($this->level) {
                        case '1': $level = 'novice1';    
                            break;           
                        case '2': $level = 'novice2';    
                            break;           
                        case '3': $level = 'novice3';    
                            break;           
                        case '4': $level = 'novice4';    
                            break;                  
                        case '5': $level = 'novice5';    
                            break;                  
                        case '6': $level = 'novice6';    
                            break;                  
                        case '7': $level = 'novice7';    
                            break;              
                        case '8': $level = 'novice8';    
                            break;              
                        case '9': $level = 'novice9';  
                            break;                 
                        default:  $level = 'novice';     
                            break;
                        }
                }
            elseif($this->type == 'shop')
                {
                    switch ($this->level) {
                       case '1': $level = 'novice1';    
                           break;           
                       case '2': $level = 'novice2';    
                           break;           
                       case '3': $level = 'novice3';    
                           break;           
                       case '4': $level = 'novice4';    
                           break;                  
                       case '5': $level = 'novice5';    
                           break;                  
                       case '6': $level = 'novice6';    
                           break;                  
                       case '7': $level = 'novice7';    
                           break;              
                       case '8': $level = 'novice8';    
                           break;              
                       case '9': $level = 'novice9';  
                           break;                 
                       default:  $level = 'novice';  
                            break;
                        }
                }
            else
                {
                       switch ($this->level) {
                          case '1': $level = 'novice1';    
                              break;           
                          case '2': $level = 'novice2';    
                              break;           
                          case '3': $level = 'novice3';    
                              break;           
                          case '4': $level = 'novice4';    
                              break;                  
                          case '5': $level = 'novice5';    
                              break;                  
                          case '6': $level = 'novice6';    
                              break;                  
                          case '7': $level = 'novice7';    
                              break;              
                          case '8': $level = 'novice8';    
                              break;              
                          case '9': $level = 'novice9';  
                              break;                 
                          default:  $level = 'novice';   
                               break;
                        }
                }
            return trans('sovpal.'.$level);
        }
//name
	public function getFullName()
	    {
            logger()->info(__METHOD__);
	    	return $this->first_name . ' ' . $this->last_name;
	        // $profile = $this->entity->profile;
	        // if (! is_null($profile) && ! empty($profile->name)) {
	        //     return $profile->name;
	        // }
	        // return $this->entity->username;
	    }
//date
    public function getRecent($field)
        {
            logger()->info(__METHOD__);
            $Date = \Carbon\Carbon::parse($this->$field);
            $date = $Date->diffForHumans();
            return  $field == 'updated_at' ? trans('sovpal.hasBeenUpdated') . $date : trans('sovpal.NoUpdates');

            // if (count($items) == 0) {return 'No activity';}
            // $collection = $items->getCollection();
            // $sorted     = $collection->sortBy(function ($trick) {
            //     return $trick->created_at;
            // })->reverse();
            // $last = $sorted->first();
            // return $last->created_at->diffForHumans();
        }
//gender
    public function getGender()
        {
            logger()->info(__METHOD__);
            $gender = $this->gender;
            switch($gender) {
                case '0' :
                    return 'male';
                    break;
                case '1' :
                    return 'female';
                    break;
            }
        }

//address
    public function getAddress()
        {
          logger()->info(__METHOD__);
          if($address = $this->addresses->first())
          {
              return $address->street .' '. $address->house .'/'. $address->corpus;
          }
          return 'no Address';
        }

//group
    public function hasGroups() 
        { 
          logger()->info(__METHOD__);
            return count($this->groups) > 0; 
        }
//display contacts in profile
    public function getPurchaseContact($user)
        {
          logger()->info(__METHOD__);
            //get all join_groups of currentUser
            //get all groups of user
            //check similar id
            if($user->groups()->count() && $this->join_groups()->count())
            {
                $owner_groups = $user->groups->lists('id');
                $join_groups  = $this->join_groups->lists('id');
                return (count(array_intersect($criminals, $people))) ? true : false;
            }
            return false;
        }
}

    