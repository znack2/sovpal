<?php namespace App\Http\Controllers;
//request
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
//output
use App\Http\Controllers\Controller;
//repo
use App\Models\User\UserInterface;
use App\Models\User\User;
use Storage;
use Illuminate\Support\Facades\Cache;

/*********************************************************************

                             User 

**********************************************************************/

class UserController extends Controller
{

	public function __construct(UserInterface $user)
		{	
			$this->model = $user;
		}
/**
 *
 *  index all users
 *  filter method inside abstract Repository
 *  
 *
 */
  public function index()
    {
        // $user = (new User)->newQuery();

        // if($request->exists('popular')){
        //   $user->orderBy('views','desc');
        // }

        // if($request->exists('difficulty')){
        //   $user->orderBy('difficulty',$request->difficulty);
        // }

        // return $user->get();
  
      logger()->info(__METHOD__);
      $data['items'] = $this->model->Filter();
      return $this->getView('index/main',$data);
    }
/**
 *
 *  show user profile
 *  section = profile menu (settings/items/groups/rooms)
 *  
 *  TODO:
 *  - filter query
 *  - Cache
 *  - check if Auth::id == $user->id for all
 * 
 *
 */
	public function profile(Request $request,User $user)
   {
    logger()->info(__METHOD__);
      if(is_null($user)) {abort('404'); }
      $section = $request->input('section', 'settings');
      $type = strtolower(substr($request->input('type'),0,-1));

      if($section == 'items' && $user->id == \Auth::id()){
            $user['items'] = Cache::remember('my'.$type, 24*60, function() use ($user,$type) {
                $related = $user->type == 'shop' ? 'items' : 'orders';
                return $user->$related()->where('type',$type)->get();
            });
        }
      elseif($section == 'rooms' && $user->id == \Auth::id()){
            $user['rooms'] = Cache::remember('myRooms', 24*60, function() {
                return $this->model->rooms()->get();
            });
        }
      elseif($section == 'groups' && $user->id == \Auth::id()){
          $user->type == 'shop' ? $user->Groups() : $user->join_groups();
        }
      elseif($section == 'settings'){
          
        }
      else{
          abort('404');
        }
     return $this->getView('profile/'.$section,$user);
   }
/**
 *
 *  update profile
 *  updateUser method in User Repo
 *
 *  TODO:
 *  - use AJAX
 *
 */
  public function update(UserRequest $request,User $user)
    {
        logger()->info(__METHOD__);
        $this->model->updateUser($user);
        return $this->getView();
    }
}   