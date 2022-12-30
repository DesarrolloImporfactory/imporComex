<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    
    public function all(Request $request){
        $usuarios = User::count();
        return response()->json($usuarios);
    }
}
