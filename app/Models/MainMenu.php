<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model {
	protected $table = 'main_menus';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'serial_no',
		'name',
	    'icon',
	    'status',
	];

	public function subMenus() {
		return $this->hasMany( SubMenu::class, 'main_menu_id', 'id');
	}
	
}
