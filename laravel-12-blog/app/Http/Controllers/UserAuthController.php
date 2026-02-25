<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    //
    function login(Request $request)
    {
        // return "Login Function";
        // return $request->all();
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ['result' => "User not found", "success" => false];
        }
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        // return $user;
        return [
            'success' => true,
            'result' => $success,
            'msg' => 'User successfully'
        ];
    }
    function signup(Request $request)
    {
        // return "SignUp Function";
        $input = $request->all();
        $input["password"] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $user['name'] = $user->name;
        // return $input;
        return ['success' => true, "result" => $success, "msg" => "user successfully"];
    }
}
