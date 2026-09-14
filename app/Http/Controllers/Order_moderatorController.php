<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Order_progress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order_moderatorController extends Controller
{
    public function index($language)
    {
    	return view('order_moderator.index', compact('language'));
    }

    public function orders($language)
    {
    	$orders = Order::orderBy('created_at', 'DESC')->get();
    	return view('order_moderator.orders', compact('orders', 'language'));
    }

    public function order_detail($language, $id)
    {
        $detail = Order_detail::where('order_id', $id)->paginate(10);
        // dd($detail);
        return view('order_moderator.detail', compact('detail', 'id', 'language'));
    }

    public function in_progress(Request $request, $language)
    {
    	$progress = Order_progress::create([
	      'order_id' => $request->order_id,
	      'order_status_id' => 2,
	      'updated_by' => auth()->user()->id,
	      'date' => date('Y-m-d h:i:s')
	    ]);

	    $order = Order::find($request->order_id);
    	DB::table('orders')
        ->where('id', $order->id)
        ->update([
        	'order_status_id' => 2,
        	'updated_by' => auth()->user()->id,
        	'updated_at' => date('Y-m-d h:i:s')
      	]);
        return redirect()->route('order_moderator.orders', app()->getLocale());
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
        return redirect()->route('order_moderator.orders', app()->getLocale());
    }

    public function done(Request $request, $language)
    {
    	$progress = Order_progress::create([
	      'order_id' => $request->order_id,
	      'order_status_id' => 3,
	      'updated_by' => auth()->user()->id,
	      'date' => date('Y-m-d h:i:s')
	    ]);

	    $order = Order::find($request->order_id);
    	DB::table('orders')
        ->where('id', $order->id)
        ->update([
        	'order_status_id' => 3,
        	'updated_by' => auth()->user()->id,
        	'updated_at' => date('Y-m-d h:i:s')
      	]);
        return redirect()->route('order_moderator.orders', app()->getLocale());
    }

    public function sent(Request $request, $language)
    {
    	$progress = Order_progress::create([
	      'order_id' => $request->order_id,
	      'order_status_id' => 4,
	      'updated_by' => auth()->user()->id,
	      'date' => date('Y-m-d h:i:s')
	    ]);

	    $order = Order::find($request->order_id);
    	DB::table('orders')
        ->where('id', $order->id)
        ->update([
        	'order_status_id' => 4,
        	'updated_by' => auth()->user()->id,
        	'updated_at' => date('Y-m-d h:i:s')
      	]);
        return redirect()->route('order_moderator.orders', app()->getLocale());
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
        return redirect()->route('order_moderator.orders', app()->getLocale());
    }

    public function profile($language, $id)
    {
        $user = User::find($id);
        return view('order_moderator.profile', compact('user', 'language'));
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
            return redirect()->route('order_moderator', app()->getLocale());
        } else{
            return redirect()->route('order_moderator.profile', ['language'=>app()->getLocale(), 'user'=>auth()->user()->id]);
        }        
    }
}
