<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminHome extends Controller
{
    
    public function index(){
        return view('admin.home',[
            "title" => "Admin | Dashboard",
            "reports" => Report::all(),
            "users" => User::all(),
        ]);
    }

}
