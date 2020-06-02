<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model {
	protected $table = 'stock_in';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'supplier_id',
		'stock_in_date',
		'location_id',
		'total_price',
		'discount',
		'paid',
		'remarks',
		'created_by',
		'updated_by',
	];

	public function details() {
		return $this->hasMany( StockInDetails::class, 'stock_in_id', 'id');
	}

	public function supplier() {
		return $this->hasOne( Supplier::class, 'id', 'supplier_id');
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
