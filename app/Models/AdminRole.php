<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model {
	protected $table = 'admin_roles';
	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'created_by',
	];

	public function users() {
		return $this->hasMany( \App\User::class, 'role_id', 'id');
	}
	public function creator() {
		return $this->hasOne( \App\User::class, 'id', 'created_by');
	}
}
