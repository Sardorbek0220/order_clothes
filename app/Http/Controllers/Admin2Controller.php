<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Admin2Controller extends Controller
{
    public function index($language)
    {
    	return view('admin2.index', compact('language'));
    }

    public function profile($language, $id)
    {
        $user = User::find($id);
        return view('admin2.profile', compact('user', 'language'));
    }

    public function profile_save(Request $request, $language, $id)
    {
        $user = User::find(Auth::id());
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|confirmed',
        ]);

        if(Auth::attempt([
          'email'=>$user->email,
          'password'=>$request->password_now,
        ])) {
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return redirect()->route('admin2', app()->getLocale());
        } else{
            return redirect()->route('admin2.profile', ['language'=>app()->getLocale(), 'user'=>auth()->user()->id]);
        }        
    }
}
