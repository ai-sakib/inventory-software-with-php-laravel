<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model {
	protected $table = 'stock_out';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'customer_id',
		'sales_type_id',
		'stock_out_date',
		'location_id',
		'total_price',
		'discount',
		'paid',
		'remarks',
		'status',
		'created_by',
		'updated_by',
	];

	public function details() {
		return $this->hasMany( StockOutDetails::class, 'stock_out_id', 'id');
	}

	public function customer() {
		return $this->hasOne( Customer::class, 'id', 'customer_id');
	}
	public function salesType() {
		return $this->hasOne( SalesType::class, 'id', 'sales_type_id');
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
