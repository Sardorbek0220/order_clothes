<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'name_ru',
        'name_en',
        'photo',
        'price',
        'service_cat_id',
        'status_id'
    ];

    public function status(){
      return $this->belongsTo(Status::class, 'status_id');
    }

    public function service_cat(){
      return $this->belongsTo(Service_category::class, 'service_cat_id');
    }

    public function order_details()
    {
        return $this->hasMany(Order_detail::class);
    }
}
