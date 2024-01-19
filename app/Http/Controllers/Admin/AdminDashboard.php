<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cashier;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminDashboard extends Controller
{
    
    public function index(){
        return view('admin.dashboard',[
            "title" => "Admin | Dashboard",
            "cashiers" => Cashier::all(),
            "products" => Product::all(),
            "shops" => Shop::all(),
        ]);
    }

}
