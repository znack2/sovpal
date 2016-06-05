<?php namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use Validator;
use Session;
use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ActivateRequest;
use App\Http\Requests\Auth\RegistrationRequest;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public $model;
    protected $loginPath = '/'; 
    protected $redirectPath = '/';
    protected $loginBy = strpos($login, '@') > 1 ? 'email' : 'username';

    public function __construct(User $user){
        $this->model  = $user;
    }
/**
 *
 *  Registration form 
 *  
 *  TODO:
 *  - oauth show just extra input 
 *
 */
    public function Register()
        {
            $provider = Session::has('provider');

            $form  = [
                'title'   => $provider != null ? 'Add little bit more info about yourself' : 'Feel yourself like at home !',
                'model'   => 'auth',
                'method'  => 'register',
                'button'  => 'Complete',
                'type'    => '',
                'provider'=> $provider
            ];

            return $this->getView('pages._form',$form);
        }
/**
 *
 *  Confiramation form 
 *
 */
    public function getConfirmation()
        {
            $form  = [
                'title'  => 'Confirmation Code',
                'model'  => 'auth',
                'method' => 'code',
                'button' => 'confirm',
                'type'   => 'panel',
            ];
             return $this->getView('pages._form',$form);
        }
/**
 *
 *  login User
 *  
 *  TODO:
 *  - flash
 *  - login by email or name
 *  - update_last_login method in User Repo
 *  - checkBanned in User Repo
 *  
 */
    public function postLogin(LoginRequest $request)
      {
        $email    = $request->input('email');
        $password = $request->input('password');

        $loginBy = strpos($email, '@') > 1 ? 'email' : 'username';
        $validate = Auth::attempt([$loginBy => $email, 'password' => $password],$request->has('remember'));

      // check if user not verified show message if yes login


        if($validate === true) {
            $this->model->checkBanned();
            $this->model->update_last_login();
            flash(trans('sovpal.flash.Login'),'success');
            return redirect()
                  ->intended($this->redirectPath());
        }

            flash(trans('sovpal.flash.LoginError'),'error');
            return redirect($this->loginPath())
                  ->withInput($request->only('email', 'remember'))
                  ->withErrors(['email' => $this->getFailedLoginMessage()]);
      }
/**
 *
 *  create new User
 *  createUser in User Repo
 *
 */
    public function postRegistr(RegistrationRequest $request)
      {
          $this->model->createUser($request->all());
              // send email verification
              // show message( go to email to verify )
          flash(trans('sovpal.flash.Registration'),'success');
          return redirect($this->redirectPath());
      }
/**
 *
 *  confirmation 
 *  activateUser in User Repo
 *  link in email
 *  check verify code if expire or not valid show error( send mail again )
 *  if ok show success
 */
    public function postConfirmation(Request $request)
      {


          $this->model->activateUser($request->input('code'));
          flash(trans('sovpal.flash.Confirm'),'success');
          return redirect()->route('groups');
      }
/**
 *
 *  Logout 
 *
 */
    public function Logout()
      {
        Auth::logout();
        //          flash(trans('sovpal.flash.Logout'),'success');
        return redirect('/')->with('alert', 'You are logged out.');
      }
}
