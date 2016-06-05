<?php namespace App\Http\Controllers;

//request
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
//output
use App\Http\Controllers\Controller;
//repo
use App\Models\Item\ItemInterface;
use App\Models\Item\Item;
use App\Models\Room\Room;
use App\Models\User\User;
use Illuminate\Support\Facades\Cache;

/*********************************************************************

                item --- ( index/show - STORE - UPDATE - DELETE ) 

**********************************************************************/

class ItemController extends Controller
{
	public function __construct(ItemInterface $item)
	    {
	        $this->model = $item;
	    }
/**
 *
 *  index Items
 *  Filter in Abstract Repo
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
 *  show item
 *  get groups from $item->groups
 *
 */
  public function show(Request $request,Item $item)
    { 
      logger()->info(__METHOD__);
       if(is_null($item)) {abort('404'); }
       $item['items'] = $item->groups();
       return $this->getView('one/main',$item);
    } 
/**
 *
 *  store item
 *  
 *  TODO:
 *  - inject Room $room ( shop can add item in catalogs / owner dont need it ? )
 *  - use AJAX
 */
  public function store(ItemRequest $request)
    {
      logger()->info(__METHOD__);
      $this->model->storeItem();
      return $this->getView();
    }
/**
 *
 *  update item
 *  storeItem in item Repo
 *  
 *  TODO:
 *  - use AJAX
 */
  public function update(ItemRequest $request,Item $item)    
   {   
      logger()->info(__METHOD__);
      $this->model->storeItem($item);
      return $this->getView();  
   }
/**
 *
 *  destroy item ( for shops or if item->type == tool/mat )
 *  deleteModel in incrementTrait
 *  
 *  TODO:
 *  - fix destroy form url in view ( owner removes item by addOrRemove method )
 *  - use AJAX
 */
  public function destroy(Request $request,Item $item)        
     {
      logger()->info(__METHOD__);
      $this->model->deleteModel($item);
      return $this->getView();
     }    
/**
 *
 *  add or remove item ( for owners )
 *  removeModel and addMOdel in incrementTrait
 *  
 *  TODO:
 *  - check user_id = item->id in repo
 *  - owner add item in room ( inject Room $room )
 *  - use AJAX
 */
  public function add(Request $request,Item $item)
    {
      logger()->info(__METHOD__);
      $this->model->addModel(\Auth::user(),'orders',$item);
      return $this->getView();
    }
/**
 *
 *  add or remove item ( for owners )
 *  removeModel and addMOdel in incrementTrait
 *  
 *  TODO:
 *  - check user_id = item->id in repo
 *  - owner add item in room ( inject Room $room )
 *  - use AJAX
 */
  public function Remove(Request $request,Item $item)
    {
        logger()->info(__METHOD__);
        $item->checkAdd(\Auth::user();
        $this->model->removeModel(\Auth::user(),'orders',$item);
        return $this->getView();
    }
}
