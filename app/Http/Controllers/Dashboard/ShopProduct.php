<?php

namespace App\Http\Controllers\shop;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ShopProduct extends Controller
{

    public function index(){
        $shop_id = auth()->user()->id;
        return view('shop.product',[
            "title" => auth()->user()->name." | Dashboard",
            "products" => Product::whereShopId($shop_id)->get(),
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
            'price'=>'required|numeric',
        ]);
        $validatedData['shop_id'] = auth()->user()->id;
        
        //Create product
        Product::create($validatedData);
        return ['status'=>'success','message'=>'Menu berhasil ditambahkan'];
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'price'=>'required',
        ]);
        $validatedData['shop_id'] = auth()->user()->id;
        
        $product = Product::find($request->id);

        //Check if the product is found
        if($product){
            
            //Update product
            $product->update($validatedData);
            return ['status'=>'success','message'=>'Menu berhasil diupdate'];
            
        }else{
            return ['status'=>'error','message'=>'Menu tidak ditemukan'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $product = Product::find($request->id);

        //Check if the product is found
        if($product){
            
            //Delete product
            Product::destroy($request->id);
            return ['status'=>'success','message'=>'Menu berhasil dihapus'];
        
        }else{
            return ['status'=>'error','message'=>'Menu tidak ditemukan'];
        }
    }
}
