<?php namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
	public function authorize()
	{
	    return true;
	}

	public function rules()
	{
	    return [  
		    'email'                 => 'required|email',// .\Auth::user()->id
		    'password'              => 'required|alpha_num|between:2,20',
		];
	}
}
