<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class SellerController extends Controller
{
    public function index(){
        $seller = User::role('seller')->get();  
        return Response()->json(["status"=>true,"seller"=>$seller]);
    }
}
