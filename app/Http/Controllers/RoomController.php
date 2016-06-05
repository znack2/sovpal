<?php namespace App\Http\Controllers;

//request
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
//output
use App\Http\Controllers\Controller;
//repo
use App\Models\Room\RoomInterface;
use App\Models\Room\Room;
use App\Models\User\User;
use App\Models\_partials\Element;

/*********************************************************************

                room --- ( Index - STORE - UPDATE - DELETE  ) 

**********************************************************************/


class RoomController extends Controller
{
	public function __construct( RoomInterface $room)
	    {
	        $this->model = $room;
	    }
      
/**

  TODO:
  - index method

 */
  public function index()
    {
        logger()->info(__METHOD__);
        $data['items'] = $this->model->Filter();
        return $this->getView('index/main',$data);
    }
/**
 *
 *  store Room
 *  storeRoom in room Repo
 *  ? inject Room $room ?
 *
 */
  public function store(RoomRequest $request)
        {
          logger()->info(__METHOD__);
          $this->model->storeRoom();
          return $this->getView();
        }
/**
 *
 *  update room
 *  storeRoom in room Repo
 *  
 *  TODO:
 *  - remove User $user ?
 *
 */
	public function update(RoomRequest $request,User $user,Room $room)       
  	   {   
          logger()->info(__METHOD__);
          $this->model->storeRoom($room);
          return $this->getView();     
  	   }
/**
 *
 *  remove Room
 *  deleteModel in incrementTrait
 *  
 *  TODO:
 *  - remove User $user ?
 *
 */
  public function destroy(Request $request,User $user,Room $room)         
       {
          logger()->info(__METHOD__);
          $this->model->deleteModel($room);
          return $this->getView();
       } 
/**
 *
 *  add element into room
 *  section = profile menu (settings/items/groups/rooms)
 *  
 *  TODO:
 *  - remove User $user ?
 *  - in view add room_id to form url
 *  - in view add element_id to form url
 * 
 *
 */
  public function AddElement(Request $request,User $user,Room $room,Element $element)        
      {
         logger()->info(__METHOD__);
         $this->model->addModel($room,'elements',$element);
         return $this->getView();
      }  
/**
 *
 *  remove ELement
 *  removeModel in incrementTrait
 *  
 *  TODO:
 *  - remove User $user ?
 *
 */
  public function RemoveElement(Request $request,User $user,Room $room,Element $element)      
     {
        logger()->info(__METHOD__);
        $this->model->removeModel($room,'elements',$element);
        return $this->getView();
     }  
}   

