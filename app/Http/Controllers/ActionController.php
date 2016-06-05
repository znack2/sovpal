<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Mailer\Mailer;
use Illuminate\Http\Request;
use \App\Models\_partials\Address;

/*********************************************************************

                Action

**********************************************************************/

class ActionController extends Controller
{
	public $mail;

	public function __construct(Mailer $mail)
    {
		$this->mail = $mail;

		// Mail::send('emails.whitepaper', [], function ($m) {
		//     $m->to('barasa@wangusi.ke');
		//     $m->subject('Your whitepaper download');
		//     $m->attach(storage_path('pdfs/whitepaper.pdf'));
		// });
    }
/**
 *
 *  search users by address in landing 
 *  
 *  TODO:
 *  - put logic in Repo
 *	- 
 *	- AJAX
 *
 */
	public function searchUsers(Request $request)
		{
            logger()->info(__METHOD__);
            $data = $request->all();
			$response['message'] = 'You are first!';
			$response['image']   = asset('assets/images/users/default.png');
			$response['name']    = 'Here should be your name!';
			
			$address = Address::where('street',$data['street'])->where('house',$data['house'])->first();

			if($address && $address->user_count != 0)
				{
					 foreach($address->users as $user)
					 	{
					 		$response['name']    = $user->getFullName();
					 		$response['image']   = asset('assets/images/users/'.$user->getImage('avatar'));
					 	}
						 	$response['message'] =  trans( 'sovpal.We have found' )
						 							.$address->user_count 
						 							.trans('sovpal.people around you,please registr to use webservice');
				}
       	 	return $this->getView();
		}
/**
 *
 *  banner if search is empty
 *  
 *  TODO:
 *  - send Mail
 *	- AJAX
 *
 */
	public function empty_index(Request $request)
	    {
            logger()->info(__METHOD__);
            $subject = 'Send message if find something';

	        // event( new mailEvent($this->currentUser));
	        // $this->mail->send('layout.emails.subscribe',$this->currentUser,$subject);
			// 'Note will be send right after we get proper result for your request!'
	        return $this->getView();
	    } 
/**
 *
 *  banner if user profile empty
 *  
 *  TODO:
 *  - send Mail
 *	- AJAX
 *
 */ 		
    public function empty_profile(Request $request)
	    {
            logger()->info(__METHOD__);
            $subject = 'Send message if find something';

	        // event( new mailEvent($this->currentUser));
	        // $this->mail->send('layout.emails.subscribe',$this->currentUser,$subject);

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
    public function premium(Request $request)
        {
            logger()->info(__METHOD__);
            
        }  
/**
 *
 *  contact form 
 *  storeRoom in room Repo
 *  
 *  TODO:
 *  - contact Request
 *	- check Mail
 *
 */
    public function contact(Request $request)
        {
            logger()->info(__METHOD__);
            $this->validate($request, [
               'name'     	=> 'required|min:3',
               'email' 		=> 'required|email|max:255',
               'message'    => 'required'
           ]);

           $requestData  = $request->only('name','email','message');
           $this->mail->sendMail($requestData['name'],$requestData['email'],$requestData['message']);
           
           return $this->getView();
        }  
/**
 *
 *  select Category and Element
 *  
 *  TODO:
 * 	- why use it ???
 *  - AJAX
 *
 */
    public function selectCategory_Element(Request $request)
	    {
            logger()->info(__METHOD__);
	        //  $elements = DB::table('elements')->whereHas('categories',function( $query ) use ($request){
	        //     $query->where('id',$request->input('category_id'))->orderBy('name')->lists('name','id')
	        // });
	        // return Response::make($elements);
	        // return Response::json($elements);
	    }
}


