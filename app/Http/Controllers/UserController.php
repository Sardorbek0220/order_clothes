<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function register()
    // {
    // 	return view('register');
    // }

    public function login($language)
    {
    	return view('login', compact('language'));
    }

    public function login_store(Request $request, $language)
	{
		$request->validate([
		  'email'=>'required|email',
		  'password'=>'required',
		]);

		// dd(func_get_args());

		if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
			
			if(Auth::user()->user_type_id==1 && Auth::user()->status_id==1){
			    return redirect()->route('admin', app()->getLocale());
			}else if (Auth::user()->user_type_id==2 && Auth::user()->status_id==1) {
				return redirect()->route('order_moderator', app()->getLocale());
			}else if (Auth::user()->user_type_id==3 && Auth::user()->status_id==1) {
				return redirect()->route('accountant', app()->getLocale());
			}else if (Auth::user()->user_type_id==4 && Auth::user()->status_id==1) {
				return redirect()->route('courier', app()->getLocale());
			}else if (Auth::user()->user_type_id==6 && Auth::user()->status_id==1) {
				return redirect()->route('admin2', app()->getLocale());
			}else{
				return redirect()->route('logout', app()->getLocale());
			}

		}else{

		  	return redirect()->route('logout', app()->getLocale());

		}
	}

	public function logout()
  	{
	    Auth::logout();
	    return redirect()->route('login', app()->getLocale());
  	}

}
