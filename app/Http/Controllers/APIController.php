<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Report;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{

  public function Report(Report $report){  
    return ApiFormatter::createApi(200,"Success",$report);
  }
  public function User(User $user){  
    return ApiFormatter::createApi(200,"Success",$user);
  }

}
