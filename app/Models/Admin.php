<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Auth\CustomAuth as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $guarded = ['id'];
}
