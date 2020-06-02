<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\SubMenu;

class DashboardController extends Controller
{
    public function index($link)
    {
        $subMenu = SubMenu::where('link',$link)->first();
        $subMenuID = $subMenu->id;
        $mainMenuID = $subMenu->main_menu_id;
        if(isset($subMenuID)){
            return response()->json([
                'subMenuID' => $subMenuID,
                'mainMenuID' => $mainMenuID,
                'success' => true,
            ]);
        }else{
            return response()->json([
                'success' => false,
            ]);
        }
    }
}