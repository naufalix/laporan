<?php

namespace App\Http\Controllers\Shop;
use App\Http\Controllers\Controller;
use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShopCashier extends Controller
{

    public function index(){
        $shop_id = auth()->user()->id;
        return view('shop.cashier',[
            "title" => auth()->user()->name." | Akun kasir",
            "cashiers" => Cashier::whereShopId($shop_id)->get(),
        ]);
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
        ]);
        $validatedData['shop_id'] = auth()->user()->id;
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Check Username
        if(!Cashier::whereUsername($request->username)->first()){
        // Create new cashier
            Cashier::create($validatedData);
            return ['status'=>'success','message'=>'Akun kasir berhasil ditambahkan'];
        }else{
            return ['status'=>'error','message'=>'Username telah terpakai'];
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'username'=>'required',
        ]);
        $validatedData['password'] = $request->password;

        $cashier = Cashier::find($request->id);
        $oldUsername = $cashier->username;
        $newUsername = $request->username;
        
        //Check if password empty
        if(!$request->password){
            $validatedData['password'] = $cashier->password;
        }else{
            $validatedData['password'] = Hash::make($request->password);
        }
        
        //Check if the cashier is found
        if($cashier){
            //Check username
            if($newUsername!=$oldUsername){
                if(Cashier::whereUsername($request->username)->first()){
                    return ['status'=>'error','message'=>'Username telah terpakai'];
                }
                // Update cashier
                $cashier->update($validatedData);   
                return ['status'=>'success','message'=>'Akun kantin berhasil diedit.']; 
            }
            // Update cashier
            $cashier->update($validatedData);   
            return ['status'=>'success','message'=>'Akun kantin berhasil diedit']; 
        }else{
            return ['status'=>'error','message'=>'Akun kantin tidak ditemukan'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $cashier = Cashier::find($request->id);

        //Check if the cashier is found
        if($cashier){
            // $cashier->invoice()->delete();    // Delete invoice
            Cashier::destroy($request->id);      // Delete user
            return ['status'=>'success','message'=>'Akun kasir berhasil dihapus'];
        }else{
            return ['status'=>'error','message'=>'Akun kasir tidak ditemukan'];
        }
    }
}
