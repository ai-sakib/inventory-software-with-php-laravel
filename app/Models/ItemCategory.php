<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model {
	protected $table = 'item_categories';
	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'status',
		'created_by',
		'updated_by',
	];

	public function items() {
		return $this->hasMany( Items::class, 'category_id', 'id');
	}
	public function creator() {
		return $this->hasOne( \App\User::class, 'id', 'created_by');
	}
	public function updator() {
		return $this->hasOne( \App\User::class, 'id', 'updated_by');
	}
}
