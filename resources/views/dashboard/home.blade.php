@extends('layouts.dashboard')

@section('content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Dashboard</h4>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Buat laporan</h5>
          <hr>
          <form class="form" method="post">
            @csrf
            <div>
              <div class="row mb-2">
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Tanggal</label>
                  <input type="datetime-local" class="form-control" name="tanggal" required>
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Consultant</label>
                  <input type="text" class="form-control" name="consultant" required>
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Pendamping</label>
                  <input type="text" class="form-control" name="pendamping" required>
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Tujuan</label>
                  <select class="form-control" name="tujuan" required>
                    <option value="KN">Kunjungan Nasabah (KN)</option>
                    <option value="APP">Appointment (APP)</option>
                    <option value="FU">Follow up (FU)</option>
                    <option value="AG">Agreement (AG)</option>
                  </select>
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Alamat</label>
                  <input type="alamat" class="form-control" name="alamat" required>
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Hasil</label>
                  <select class="form-control" name="hasil">
                    <option value="CNC">CANCEL</option>
                    <option value="HPR">HOT PROSPEK (HPR)</option>
                    <option value="KPR">KETEMU PROSPEK (KPR)</option>
                    <option value="KTP">KETEMU TIDAK PROSPEK (KTP)</option>
                    <option value="TKO">TIDAK KETEMU ORANG (TKO)</option>
                  </select>
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Nasabah</label>
                  <input type="text" class="form-control" name="nasabah" required>
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="required fw-bold mb-2">Penawaran</label>
                  <input type="alamat" class="form-control" name="penawaran" required>
                </div>
              </div>
            </div>
            <div>
              <button type="submit" class="btn btn-info" name="submit" value="store">Simpan laporan</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection