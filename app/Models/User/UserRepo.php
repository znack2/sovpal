<?php namespace App\Models\User;

use App\Models\User\User;

use App\Models\User\UserInterface;
use App\Models\Filters\AbstractRepo;
use Session;

/*********************************************************************

                ( User / Owner Professional Shop )

**********************************************************************/

class UserRepo  extends AbstractRepo implements UserInterface
{
    public function __construct(User $user)
        {
            $this->model = $user;
        }
/**
 *
 *  create new User 
 *  
 *  TODO:
 *  - firstOrNew
 *  - set Plan ($customer = $bullable->createCustomer('token');)
 *  - check return $user to registration? 
 *
 */
    public function createUser($user = null)
        {
          $data = $this->filters;

          DB::beginTransaction();
          $user = User::where('id', $id)->update(['name', $request->name]);

          try {
              $user = isset($user) ? $user :  $this->set_Basic_Info($data,\Session::get('provider'));
              $this->set_Extra_Info($user, $data);
              $this->set_Image($user, $data);
              // $this->set_Plan($user,$data);
              $user->assing_Address($data);
              $user->push();
              return 'Your profile information successfully has been'. isset($user) ? 'updated' : 'stored';
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
          }
          DB::commit();
        }
/**
 *
 *  Activate user by code
 *  
 *  TODO:
 *  - check exception redirect with input with errors
 *
 */
    public function activateUser($code){
        $user               = $this->model->where('activation_code', $code)->firstOrFail();
        $user->activated_at = Carbon::now();
        $user->active       = true;
        $user->token        = null;
        return $user->save();
    }
/**
 *
 *  check currentUser banned or active
 *  
 *  TODO:
 *  - create Exception
 *
 */
    public function checkBanned(){
        if(Auth::user()->banned) {
            throw new UserBannedException;
        }
        return false;
    }
/**
 *
 *  Update when user last_login
 *  
 *  TODO:
 *  - check if session is working
 *
 */
    public function update_last_login(){
        $user = Auth::user();
        $user->last_login = Carbon::now();
        $user->save();
        Session::put('currentUser',$user);
        return true;
    }
/**
 *
 *  set Basic Info for user
 *  
 *  TODO:
 *  - check if provider really give data
 *
 */
    private function set_Basic_Info($data,$provider = null){
          $user = DB::table('users')->insert([]);
          $user->activation_code = str_random(60);
          $user->password        = bcrypt($data['password']);
          $user->type            = e($data['type']);
          $user->first_name      = $provider->getName()  ?: e($data['first_name']);
          $user->email           = $provider->getEmail() ?: e($data['email']);
          $user->provider        = $provider ?: null;
          $user->provider_id     = $provider->getId() ?: null;
          return $user;
    }
/**                  
 *
 *  set Extra Info for user
 *  
 *
 */
    private function Set_Extra_Info($user,$data){
           $user->language        = \Session::has('locale') ? \Session::get('locale') : 'ru';
           $user->last_name       = $data['type'] != 'shop' ? e($data['last_name']) : null;
           $user->gender          = $data['type'] != 'shop' ? e($data['gender']) : null;
           $user->birthday        = $data['type'] != 'shop' ? date("Y-m-d",strtotime($data['birthday'])) : null;
           $user->hour_cost       = $data['type'] == 'profi' ? e($data['hour_cost']) : null;
           $user->own_remont      = $user->type == 'owner' ? e($data['own_remont']) : null; 
           $user->with_designer   = $user->type == 'owner' ? e($data['with_designer']) : null; 
           $user->education       = $user->type == 'profi' ? e($data['education']) : null; 
           $user->refund_policy   = $user->type == 'shop' ? e($data['refund_policy']) : null; 
           $user->delivery_policy = $user->type == 'shop' ? e($data['delivery_policy']) : null; 
           $user->phone_code      = substr($data['phone'], 0, 3);
           $user->phone           = substr($data['phone'], 3);
           $this->set_SKills($user,$data);
           return $user;
    }
/**
 *
 *  set Image for User
 *  
 *  TODO:
 *  - remove image is exist
 *
 */
    private function set_Image($user,$data){
        if($data->hasFile('avatar_image') && $data->file('profile_picture')->isValid()) {
          $this->removeImage($user,'avatar');
          $this->saveImage('users',$user->type,$data->file('avatar_image'));
          $this->addImage($user,$data->file('avatar_image'),'avatar','avatar_for_'.$user->first_name);
        }
        return $user;
    }
/**
 *
 *  set Skills
 *  
 *  TODO:
 *  - check if tags exist remove them
 *
 */
    private function set_Skills($user,$data){
          if($user->type == 'profi' && $data('skills') && $user->tags()->where('type','skill')->first()) {
             $tags = $user->tags()->where('type','skill')->get();
             //remove all old tags
               foreach ($tags as $tag) {
                  $this->removeModel($user,'tags',$tag);
               }
          } 
          $this->addTag($user,$data);
          return $user; 
    }
}



