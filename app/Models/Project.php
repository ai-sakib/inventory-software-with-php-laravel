<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
	protected $table = 'project';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'email',
		'phone',
		'address',
		'logo',
	];
}
