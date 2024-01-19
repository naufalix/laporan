<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShopProfile extends Controller
{

    public function index(){
        return view('shop.profile',[
            "title" => auth()->user()->name." | Dashboard",
        ]);
    }

    public function postHandler(Request $request){
        if($request->submit=="update"){
            $res = $this->update($request);
            return back()->with($res['status'],$res['message']);
        }
        else{
            return back()->with("info","Submit not found");
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'owner'=>'required',
        ]);
        $validatedData['username'] = $request->username;

        $shop = Shop::find(auth()->user()->id);
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
                return ['status'=>'success','message'=>'Profil berhasil diedit.']; 
            }
            // Update shop
            $shop->update($validatedData);   
            return ['status'=>'success','message'=>'Profil berhasil diedit']; 
        }else{
            return ['status'=>'error','message'=>'Toko tidak ditemukan'];
        }
    }

}
