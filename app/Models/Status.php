<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];
    
    public function users()
	{
		return $this->hasMany(User::class);
	}

	public function service_categories()
	{
		return $this->hasMany(Service_category::class);
	}

	public function services()
	{
		return $this->hasMany(Service::class);
	}
}
