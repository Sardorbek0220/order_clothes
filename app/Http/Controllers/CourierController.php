<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Order_progress;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourierController extends Controller
{
    public function index($language)
    {
    	return view('courier.index', compact('language'));
    }

    public function points($language)
    {
    	$orders = Order::where('order_status_id', 4)->orWhere('updated_by', auth()->user()->id)->get();
    	return view('courier.points', compact('orders', 'language'));
    }

    public function delivered(Request $request, $language)
    {
    	$progress = Order_progress::create([
	      'order_id' => $request->order_id,
	      'order_status_id' => 5,
	      'updated_by' => auth()->user()->id,
	      'date' => date('Y-m-d h:i:s')
	    ]);

	    $order = Order::find($request->order_id);
    	DB::table('orders')
        ->where('id', $order->id)
        ->update([
        	'order_status_id' => 5,
        	'updated_by' => auth()->user()->id,
        	'updated_at' => date('Y-m-d h:i:s')
      	]);
        return redirect()->route('courier.points', app()->getLocale());
    }

    public function canceled(Request $request, $language)
    {
    	$progress = Order_progress::create([
	      'order_id' => $request->order_id,
	      'order_status_id' => 6,
	      'updated_by' => auth()->user()->id,
	      'date' => date('Y-m-d h:i:s')
	    ]);

	    $order = Order::find($request->order_id);
    	DB::table('orders')
        ->where('id', $order->id)
        ->update([
        	'order_status_id' => 6,
        	'updated_by' => auth()->user()->id,
        	'updated_at' => date('Y-m-d h:i:s')
      	]);
        return redirect()->route('courier.points', app()->getLocale());
    }

    public function profile($language, $id)
    {
        $user = User::find($id);
        return view('courier.profile', compact('user', 'language'));
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
            return redirect()->route('courier', app()->getLocale());
        } else{
            return redirect()->route('courier.profile', ['language'=>app()->getLocale(), 'user'=>auth()->user()->id]);
        }        
    }
}
