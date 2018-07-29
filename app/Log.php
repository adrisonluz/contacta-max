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
}
