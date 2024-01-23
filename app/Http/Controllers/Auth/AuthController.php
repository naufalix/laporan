<?php

namespace App\Http\Controllers\Auth;
use App\Models\Meta;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        if(Auth::guard('admin')->check()){ return redirect('/admin/'); }
        if(Auth::guard('user')->check()){ return redirect('/dashboard/'); }
        return view('login',[
            "title" => "Login",
        ]);
    }
    
    public function index2(){
        if(Auth::guard('admin')->check()){ return redirect('/admin/'); }
        if(Auth::guard('user')->check()){ return redirect('/dashboard/'); }
        return view('register',[
            "title" => "Register",
        ]);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if($request->type=="admin"){
            if(Auth::guard('admin')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('/admin/');
            }
            return back()->with('error','Username/password salahh');
        }

        if($request->type=="user"){
            if(Auth::guard('user')->attempt($credentials)){
                $request->session()->regenerate();
                return redirect()->intended('/dashboard/');
            }
            return back()->with('error','Username/password salahh!');
        }

        else{
            return back();
        }
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Check email
        if(!User::whereEmail($request->email)->first()){
        // Create new user
            User::create($validatedData);
            return redirect('/login')->with('success','User berhasil ditambahkan');
        }else{
            return back()->with('error','Email telah terpakai');
        }
    }

    public function logout(){
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
        }
        return redirect('/login');
    }
}