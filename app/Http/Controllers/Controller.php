<?php namespace App\Http\Controllers;

use View;
use App;
use Auth;
use Config;
use Session;
use Log;
use Event;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User\UserInterface;
use App\Models\_partials\Tag;

//use App\Events\ItemSeeEvent;
//use App\Events\GroupSeeEvent;
//use App\Events\ProfileSeeEvent;
//use App\Events\UserEvent;

/*********************************************************************

                          Controller

**********************************************************************/

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $paginate;
    public $model;
    public $currentUser;
    public $meta;
    public $mail;

    public function __call($method, $parameters)
        {
            abort('404');
            // return \Response::error('404');
        }
    public function __construct()
        {
              // Cookie::queue('saw-dashboard', true, 15);
            $this->paginate = \Config::get('sovpal::pagination');
            $this->currentUser = \Auth::user();//!is_null(Session::get('currentUser')) ? Session::get('currentUser') : Auth::user();
            // $this->debug();
        }
/**
 *
 *  show view
 *
 *  $path
 *  $data
 *  $data['items']
 *  $data->type
 *  
 *  TODO:
 *  - use meta as service
 *  - check if page/landing/form
 *
 */
    public function getView($path, $data = null)
        {
          logger()->info(__METHOD__);
          $meta  = $this->getMeta($path,$data);

          // if( ! preg_match('/[^a-z\-_]+/', $path)) {return 'wrong url'; }
          // elseif( ! view()->exists($path)) {return 'wrong path view'; }

          //check if landing
          //if page
          //if output
          //if form
          // if ($response instanceof IlluminateSupportMessageBag){
          //       return Response::json($response, 400); 
          //     }
          if (\Request::wantsJson()) {
                // return response()->json(['msg' => $message]); 
              } 
          elseif($path == 'landing' && \Auth::user()){
                redirect()->route('groups');
              }
          elseif($path == 'pages._form'){
                return view($path,compact($data,'meta'));
              }
          else{
                // flash($message,'success');
                return back();
                return view($path, compact('data','meta')); // add page var?
          }    
        }
/**
 *
 *  show static page 
 *
 */
    public function getPage(Request $request)
      {
        $this->getView('pages.'.$request->route('page'));
      }
/**
 *
 *  meta for all pages
 *  
 *  TODO:
 *  - check path
 *  - create list of keywords
 *  - turn this method into service
 */
    public function getMeta($path,$data)
        {
            logger()->info(__METHOD__);

            if($path = 'index/index'){
                $meta['title']       = $data['type'];
                $meta['description'] = 'based on '.$data['type'];
                $meta['keywords']    = 'sort by category economy words';
            }
            elseif($path = 'one/one' && in_array($data['type'], ['items','tools','materials'])){
                $meta['title']       = $data->title;
                $meta['description'] = $data['type'].$data['description'];
                $meta['keywords']    = 'sort by category economy words';
            }
            elseif($path = 'one/one' && $data['type'] == 'group'){
                $meta['title']       = 'group'.$data->item->title;
                $meta['description'] = 'words about economy and specific for this item';
                $meta['keywords']    = 'economy keywords';
            }
            elseif($path = 'profile/*'){
                $meta['title']       = $data->first_name.$data->last_name;
                $meta['description'] = $data['type'];
                $meta['keywords']    = 'user type keywords';
            }
            else{
                $meta['title']       = 'page title';
                $meta['description'] = 'page description';
                $meta['keywords']    = 'page keywords';
            }
            return $meta;
          }
}
