<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_status extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function order_progresses()
    {
        return $this->hasMany(Order_progress::class);
    }
}
