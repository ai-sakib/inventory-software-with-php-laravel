<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {
	protected $table = 'items';
	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'uid',
	    'category_id',
	    'details',
	    'retail_price',
        'wholesale_price',
        'purchase_price',
	    'image',
		'status',
		'created_by',
		'updated_by',
	];

	public function category() {
		return $this->hasOne( ItemCategories::class, 'id', 'category_id');
	}
	public function creator() {
		return $this->hasOne( \App\User::class, 'id', 'created_by');
	}
	public function updator() {
		return $this->hasOne( \App\User::class, 'id', 'updated_by');
	}
	
}
