<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Cashier;
use App\Models\Shop;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{

  public function Cashier(Cashier $cashier){  
    return ApiFormatter::createApi(200,"Success",$cashier);
  }
  public function Product(Product $product){  
    return ApiFormatter::createApi(200,"Success",$product);
  }
  public function Shop(Shop $shop){  
    return ApiFormatter::createApi(200,"Success",$shop);
  }
  public function User(User $user){  
    return ApiFormatter::createApi(200,"Success",$user);
  }

}
