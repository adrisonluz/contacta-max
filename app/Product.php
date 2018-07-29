<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

	protected $fillable = [
    	'sku', 
    	'name',
		'description',
		'quantity',
		'image'
	];

	protected $dates = ['deleted_at'];
	
	public function logs(){
		return $this->hasMany('App\Log');
	}
}
