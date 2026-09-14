<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
  use HasFactory;

  protected $fillable = [
    'id',
    'order_id',
    'service_id',
    'service_cat_id',
    'summa',
    'weight',
    'created_at',
    'updated_at'
  ];

  public function order(){
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function service(){
    return $this->belongsTo(Service::class, 'service_id');
  }

  public function service_cat(){
    return $this->belongsTo(Service_category::class, 'service_cat_id');
  }
}
