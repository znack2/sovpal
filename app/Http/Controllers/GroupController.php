<?php namespace App\Http\Controllers;

//request
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
//output
use App\Http\Controllers\Controller;
//repo
use App\Models\Group\GroupInterface;
use App\Models\Group\Group;
//exception
// use App\Exceptions\NoActiveFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/*********************************************************************

                Group --- ( Index/show - STORE - UPDATE - DELETE  ) 

**********************************************************************/

class GroupController extends Controller
{
	public function __construct(GroupInterface $group)
	    {
	        $this->model = $group;
	    }
	/**
 *
 *  index group
 *
 */
  public function index()
    {
        logger()->info(__METHOD__);
        $data['items'] = $this->model->Filter();
        return $this->getView('index/main',$data);
    }
/**
 *
 *  show group
 *
 */
  public function show(Request $request,Group $group)
    {  
        logger()->info(__METHOD__);
        if(is_null($group)) {abort('404'); }
        $group['items'] = $group->getMembers();
        return $this->getView('one/main',$group);
    } 
/**
 *
 *  store group
 *
 */
  public function store(GroupRequest $request)
     {
        logger()->info(__METHOD__);
        $this->model->storeGroup();
        return $this->getView();
     }
/**
 *
 *  update group
 *  
 *  TODO:
 *  - use AJAX
 *
 */
  public function update(GroupRequest $request,Group $group)       
    {    
        logger()->info(__METHOD__);
        $this->model->storeGroup($group);
        return $this->getView();     
    }
/**
 *
 *  destroy group
 *  deleteModel in incrementTrait
 *  
 *  TODO:
 *  - use AJAX
 * 
 */
  public function destroy(Request $request,Group $group)      
    {
        logger()->info(__METHOD__);
        $this->model->deleteModel($group);
        return $this->getView();
    }  
/**
 *
 *  join or withdrow group
 *  
 *  TODO:
 *  - use AJAX
 *
 */
  public function joinGroup(Request $request,Group $group)
    {
      logger()->info(__METHOD__);   
      $group->JoinGroup(Auth::user());
      return $this->getView();
    }
/**
 *
 *  join or withdrow group
 *  
 *  TODO:
 *  - use AJAX
 *
 */
  public function WithdrowGroup(Request $request,Group $group)
    {
      logger()->info(__METHOD__);   
      $group->WithdrowFromGroup(Auth::user());
      return $this->getView();
    }
}   

