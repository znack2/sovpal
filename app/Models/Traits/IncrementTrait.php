<?php namespace App\Models\Traits;

use App\Models\User\User;
use App\Models\Item\Item;
use App\Models\Group\Group;

use App\Models\_partials\Element;
use App\Models\_partials\Tag;

use Auth;

trait IncrementTrait
{
  //      $message = 'You have been successfully withdrown from group';
  //      return $message;

    public function saveModel($model)
      {
        return $model->save();
      } 

    public function deleteModel($model)
      {
          switch ($class = class_basename($model)) {
              case 'Group': $name = $model->item()->title;
                  break;
              case 'Item': $name = $model->title;
                  break;
              case 'User': $name = $model->first_name;
                  break;
              case 'Room' || 'Element' : $name = $model->name;
                  break;
          }
          $model->delete();
          return $class . $name . 'successfully has been destroyed!';
      } 

    
            
      //   $previousCount = $this->model->tagged()->whereName($tag)->take(1)->count();
      //   if($previousCount >= 1) { return; }
      
      // $tagged = Tagged::whereName($tag)->first();
      //     // $tagged = new Tagged([
      //     //   'tag'=>$tag,
      //     //   'slug'=>str_slug($tag)]);
      
      // $this->model->tags()->save($tagged);
      // $this->incrementTagCount($tag, 1);
      // return true;
  
    public function addModel($model,$related,$item)
      {
          $this->incrementModel($model,$related,$item);

        // $user->join_groups()->save($group);
        // $group->increment('user_join_count');
        // $user->increment('join_count');

          if($related == 'elements' || $related == 'join_groups')
          {
              return $model->$related()->attach($item->id);
          }
          elseif($related == 'items' && $item == 'tool')
          {
              return $model->$related()->attach($item->id, ['how_long' => 22]);
          }
          elseif($related == 'items' && $item == 'tool')
          {
              return $model->$related()->attach($item->id, ['qty' => 22]);
          }
          else
          {
              return $model->$related()->associate($item->id);
          }
      }       




    public function removeModel($model,$related,$item)
      {
        $this->decrementModel($model,$related,$item);
        // $user->join_groups()->detach($group->id);
        // $group->decrement('user_join_count');
        // $user->decrement('join_count');

        return $model->$related()->detach($item->id);
      }   





    public function incrementModel($model,$related,$item)
      {
          switch ($related) {
              case 'user': $extra_model = $related::find($item->id);
                  break;
              case 'element': $extra_model = $related::find($item->id);
                  break;
              case 'elements' : $extra_model = Element::find($item->id);
                  break;
              case 'item': $extra_model = $related::find($item->id);
                  break;
              case 'items' : $extra_model = Item::find($item->id);
                  break;
              case 'join_groups' : $extra_model = Group::find($item->id);
                  break;
              default:
                  break;
          }
          $extra_model->increment(strtolower(class_basename($model)).'_count');
          return $this->saveModel($extra_model);
      }
    public function decrementModel($model,$related,$item)
      {
          $extra_model = $related::find($item->id);
          $related == 'user' ? $this->getLevel($extra_model) : false;

          strtolower(class_basename($model)) == 'user'
              ? $extra_model->decrement($model->type.'_count')
              : $extra_model->decrement(strtolower(class_basename($model)).'_count');

          return $this->saveModel($extra_model);
      }




    public function getLevel($user)
        {
            switch ($this->type) {
                case 'owner':
                    $rooms      = $this->room_count;
                    $elements   = $this->element_count;
                    $items      = $this->item_count;
                    $join_group = $this->join_count;

                    switch (true) {
                        case ($rooms > 1 && $elements > 1): $result = 1;
                            break;              
                        case ($rooms > 2 && $elements > 10): $result = 2;
                            break;              
                        case ($rooms > 3 && $elements > 50): $result = 3;
                            break;              
                        case ($rooms > 5 && $elements > 50): $result = 4;
                            break;         
                         case ($rooms > 1 && $items > 10 && $join_group > 1 ): 5;
                            break;
                        case ($rooms > 1 && $items > 30 && $join_group > 5): 6;
                            break;
                        case ($rooms > 1 && $items > 40 && $join_group > 10): 7;
                            break;
                        case ($rooms > 1 && $items > 70 && $join_group > 20): 8;
                            break;
                        case ($rooms > 1 && $items > 100 && $join_group > 50): 9;
                            break;
                        default: $result = 0;
                            break;
                        }
                    break;            
                case 'shop':

                    $items      = $this->item_count;
                    $own_group  = $this->group_count;

                    switch (true) {
                        case ($items > 10 && $own_group > 1): $result = 1;
                            break;
                        case ($items > 20 && $own_group > 5): $result = 2;
                            break;                        
                        case ($items > 30 && $own_group > 5): $result = 3;
                            break;
                        case ($items > 40 && $own_group > 10): $result = 4;
                            break;
                        case ($items > 50 && $own_group > 20): $result = 5;
                            break;                        
                        case ($items > 60 && $own_group > 20): $result = 6;
                            break;                        
                        case ($items > 70 && $own_group > 20): $result = 7;
                            break;                        
                        case ($items > 80 && $own_group > 20): $result = 8;
                            break;                        
                        case ($items > 90 && $own_group > 20): $result = 9;
                            break;
                        default: $result = 0;
                            break;
                    }
                    break;            
                case 'profi':$rooms = $this->room_count;
                        switch (true) {
                            case ($rooms > 10): $result = 1;
                                break;
                            case ($rooms > 20): $result = 2;
                                break;                            
                            case ($rooms > 30): $result = 3;
                                break;
                            case ($rooms > 40): $result = 4;
                                break;                            
                            case ($rooms > 50): $result = 5;
                                break;
                            case ($rooms > 60): $result = 6;
                                break;                            
                            case ($rooms > 70): $result = 7;
                                break;                            
                            case ($rooms > 80): $result = 8;
                                break;                            
                            case ($rooms > 90): $result = 9;
                                break;
                            default: $result = 0;
                                break;
                        }
                    break;
            }
            $user->level = $result;
            return $user->save();
        }
      // $counter = $this->users()->first();

      // if($counter) {
      //     $counter->count++;
      //     $counter->save();
      // } else {
      //     $counter->count = 1;
      //     $this->views()->save($counter);
      // }

      // if($counter) {
      //     $counter->count--;
      //     if($counter->count) {
      //         $counter->save();
      //     } else {
      //         $counter->delete();
      //     }
      // }



      // if($count <= 0) { return; }
      
      // $tag = $this->tagged()->where('name',  $name)->first();

      // if(!$tag) {
      //   $tag = new Tag;
      //   $tag->name = $name;
      //   $tag->slug = str_slug($name);
      //   $tag->save();
      // }
      // elseif($tag)
      //   {
          //$tag->count = $tag->count - $count;
                 //    if($tag->count < 0) {
                 //      $tag->count = 0;
                 //    }
                 //    $tag->save();
        //}
      
      // $tag->count = $tag->count + $count;
      // $tag->save();

    public function activate($model)
       {    
         $model->active == true;   
         return $model->save();
       }   
}


// public function attachItem($room,$request)
//   {
//     if($request->has('item')) {   
//       $room->items()->attach($request['item']);
//       //update by default not in RoomRepo
//       $room->update(['last_added_item_id',$request['item']]);
//       $room->increment('item_count');
//       $this->incrementModel($room,'item',$request['item']);
//       $this->incrementModel($item,'user',\Auth::id());
//       $this->saveModel($room);
//     } 
//     if($request->has('element')) {   

//       $room->elements()->attach($request['element']);
//       $room->increment('element_count');
//       $this->incrementModel($room,'element',$request['element']);
//       $this->incrementModel($element,'user',\Auth::id());
//       $this->saveModel($room);
//     } 
//   } 

// public function detachItem($room,$request)
//   {
//     if($request->has('item')) {   

//       $room->items()->detach($request['item']);
//       $room->decrement('item_count');
//       $this->decrementModel($room,'item',$request['item']);
//       $this->decrementModel($item,'user',$currentUser->id);
//       $this->saveModel($room);
//     } 
//     if($request->has('element')) {   
//       $room->elements()->detach($request['element']);
//       $room->decrement('element_count');
//       $this->decrementModel($room,'element',$request['element']);
//       $this->decrementModel($element,'user',$currentUser->id);
//       $this->saveModel($room);
//     } 
//   }

