<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInDetails extends Model {
	protected $table = 'stock_in_details';
	protected $primaryKey = 'id';

	protected $fillable = [
		'stock_in_id',
	    'item_id',
	    'quantity',
	    'price',
		'created_by',
		'updated_by',
	];

	public function stockIn() {
		return $this->hasOne( StockIn::class, 'id', 'stock_in_id');
	}
	public function item() {
		return $this->hasOne( Item::class, 'id', 'item_id');
	}
	public function creator() {
		return $this->hasOne( \App\User::class, 'id', 'created_by');
	}
	public function updator() {
		return $this->hasOne( \App\User::class, 'id', 'updated_by');
	}
}
