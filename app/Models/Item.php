<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QtItem extends Model
{
    use HasFactory;
	protected $fillable = ['qoute_id',
						   'item_name',
						   'package_id',
						   'qty',
						   'price',
						   'moq',		
						   'note',		
						   'images'				   
						   ];
	public function qoute()
    {
        return $this->belongsTo(Qoute::class);
    }
	
	public function package()
    {
        return $this->hasOne(Package::class);
    }

}


