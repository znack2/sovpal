<?php namespace App\Models\Group;

use App\Exceptions\Exceptions;
use Illuminate\Support\Facades\Config;

use App\Models\Group\Group;
use App\Models\Item\Item;
use App\Models\_partials\Element;
use App\Models\Group\GroupInterface;
use App\Models\Filters\AbstractRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/*********************************************************************

                ( Group )

**********************************************************************/

class GroupRepo extends AbstractRepo implements GroupInterface
{
   protected $expires = 259200;

   public function __construct(Group $group)
      {
          $this->model = $group;
      }
/**
 *
 *  create new group
 *  
 *  TODO:
 *  - check progress group
 *  - assing User
 *  - assign item
 *  - set Group Info
 *  - set Image
 *  - set Premium
 *         // dd($request['price'.$request['model_id']]);
*          // preg_replace('/[^a-zA-Z]/', '', $request);
 *
 */
   public function storeGroup($group = null)
      {
          $data = $this->request;

          DB::beginTransaction();
       
          try {
              $group = isset($group) 
                  ? $this->CheckProgress($group) 
                  : DB::table('groups')->insert();

              isset($group) ?: $this->addModel($group,'user',\Auth::user()); // change to assign_User($group,$user)
              isset($group) ?: $this->assign_Item($group,$data);
              
              $this->set_Basic_Info($group, $data);
              $this->set_Image($group, $data);
              $this->set_Premium($group,$data);
              $group->push();
              return 'Group for ' . $group->item->title .' successfully has been'. isset($group) ? 'updated' : 'stored';
          } catch(ValidationException $e)
          {
              DB::rollback();
              return redirect()
                    ->back()
                    ->withErrors( $e->getErrors() )//'error' => $e->getMessage()
                    ->withInput();
          } catch(\Exception $e)
          {
              DB::rollback();
              throw $e;
          } catch( Exception $e)
          {
            return 'You can not update group if user already join';
          }
          DB::commit();
      }    
/**
 *
 *  create new room
 *  
 *  TODO:
 *  - check room complete
 *  - assign type_tag
 *  - assign style_tag
 *  - assign work_tag
 *  - set Room Info
 *
 */
   public function GroupChange($user)
      {     

        //add method checkUserCount()
        //add $method = $user is instanceof User ? 'save' : 'saveMany';
        //add $this->users()->$method($user);

        if(!$this->model->checkJoin($user)){
          $this->addModel($user,'join_groups',$this->model);
          $message = 'You have been successfully joined to group';
        }
        else{
          $this->removeModel($user,'join_groups',$this->model);
          $message = 'You have been successfully withdrown from group';
        }
      
        $this->CheckProgress($this->model);

        $this->saveModel($this->model);
        $this->saveModel($user);
       
        return $message;
      } 
/**
 *
 *  create new room
 *  
 *  TODO:
 *  - check room complete
 *  - assign type_tag
 *  - assign style_tag
 *  - assign work_tag
 *  - set Room Info
 *
 */
   private function CheckProgress()
      {
        $progress = ($this->model->user_count / $this->model->user_need) * 100;
        $this->model->progress = $progress;
        return $this->model;

        if($this->model->user_count == $this->model->user_need){   
           $this->model->complete = Carbon::now(); 
         } 

                 if($this->model->user_count == $this->model->user_need)
          {
            return $this->model->complete = 'true';
            //flash message to all members
            //flash message to shop
            //send all members email contact of shop
            //send shop contact of all members
          }
          return $this->model;
      }
/**
 *
 *  set Info
 *  
 *  TODO:
 *
 */
   private function set_Group_Info()
      {
            switch (\Auth::user()->type) {
              case 'owner':$type = 'remont';
                break;   
              case 'profi':$type = 'project';
                break;   
              case 'shop': $type = 'purchase';
                break;
            }
            $this->model->type = $type;
            $this->model->price     = e($request['price']) ?: null;  
            $this->model->user_need = e($request['user_need']) ?: null; 
            $this->model->expires   = date("Y-m-d",strtotime($request['expires'])) ?: null; 

            return ;
      }
/**
 *
 *  set Info
 *  
 *  TODO:
 *
 */
   private function assign_Item($data)
      {
        if($this->model->complete == false && $this->model->active == false)
          {
            if($request->has('item'))
                {
                  $item = Item::find($request['item']);
                  $this->addModel($this->model,'item',$item);
                }

          if($request->has('item'))
              {
                $item = Item::find($data('item'));
                $element = Element::find($item->element_id);
                $this->decrementModel($item,'element',$element);
              }   
          }
     return ; 
    }
/**
 *
 *  set Image for item
 *  
 *  TODO:
 *  - remove image is exist
 *
 */
  private function set_Premium($item,$data){
            //if user->role = premium
      if($request->has('premium'))
        {
          $group->premium  = e($request['premium']); 
        }
      return ;
  }
}   