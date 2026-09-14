<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;

class GetStatusController extends Controller
{
  public function getPayment(Request $request)
  {
    $payment = Payment::create([
        'order_id' => $request->order_id,
        'amount' => 0,
        'status' => 'F',
        'transaction_id' => '',
        'json' => json_encode($request->all())
    ]);
    if ($payment) {
      return true;
    }else{
      return false;
    }
  }

  public function check(Request $request)
  {

    try {
            
      if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] == 'uzumbank-msbase' && $_SERVER['PHP_AUTH_PW'] == '7frE>Txh8VmdtZ+VvqcD') {
          $payment = Payment::where('order_id', $request->params['orderId'])->orderBy('created_at', 'desc')->first();
          if ($payment) {
            $response = [
              'status' => true,
              'error' => null,
              'data' => [
                'fio' => 'abc'
              ]
            ];
          }else{
            $response = [
              'status' => false,
              'error' => 'order_not_found',
              'data' => null
            ];
          }
          return $response;
        }else{
          return response()->json(['error' => 'Not authorized.'],403);
        }
      }else{
        return response()->json(['error' => 'Not authorized.'],403);
      }

    } catch (\Exception $e) {

      return response('Something went wrong !', 404);

    }

  }

  public function pay(Request $request)
  {
    try {

      if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] == 'uzumbank-msbase' && $_SERVER['PHP_AUTH_PW'] == '7frE>Txh8VmdtZ+VvqcD') {
          $payment = Payment::where('order_id', $request->params['orderId'])->orderBy('created_at', 'desc')->first();
          if ($payment) {

            $trans = Payment::find($payment->id);
            $trans->update([
                'amount' => $request->params['amount'],
                'status' => 'T',
                'transaction_id' => $request->params['transactionId'],
                'json' => json_encode($request->params)
            ]);
            $response = [
                'status' => true,
                'error' => ''
            ];
              
          }else{
            $response = [
              'status' => false,
              'error' => 'order_not_found'
            ];
          }
          return $response;
        }else{
          return response()->json(['error' => 'Not authorized.'],403);
        }
      }else{
        return response()->json(['error' => 'Not authorized.'],403);
      }

    } catch (\Exception $e) {

      return response('Something went wrong !', 404);

    }
  }
}
