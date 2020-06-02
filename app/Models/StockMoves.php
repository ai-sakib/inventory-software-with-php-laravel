<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMoves extends Model {
	protected $table = 'stock_moves';
	protected $primaryKey = 'id';

	protected $fillable = [
		'item_id',
		'trans_no',
	    'stock_type',
	    'from_location_id',
	    'location_id',
	    'quantity',
	    'stock_move_date',
	    'price',
		'created_by',
		'updated_by',
	];

	public function item() {
		return $this->hasOne( Item::class, 'id', 'item_id');
	}
	public function fromLocation() {
		return $this->hasOne( Location::class, 'id', 'from_location_id');
	}
	public function location() {
		return $this->hasOne( Location::class, 'id', 'location_id');
	}
	public function creator() {
		return $this->hasOne( \App\User::class, 'id', 'created_by');
	}
	public function updator() {
		return $this->hasOne( \App\User::class, 'id', 'updated_by');
	}
}
