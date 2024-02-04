<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashReport extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        return view('dashboard.home',[
            "title" => "Dashboard | Buat laporan",
        ]);
    }

    public function print(Request $request){
        $user_id = auth()->user()->id;
        $year = $request['year'];
        $month = $request['month'];

        return view('dashboard.report-print',[
            "title" => "Dashboard | Print laporan",
            "year" => $year,
            "month" => $month,
            "reports" => Report::whereUserId($user_id)->whereYear('tanggal', '=', $year)->whereMonth('tanggal', '=', $month)->get(),
        ]);
    }

    public function index2(){
        $user_id = auth()->user()->id;
        return view('dashboard.report',[
            "title" => "Dashboard | Data laporan",
            "reports" => Report::whereUserId($user_id)->get(),
        ]);
    }

    public function postHandler(Request $request){
        if($request->submit=="store"){
            $res = $this->store($request);
            return redirect('/dashboard/laporan')->with($res['status'],$res['message']);
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
            'tanggal'=>'required',
            'consultant'=>'required',
            'pendamping'=>'required',
            'tujuan'=>'required',
            'alamat'=>'required',
            'hasil'=>'required',
            'nasabah'=>'required',
            'penawaran'=>'required',
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['status'] = 0;
        
        //Create report
        Report::create($validatedData);
        return ['status'=>'success','message'=>'Laporan berhasil ditambahkan'];
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'tanggal'=>'required',
            'consultant'=>'required',
            'pendamping'=>'required',
            'tujuan'=>'required',
            'alamat'=>'required',
            'hasil'=>'required',
            'nasabah'=>'required',
            'penawaran'=>'required',
        ]);
        $validatedData['status'] = 0;
        
        $report = Report::find($request->id);

        //Check if the report is found
        if($report){
            
            //Update report
            $report->update($validatedData);
            return ['status'=>'success','message'=>'Laporan berhasil diupdate'];
            
        }else{
            return ['status'=>'error','message'=>'Laporan tidak ditemukan'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $report = Report::find($request->id);

        //Check if the report is found
        if($report){
            
            //Delete report
            Report::destroy($request->id);
            return ['status'=>'success','message'=>'Laporan berhasil dihapus'];
        
        }else{
            return ['status'=>'error','message'=>'Laporan tidak ditemukan'];
        }
    }
}
