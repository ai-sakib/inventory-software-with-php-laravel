<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesType extends Model {
	protected $table = 'sales_types';
	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'status',
		'created_by',
		'updated_by',
	];

	public function creator() {
		return $this->hasOne( \App\User::class, 'id', 'created_by');
	}
	public function updator() {
		return $this->hasOne( \App\User::class, 'id', 'updated_by');
	}
}
