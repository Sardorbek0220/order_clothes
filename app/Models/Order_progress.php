<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'order_status_id',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function order(){
      return $this->belongsTo(Order::class, 'order_id');
    }

    public function order_status(){
      return $this->belongsTo(Order_status::class, 'order_status_id');
    }
}
