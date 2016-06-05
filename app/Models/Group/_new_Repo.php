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
   public function __construct(Group $group)
      {
          $this->model = $group;
      }
/**
 *
 *  create new group
 *  
 *
 */
   public function storeGroup()
      {
          $data = $this->request;

          DB::beginTransaction();
       
          try {
              $method = isset($this->model) ? 'updated' : 'stored'
              isset($this->model) ? DB::table('groups')->create() : null;

              $this->assign_User($user);
              $this->assign_Item($data);
              $this->set_Info($data);
              $this->set_Image($data);

              return 'Group for ' . $this->model->item->title .' successfully has been'. $method;
          } catch(ValidationException $e)
          {
              DB::rollback();
              return redirect()
                    ->back()
                    ->withErrors( $e->getErrors())//'error' => $e->getMessage()
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
 *  join group
 *  
 *
 */
 public function JoinGroup($user)
      {     
        if($this->CheckProgress()){
            $user is instanceof User ? 'save' : 'saveMany';
            $this->users()->$method($user);
        }
        return $this->message = 'You have been successfully joined to group';
      }  
/**
 *
 *  withdrow from group
 *  
 *
 */
  public function WithdrowFromGroup($user)
      {     
        $user->groups()->where('group_id',$this->model->id)->update(['group_id'=>null]);
        return $this->message = 'You have been successfully withdrown to group';
      } 
/**
 *
 *  withdrow from group
 *  
 *
 */
  public function RestartGroup()
      {     
        //remove group_id from pivot table
        $this->users()->update(['group_id'=>null]);
        return $this->message = 'You have been successfully withdrown to group';
      }
/**
 *
 *
 *  check progress
 *
 *
 */
  public function RemoveManyUsers($users)
      {
           return $this->users()
                       ->whereIn('id', $users->pluck('id'))
                       ->update(['team_id'=>null]);
      } 
/**
 *
 *
 *  check progress
 *
 *
 */
    private function CheckGroupSize()
      {
          if(){
            throw new \Exception;
          }
      }
/**
 *
 *
 *  check progress
 *
 *
 */
    private function CheckProgress()
      {
        $progress = ($this->model->user_count / $this->model->user_need) * 100;
           $this->model->progress = $progress;
           $this->model->save();

        if($this->model->user_count == $this->model->user_need){   
           $this->model->complete = Carbon::now(); 
           $this->model->save();

            //flash message to all members
            //flash message to shop
            //send all members email contact of shop
            //send shop contact of all members
           return false;
         }
        return true;
      }
/**
 *
 *  set Info
 *
 *
 */
   private function set_Info()
      {
            switch (\Auth::user()->type) {
              case 'owner': $type = 'remont';
                break;   
              case 'profi': $type = 'project';
                break;   
              case 'shop' : $type = 'purchase';
                break;
            }
            $this->model->type = $type;
            $this->model->price     = e($request['price']) ?: null;  
            $this->model->user_need = e($request['user_need']) ?: null; 
            $this->model->expires   = date("Y-m-d",strtotime($request['expires'])) ?: null;
            $this->model->premium = $this->request->has('premium'); 
            return $this->model->push();
      }
/**
 *
 *  set User
 *
 */
   private function assign_User($user)
      {
        return $this->model->user()->save($user);
      }
/**
 *
 *  set Item
 *
 *
 */
   private function assign_Item($data)
      {
          $item = Item::find($this->request['item']);
          return $this->addModel($this->model,'item',$item);
      }
}     

