<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    // 
    function getuser()
    {
        return "Hello";
    }
    function aboutUser($name)
    {
        // return "Hello" . $name;
        return view('demo', ['name' => $name], ['page' => "this is home page"]);  //  Passing $name to view
    }

    function adminLogin()
    {
        //  return view('admin.login');
        if (view::exists('admin.sign')) {
            return view('admin.sign');
        } else {
            echo "No view Found";
        }
    }
}
