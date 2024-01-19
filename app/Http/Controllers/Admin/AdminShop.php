<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminShop extends Controller
{

    public function index(){
        // if(auth()->user()->role=="admin"){
            return view('admin.shop',[
                "title" => "Admin | Kantin",
                "shops" => Shop::all(),
            ]);
        // }else{
        //     return redirect('/admin/dashboard')->with("info","Anda tidak memiliki akses");
        // }
    }

    public function postHandler(Request $request){
        if($request->submit=="store"){
            $res = $this->store($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="update"){
            $res = $this->update($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="destroy"){
            $res = $this->destroy($request);
            return back()->with($res['status'],$res['message']);
            // return back()->with("info","Fitur hapus sementara dinonaktifkan");
        }
        else{
            return back()->with("info","Submit not found");
        }
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'username' => 'required',
            'password' => 'required',
            'owner'=>'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Check Username
        if(!Shop::whereUsername($request->username)->first()){
        // Create new user
            Shop::create($validatedData);
            return ['status'=>'success','message'=>'Kantin berhasil ditambahkan'];
        }else{
            return ['status'=>'error','message'=>'Username telah terpakai'];
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'username'=>'required',
            'owner'=>'required',
        ]);
        $validatedData['password'] = $request->password;

        $shop = Shop::find($request->id);
        $oldUsername = $shop->username;
        $newUsername = $request->username;
        
        //Check if password empty
        if(!$request->password){
            $validatedData['password'] = $shop->password;
        }else{
            $validatedData['password'] = Hash::make($request->password);
        }
        
        //Check if the shop is found
        if($shop){
            //Check username
            if($newUsername!=$oldUsername){
                if(Shop::whereUsername($request->username)->first()){
                    return ['status'=>'error','message'=>'Username telah terpakai'];
                }
                // Update shop
                $shop->update($validatedData);   
                return ['status'=>'success','message'=>'Kantin berhasil diedit.']; 
            }
            // Update shop
            $shop->update($validatedData);   
            return ['status'=>'success','message'=>'Kantin berhasil diedit']; 
        }else{
            return ['status'=>'error','message'=>'Kantin tidak ditemukan'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $shop = Shop::find($request->id);

        //Check if the shop is found
        if($shop){
            // $shop->invoice()->delete();    // Delete invoice
            // $shop->cashier()->delete();    // Delete cashier
            Shop::destroy($request->id);    // Delete user
            return ['status'=>'success','message'=>'Kantin berhasil dihapus'];
        }else{
            return ['status'=>'error','message'=>'Kantin tidak ditemukan'];
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
