<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_type;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuperadminController extends Controller
{
    public function index($language)
    {
    	return view('admin.index', compact('language'));
    }

    public function users($language)
    {
    	$users = User::where('user_type_id', '!=', 1)->paginate(10);
    	return view('admin.user.index', compact('users', 'language'));
    }

    public function users_create($language)
    {
    	$user_types = User_type::where('id', "!=", 1)->where('id', "!=", 5)->get();
    	return view('admin.user.create', compact('user_types', 'language'));
    }

    public function users_store(Request $request, $language)
	{
	    $request->validate([
	      'user_type_id' => 'required',
	      'name'=>'required',
	      'email'=>'required|email|unique:users',
	      'password'=>'required|confirmed',
	    ]);

	    $user = User::create([
	      'name' => $request->name,
	      'email' => $request->email,
	      'password' => bcrypt($request->password),
	      'user_type_id' => $request->user_type_id,
	      'status_id' => 1
	    ]);

	    return redirect()->route('users', app()->getLocale());
	}

	public function users_edit($language, $id)
    {
    	$user = User::find($id);
    	$user_types = User_type::get();
    	return view('admin.user.edit', compact('user', 'user_types', 'language'));
    }

    public function users_update(Request $request, $language)
	{
	    $request->validate([
	      'user_type_id' => 'required',
	      'name'=>'required',
	      'email'=>'required|email',
	      'password'=>'required|confirmed',
	    ]);
	    $user = User::find($request->user);
        // dd($user);
	    $user->update([
	      'name' => $request->name,
	      'email' => $request->email,
	      'password' => bcrypt($request->password),
	      'user_type_id' => $request->user_type_id,
	    ]);

	    return redirect()->route('users', app()->getLocale());
	}

	public function apply(Request $request, $language)
    {
    	$users = User::find($request->user);
    	
    	DB::table('users')
        ->where('id', $users->id)
        ->update([
        	'status_id' => 1,
      	]);
        return redirect()->route('users', app()->getLocale());
    }

    public function delete(Request $request, $language)
    {
        $users = User::find($request->user);
        
        DB::table('users')
        ->where('id', $users->id)
        ->update([
        	'status_id' => 4,
        ]);
        return redirect()->route('users', app()->getLocale());
    }

    public function block(Request $request, $language)
    {
        $users = User::find($request->user);
        
        DB::table('users')
        ->where('id', $users->id)
        ->update([
        	'status_id' => 3,
        ]);
        return redirect()->route('users', app()->getLocale());
    }

    public function profile($language, $id)
    {
        $user = User::find($id);
        return view('admin.profile', compact('user', 'language'));
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
            return redirect()->route('admin', app()->getLocale());
        } else{
            return redirect()->route('admin.profile', ['language'=>app()->getLocale(), 'user'=>auth()->user()->id]);
        }        
    }
}
