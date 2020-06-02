<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model {
	protected $table = 'sub_menus';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'serial_no',
		'main_menu_id',
		'name',
	    'link',
	    'icon',
	    'status',
	];

	public function mainMenu() {
		return $this->hasOne( MainMenu::class, 'id', 'main_menu_id');
	}
}
