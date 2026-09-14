<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_uid',
        'total_summa',
        'total_weight',
        'address',
        'lat',
        'lon',
        'phone',
        'order_status_id',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function order_status(){
      return $this->belongsTo(Order_status::class, 'order_status_id');
    }

    public function user(){
      return $this->belongsTo(User::class, 'user_uid');
    }

    public function order_details()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function order_progresses()
    {
        return $this->hasMany(Order_progress::class);
    }
}
