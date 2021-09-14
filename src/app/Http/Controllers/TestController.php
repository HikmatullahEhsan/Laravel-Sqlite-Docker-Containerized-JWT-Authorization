<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\User;
class TestController extends Controller
{
   public function users(){
       $sql = "SELECT * FROM users";
    //    $query = User::create([
    //        'name' => 'Ahmad',
    //        'email' => 'ahmad@ymail.com',
    //        'password' => '****'
    //    ]);
    $query = DB::raw(DB::select($sql));
    return dd($query);
   }
}
