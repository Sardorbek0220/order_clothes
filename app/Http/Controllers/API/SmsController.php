<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SmsController extends Controller
{
  public function send()
  {
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
        CURLOPT_POSTFIELDS => array('mobile_phone' => '998945535570','message' => "$random",'from' => '4546'),
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer {$token}"
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      dd($response);
    }
    
  }
}
