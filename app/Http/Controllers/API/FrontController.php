<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Service_category;
use App\Models\Order;
use App\Models\User;
use App\Models\Order_detail;
use App\Models\Order_status;
use App\Models\Payment;
use Kreait\Firebase\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth as AuthUser;

class FrontController extends Controller
{
    public function register(Request $request)
    {
        
        try {

            $firebase = app('firebase.auth')->getUser($request->uid);
            $check = User::where('uid', $request->uid)->get();
            if ($firebase->phoneNumber == $request->phone) {
                if (!empty($check)) {
                    return response()->json("You have been registered !!!", 200);
                }else{
                    $user = User::create([
                        'uid' => $request->uid,
                        'name' => $request->name,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'user_type_id' => 5,
                        'status_id' => 1
                    ]);
                    AuthUser::login($user);
                    return response()->json(true, 200);
                }
                
            }else{
                return response()->json(false, 200);
            }
        
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {

            return response()->json(false, 200);
            
        }

    }

    public function index()
    {
        // dd(app('firebase.auth')->getUser('kASs03VucDf6Ak8gKsEaXuedvpE3'));
        $data = [
            'services' => Service::get(),
            'service_categories' => Service_category::get(),
            'order_statuses' => Order_status::get(),
        ];
        return response()->json($data, 200);
    }

    public function create_order(Request $request)
    {
        // dd(app('firebase.auth')->getUser('kASs03VucDf6Ak8gKsEaXuedvpE3'));
        $order = Order::create([
            'user_uid' => $request->uid,
            'total_summa' => $request->total_summa,
            'total_weight' => $request->total_weight,
            'address' => $request->address,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'phone' => $request->phone,
            'order_status_id' => 1,
            'updated_by' => 0,
        ]);
        foreach ($request->orders as $value) {
            $detail = Order_detail::create([
                'order_id' => $order->id,
                'summa' => $value['summa'],
                'weight' => $value['weight'],
                'service_id' => $value['service_id'],
                'service_cat_id' => $value['service_cat_id']
            ]);
        }
        return response()->json(true, 200);
    }

    public function orders(Request $request)
    {
        $orders = Order::where('user_uid', $request->uid)->get();
        for ($i=0; $i < count($orders); $i++) { 
            $order_id = $orders[$i]['id'];
            $order_details = Order_detail::where('order_id', $order_id)->get();
            $payments = Payment::where('order_id', $order_id)->where('status', 'T')->get(['order_id', 'amount', 'updated_at']);
            $orders[$i]['order_details'] = $order_details;
            $orders[$i]['payments'] = $payments;
        }
        return response()->json($orders, 200);
    }

    public function order_update(Request $request)
    {
        $order = Order::find($request->id);
        if ($order->order_status_id == 1) {
            DB::table('orders')
            ->where('id', $order->id)
            ->update([
                'updated_by' => 0,
                'updated_at' => date('Y-m-d h:i:s')
            ]);
            // $order_details = Order_detail::where('order_id', $order->id)->get();
            return response()->json($order_details, 200);
        }else{
            return response()->json(false, 200);
        }
        
        
    }

    public function before_register(Request $request)
    {
        $check = User::where('phone', $request->phone)->first();
    //dd($check);
        if (empty($check) || $check->status_id == 1) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'notify.eskiz.uz/api/auth/login',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('email' => 'dakramov82@gmail.com','password' => 'zR6MdAtAYsJuz5duNSCS3UivsUhfI6kf9wQ6EEm7'),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response);

            if ($response->message === 'token_generated') {
              $token = $response->data->token;
              $random = random_int(100000, 999999);

              $curl = curl_init();
              curl_setopt_array($curl, array(
                CURLOPT_URL => 'notify.eskiz.uz/api/message/sms/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('mobile_phone' => $request->phone,'message' => "$random",'from' => '4546'),
                CURLOPT_HTTPHEADER => array(
                  "Authorization: Bearer {$token}"
                ),
              ));

              $response = curl_exec($curl);

              curl_close($curl);
              // dd($response);
              $response = json_decode($response);
              if ($response->status === 'waiting') {
                if (!empty($check) && $check->status_id == 1) {
                    $user = User::find($check->id);
                    $user->update([
                        'status_id' => 2,
                        'random_number' => $random
                    ]);
                }else{
                    $user = User::create([
                        'uid' => '',
                        'name' => $request->name,
                        'address' => $request->address,
                        'phone' => $request->phone,
                        'user_type_id' => 5,
                        'status_id' => 2,
                        'random_number' => $random
                    ]);
                }
                  
                if($user){
                    return response()->json(['success'=>true, 'data'=>['timelimit'=>180]], 200);  
                }else{
                    return response()->json(false, 200);
                }

              }else{
                return response()->json(false, 200);
              }
                
            }else{
                return response()->json(false, 200);
            }
        }else{
            return response()->json(false, 200);
        }
    }

    public function after_register(Request $request)
    {
        $user = User::where('phone', $request->phone)->where('random_number', $request->smsCode)->first();
        if (empty($user)) {
            return response()->json(false, 200);
        }else{
            $update = User::find($user->id);
            $update->update([
                'status_id' => 1
            ]);
            return response()->json(true, 200);
        }
    }
}
