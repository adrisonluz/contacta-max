<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'sku', 
    	'name',
		'description',
		'quantity',
		'image'
	];

    protected $dates = ['deleted_at'];
}
