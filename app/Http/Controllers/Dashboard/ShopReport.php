<?php

namespace App\Http\Controllers\shop;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ShopReport extends Controller
{

    public function index(){
        $shop_id = auth()->user()->id;
        return view('shop.report',[
            "title" => auth()->user()->name." | Laporan penjualan",
            "invoices" => Invoice::whereShopId($shop_id)->orderBy('id','DESC')->get(),
        ]);
    }

    public function postHandler(Request $request){
        if($request->submit=="filter"){
            return $this->filter($request);
        }
        else{
            return back()->with("info","Submit not found");
        }
    }

    public function filter(Request $request){
        $shop_id = auth()->user()->id;
        $start = $request->start;
        $end = $request->end;

        // Filter data by date range
        if($start&&$end){
            $invoices = Invoice::whereShopId($shop_id)->whereDate('created_at', '>', $start)->whereDate('created_at', '<', $end)->orderBy('id','DESC')->get();
        }else{
            $invoices = Invoice::whereShopId($shop_id)->orderBy('id','DESC')->get();
        }

        return view('shop.report',[
            "title" => auth()->user()->name." | Laporan penjualan",
            "invoices" => $invoices,
        ]);
    }
}
