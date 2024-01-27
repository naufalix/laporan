@extends('layouts.admin')
@section('content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Data laporan</h4>
      <div class="ml-auto text-right">
        <button class="btn btn-info" data-toggle="modal" data-target="#tambah">Tambah</button>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar laporan</h5>
          <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered" style="min-width: 1500px">
              <thead>
                <tr>
                  <th style="width: 30px">No.</th>
                  <th>Tanggal</th>
                  <th>Nama anggota</th>
                  <th>Consultant</th>
                  <th>Pendamping</th>
                  <th>Tujuan</th>
                  <th>Alamat</th>
                  <th>Hasil</th>
                  <th>Status</th>
                  <th>Nasabah</th>
                  <th>Penawaran</th>
                  <th style="width: 80px">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reports as $r)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  @php
                    $date = date_create($r->tanggal);
                  @endphp
                  <td>{{date_format($date,"d/m/Y H:i")}}</td>
                  <td>{{$r->user->name}}</td>
                  <td>{{$r->consultant}}</td>
                  <td>{{$r->pendamping}}</td>
                  <td>
                    @if ($r->tujuan=="KN") Kunjungan Nasabah (KN)
                    @elseif ($r->tujuan=="APP") Appointment (APP)
                    @elseif ($r->tujuan=="FU") Follow up (FU)
                    @elseif ($r->tujuan=="AG") Agreement (AG)
                    @endif
                  </td>
                  <td>{{$r->alamat}}</td>
                  <td>
                    @if ($r->hasil=="CNC") CANCEL
                    @elseif ($r->hasil=="HPR") HOT PROSPEK (HPR)
                    @elseif ($r->hasil=="KPR") KETEMU PROSPEK (KPR)
                    @elseif ($r->hasil=="KTP") KETEMU TIDAK PROSPEK (KTP)
                    @elseif ($r->hasil=="TKO") TIDAK KETEMU ORANG (TKO)
                    @endif
                  </td>
                  <td>
                    @if ($r->status==0) <span class="badge badge-warning">Menunggu konfirmasi</span>
                    @elseif ($r->status==1) <span class="badge badge-success">Disetujui</span>
                    @elseif ($r->status==2) <span class="badge badge-danger">Revisi</span>
                    @endif
                  </td>
                  <td>{{$r->nasabah}}</td>
                  <td>{{$r->penawaran}}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#edit" onclick="edit({{$r->id}})"><i class="mdi mdi-pencil"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" data-toggle="modal" data-target="#hapus" onclick="hapus({{$r->id}})"><i class="fa fa-times"></i></button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog"aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah laporan baru</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="form" method="post">
        @csrf
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label class="required fw-bold mb-2">Pilih anggota</label>
              <select class="form-control" name="user_id" required>
                @foreach ($users as $u)
                  <option value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
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
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary me-3" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info" name="submit" value="store">Submit</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog"aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="et">Edit laporan</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="form" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="d-none" id="eid" name="id" required>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-6">
              <label class="required fw-bold mb-2">Tanggal</label>
              <input type="datetime-local" class="form-control" id="etg" name="tanggal" required>
            </div>
            <div class="col-6">
              <label class="required fw-bold mb-2">Consultant</label>
              <input type="text" class="form-control" id="ecn" name="consultant" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-6">
              <label class="required fw-bold mb-2">Pendamping</label>
              <input type="text" class="form-control" id="epd" name="pendamping" required>
            </div>
            <div class="col-6">
              <label class="required fw-bold mb-2">Tujuan</label>
              <select class="form-control" id="etj" name="tujuan" required>
                <option value="KN">Kunjungan Nasabah (KN)</option>
                <option value="APP">Appointment (APP)</option>
                <option value="FU">Follow up (FU)</option>
                <option value="AG">Agreement (AG)</option>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-6">
              <label class="required fw-bold mb-2">Alamat</label>
              <input type="alamat" class="form-control" id="eal" name="alamat" required>
            </div>
            <div class="col-6">
              <label class="required fw-bold mb-2">Hasil</label>
              <select class="form-control" id="ehs" name="hasil">
                <option value="CNC">CANCEL</option>
                <option value="HPR">HOT PROSPEK (HPR)</option>
                <option value="KPR">KETEMU PROSPEK (KPR)</option>
                <option value="KTP">KETEMU TIDAK PROSPEK (KTP)</option>
                <option value="TKO">TIDAK KETEMU ORANG (TKO)</option>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-6">
              <label class="required fw-bold mb-2">Nasabah</label>
              <input type="text" class="form-control" id="ens" name="nasabah" required>
            </div>
            <div class="col-6">
              <label class="required fw-bold mb-2">Penawaran</label>
              <input type="text" class="form-control" id="epn" name="penawaran" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="required fw-bold mb-2">Status</label>
              <select class="form-control" id="est" name="status">
                <option value="0">Menunggu konfirmasi</option>
                <option value="1">Disetujui</option>
                <option value="2">Revisi</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary me-3" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info" name="submit" value="update">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog"aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus laporan</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="form" method="post" action="">
        @csrf
        <input type="hidden" class="d-none" id="hi" name="id">
        <div class="modal-body">
          <p id="hd">Apakah anda yakin ingin menghapus laporan ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary me-3" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger" name="submit" value="destroy">Hapus</button>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $('#myTable').DataTable();
  
  function edit(id){
		$.ajax({
			url: "/api/report/"+id,
			type: 'GET',
			dataType: 'json', // added data type
			success: function(response) {
        var mydata = response.data;
				$("#eid").val(id);
				$("#etg").val(mydata.tanggal);
				$("#ecn").val(mydata.consultant);
				$("#epd").val(mydata.pendamping);
				$("#etj").val(mydata.tujuan);
				$("#eal").val(mydata.alamat);
				$("#ehs").val(mydata.hasil);
				$("#ens").val(mydata.nasabah);
				$("#epn").val(mydata.penawaran);
				$("#est").val(mydata.status);
        // $("#et").text("Edit "+mydata.name);
			}
		});
	}
	
  function hapus(id){
		$.ajax({
			url: "/api/report/"+id,
			type: 'GET',
			dataType: 'json', // added data type
			success: function(response) {
        var mydata = response.data;
				$("#hi").val(id);
				// $("#hd").text('Apakah anda yakin ingin menghapus "'+mydata.name+'"?');
			}
		});
	}
</script>
@endsection