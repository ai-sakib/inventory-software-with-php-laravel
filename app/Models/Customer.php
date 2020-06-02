<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
	protected $table = 'customers';
	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'tax',
		'uid',
	    'address',
	    'phone',
	    'email',
	    'image',
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
