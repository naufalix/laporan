<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminReport extends Controller
{

    public function index(){
        // if(auth()->user()->role=="admin"){
            return view('admin.report',[
                "title" => "Admin | Data laporan",
                "reports" => Report::all(),
                "users" => User::all(),
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
            'user_id'=>'required|numeric',
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
            'status'=>'required',
            'nasabah'=>'required',
            'penawaran'=>'required',
        ]);

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
