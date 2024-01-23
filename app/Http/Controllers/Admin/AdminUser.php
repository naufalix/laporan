<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Controller
{

    public function index(){
        // if(auth()->user()->role=="admin"){
            return view('admin.user',[
                "title" => "Admin | Data anggota",
                "users" => User::all(),
            ]);
        // }else{
        //     return redirect('/admin/dashboard')->with("info","Anda tidak memiliki akses");
        // }
    }

    public function postHandler(Request $request){
        if($request->submit=="store"){
            $res = $this->store($request);
            return redirect('/admin/user')->with($res['status'],$res['message']);
        }
        if($request->submit=="update"){
            $res = $this->update($request);
            return redirect('/admin/user')->with($res['status'],$res['message']);
        }if($request->submit=="destroy"){
            $res = $this->destroy($request);
            return redirect('/admin/user')->with($res['status'],$res['message']);
            // return redirect('/dashboard/user')->with("info","Fitur hapus sementara dinonaktifkan");
        }else{
            return redirect('/admin/user')->with("info","Submit not found");
        }
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'role'=>'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Check Username
        if(!User::whereUsername($request->username)->first()){
        // Create new user
            User::create($validatedData);
            return ['status'=>'success','message'=>'User berhasil ditambahkan'];
        }else{
            return ['status'=>'error','message'=>'Username telah terpakai'];
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'role'=>'required',
        ]);
        $validatedData['username'] = $request->username;

        $user = User::find($request->id);
        $oldUsername = $user->username;
        $newUsername = $request->username;
        
        //Check if password empty
        if(!$request->password){
            $validatedData['password'] = $user->password;
        }else{
            $validatedData['password'] = Hash::make($request->password);
        }
        
        //Check if the user is found
        if($user){
            //Check username
            if($newUsername!=$oldUsername){
                if(User::whereUsername($request->username)->first()){
                    return ['status'=>'error','message'=>'Username telah terpakai'];
                }
                // Update user
                $user->update($validatedData);   
                return ['status'=>'success','message'=>'User berhasil diedit.']; 
            }
            // Update user
            $user->update($validatedData);   
            return ['status'=>'success','message'=>'User berhasil diedit']; 
        }else{
            return ['status'=>'error','message'=>'User tidak ditemukan'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $user = User::find($request->id);

        //Check if the user is found
        if($user){
            $user->logbook()->delete();      // Delete logbook
            User::destroy($request->id);    // Delete user
            return ['status'=>'success','message'=>'User berhasil dihapus'];
        }else{
            return ['status'=>'error','message'=>'User tidak ditemukan'];
        }
    }

    public function profil(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
        ]);
        $validatedData['username'] = $request->username;

        $user = User::find(Auth::user()->id);
        $oldUsername = $user->username;
        $newUsername = $request->username;
        
        //Check if password empty
        if(!$request->password){
            $validatedData['password'] = $user->password;
        }else{
            $validatedData['password'] = Hash::make($request->password);
        }
        
        //Check if the user is found
        if($user){
            //Check username
            if($newUsername!=$oldUsername){
                if(User::whereUsername($request->username)->first()){
                    return ['status'=>'error','message'=>'Username telah terpakai'];
                }
                // Update profil
                $user->update($validatedData);   
                return ['status'=>'success','message'=>'Profil berhasil diedit.']; 
            }
            // Update profil
            $user->update($validatedData);   
            return ['status'=>'success','message'=>'Profil berhasil diedit']; 
        }else{
            return ['status'=>'error','message'=>'Profil tidak ditemukan'];
        }
    }
}
