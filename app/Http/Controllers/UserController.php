<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
public function Test(){
    return "walid is the best";
}

public function Login_User(){
    return view("login");
}



}
