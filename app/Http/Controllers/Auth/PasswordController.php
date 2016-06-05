<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Requests\Auth\PasswordRemindRequest;
use App\Models\User\User;
use Hash;

// NotFoundHttpException
class PasswordController extends Controller
{
    use ResetsPasswords;

    public $redirectPath = '/';

    public function __construct()
        {
            $this->middleware('guest');
        }
/**
 *
 *  Email form 
 *
 */
    public function getEmail()
        {
            $form  = [
                'title'  => 'Send Request for Reset Password',
                'model'  => 'auth',
                'method' => 'password',
                'button' => 'send password link',
                'type'   => 'panel',
            ];

             return $this->getView('pages._form',$form);
        }
/**
 *
 *  Reset form 
 *
 */
    public function getReset($token = null)
        {
            //display message you got new password
            //send to email password and login
            if (is_null($token)) {throw new NotFoundHttpException; }

            $form  = [
                'title'  => 'Reset Password',
                'model'  => 'auth',
                'method' => 'reset',
                'button' => 'reset',
                'type'   => 'panel',
                'tiken'  => $token
            ];

             return $this->getView('pages._form',$form);
        }
/**
 *
 *  Remind form 
 *
 */
    public function getRemind()
        {
            $form  = [
                'title'  => 'Remind Password',
                'model'  => 'auth',
                'method' => 'remind',
                'button' => 'remind',
                'type'   => 'panel',
            ];

            return $this->getView('pages._form',$form);
        }
/**
 *
 *  Password remind
 *  
 *  TODO:
 *  - oauth show just extra input 
 *
 */
    public function postRemind(PasswordRemindRequest $request)
        {
            $question = $request->get('question');
            $answer   = $request->get('answer');

            $user = User::where('email', $request->get('email'))->first();

            if($user->question === $question && Hash::check($answer,$user->answer))
            {
                $user->password = bcrypt($request->get('password'));
                $user->save();
                return redirect('auth/login')
                ->with(['success' => 'The password was changed']);
            }
            return redirect('auth/recover-password')
                ->withInput($request->only('email', 'question'))
                ->withErrors('The answer or the question doesn\'t match');
        }
/**
 *
 *  Change password 
 *  
 *  TODO:
 *  - oauth show just extra input 
 *
 */
    public function changePassword(Request $request)
        {
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ]);
            $user = User::where('email', $request->get('email'))->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()
                ->back()
                ->with('info', 'Password successfully updated');
        }
}
