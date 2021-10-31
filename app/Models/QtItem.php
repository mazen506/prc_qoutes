<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QtItem extends Model
{
    use HasFactory;
	protected $fillable = ['qoute_id',
						   'item_name',
						   'unit_id',
						   'package_qty',
						   'package_unit_id',
						   'price',
						   'moq',		
						   'note',		
						   'images'				   
						   ];
	public function qoute()
    {
        return $this->belongsTo(Qoute::class);
    }
	
	public function unit()
    {
        return $this->hasOne(Unit::class);
    }
}
