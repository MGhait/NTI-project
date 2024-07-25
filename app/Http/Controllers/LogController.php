<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LogController extends Controller
{
    public function verifyLogin(Request $request) {
        $request->validate([
            'logName' => 'required',
            'password' => 'required',
        ]);

        $loginUser = User::where("logName", "=", $request->logName)->first();

        if($loginUser){
            if ($loginUser->isActive != 1) {
                return redirect()->back()->with("failed", "This account is not activate");
            }
            else if (Hash::check($request->password, $loginUser->password)) {

                Session::put('userId', $loginUser->id);
                Session::put('userRole', $loginUser->role);
                Session::put('fullName', $loginUser->fullName);

                if($loginUser->role == 'admin') {
                    return redirect()->route('users.index');
                }
            else if($loginUser->role == 'editor') {
                return redirect()->route('users.index');
                }
                else if($loginUser->role == 'supervisor') {
                    return redirect()->route('users.index');
                }

            }
            else {
                return redirect()->back()->with("failed", "Login Failed not correct");
            }
        }
        else {
            return redirect()->back()->with("failed", "Login Failed Not a user");
        }

    }

    public function logout() {
        Session::flush();
        return redirect()->route('login')->with("logout", "You logged out, Good bye !!!");
    }

}
