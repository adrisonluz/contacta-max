<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
    	'system', 
    	'product_id',
		'action',
		'quantity'
	];

	protected $dates = [
        'created_at',
		'updated_at'
	];

	public function product(){
		return $this->belongsTo('App\Product');
	}
}
