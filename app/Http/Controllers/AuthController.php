<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view("auths.login");
    }
    public function postLogin(Request $request)
    {

        $request ->validate([
            "email"=> "required|email",
            "password"=> "required",
        ],[
            "email.required" => "Email kısmını boş bırakmayınız",
            "email.email" => "Email (@) formatında giriniz",
            "password.required" => "Şifre kısmının boş bırakmayınız",
        ]
        );

        $credentials = $request->only("email","password");

        if(Auth::attempt($credentials)){
            return redirect()->intended(route("product.home"))->with("success",'login is success');
            // return redirect(route("home"))->with("success",'login is success');
        }
        if (!User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Bu e-posta adresi kayıtlı değil'])->withInput($request->only('email'));
        } else {
            return back()->withErrors(['password' => 'Girdiğiniz şifre yanlış'])->withInput($request->only('email','password'));
        }


    }
    public function register()
    {
        return view("auths.register");
    }
    public function postRegister(Request $request)
    {
        $request ->validate([
            "name"=> "required",
            "email"=> "required|email|unique:users",
            "password"=> "required|min:6",
            "r_password"=> "required|same:password",
        ],[
            "email.required" => "Email kısmını boş bırakmayınız",
            "email.email" => "Email (@) formatında giriniz",
            "email.unique" => "Bu email kullanılıyor, başka bir mail deneyiniz",
            "password.min" => "Minimum 6 haneli şifre giriniz",
            "r_password.required" => "Şifre tekrarı kısmının boş bırakmayınız",
            "r_password.same" => "Girdiğiniz şifreyle eşleşmiyor",

        ]
        );

        $data["name"] = $request->name;
        $data["email"] = $request->email;
        $data["password"] = Hash::make($request->password);
        $user = User::create($data);
        if(!$user){
            return redirect(route("register"))->with("error",'Registration failed , try again.');
        }
        return redirect(route("login"))->with("success",'Registration success, Login to access to app');

    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route("login"));
    }


}
