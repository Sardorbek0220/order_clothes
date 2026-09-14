<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'name_ru',
        'name_en',
        'photo',
        'status_id'
    ];

    public function status(){
      return $this->belongsTo(Status::class, 'status_id');
    }

    public function services()
	{
		return $this->hasMany(Service::class);
	}

    public function order_details()
    {
        return $this->hasMany(Order_detail::class);
    }
}
