<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutDetails extends Model {
	protected $table = 'stock_out_details';
	protected $primaryKey = 'id';

	protected $fillable = [
		'stock_out_id',
	    'item_id',
	    'quantity',
	    'price',
		'status',
		'created_by',
		'updated_by',
	];

	public function stockOut() {
		return $this->hasOne( StockOut::class, 'id', 'stock_out_id');
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
