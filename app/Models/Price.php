<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model {
	protected $table = 'prices';
	protected $primaryKey = 'id';

	protected $fillable = [
		'item_id',
	    'retail_price',
	    'wholesale_price',
	    'purchase_price',
	    'effective_date',
		'status',
		'created_by',
		'updated_by',
	];

	public function item() {
		return $this->hasOne( Items::class, 'id', 'item_id');
	}
	public function creator() {
		return $this->hasOne( \App\User::class, 'id', 'created_by');
	}
	public function updator() {
		return $this->hasOne( \App\User::class, 'id', 'updated_by');
	}
	
}
