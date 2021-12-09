<?php

namespace App\Models;
use App\Models\QtItem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qoute extends Model
{
	
	use HasFactory;
	protected $fillable = ['name','note','user_id','curr_vr_id','locale', 'currency_id'];
		
	public function items()
    {
        return $this->hasMany(QtItem::class);
    }
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }	
	
}


