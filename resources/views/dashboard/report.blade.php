@extends('layouts.dashboard')
@section('content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Data laporan</h4>
      <div class="ml-auto text-right">
        <a href="/dashboard/buat-laporan" class="btn btn-info">Tambah</a>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex">
            <h5 class="card-title mr-auto">Daftar laporan</h5>
            <button class="btn btn-primary mb-2 d-none" onclick="dataexport('print')"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#print"><i class="fa fa-print"></i> Print</button>
          </div>
          <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="width: 30px">No.</th>
                  <th>Tanggal</th>
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
                  <td>{{$r->consultant}}</td>
                  <td>{{$r->pendamping}}</td>
                  <td>
                    @if ($r->tujuan=="KN") Kunjungan Nasabah
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
                    @if ($r->status==0||$r->status==2)
                    <button type="button" class="btn btn-info btn-icon" data-toggle="modal" data-target="#edit" onclick="edit({{$r->id}})"><i class="mdi mdi-pencil"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" data-toggle="modal" data-target="#hapus" onclick="hapus({{$r->id}})"><i class="fa fa-times"></i></button>
                    @endif
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
        <h5 class="modal-title">Tambah menu baru</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="form" method="post">
        @csrf
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label class="required fw-bold mb-2">Nama menu</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <label class="required fw-bold mb-2">Harga</label>
              <input type="number" class="form-control" id="price" name="price" required>
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

<div class="modal fade" id="print" tabindex="-1" role="dialog"aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Print laporan</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="form" method="post" action="">
        @csrf
        <input type="hidden" class="d-none" id="hi" name="id">
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12">
              <label class="required fw-bold mb-2">Pilih bulan</label>
              <input type="month" class="form-control" id="month" name="month" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary me-3" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" onClick="printreport()">Print</button>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $('#myTable').DataTable({
    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All Pages"]],
    "pageLength": 10,
    "order": [[0, 'desc']],
    "language": {
      "paginate": {
        "previous": "<",
        "next": ">"
      }
    },
    "dom": 'Blfrtip',
    "buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
  });

  function printreport(){
    var month = $("#month").val().replace("-", "/")
    if(month){
      window.open('/dashboard/printreport/'+month,'POPUP WINDOW TITLE HERE','width=800,height=800').print()
    }else{
      alert("Harap pilih bulan terlebih dahulu");
    }
    // MyWindow=window.open('/dashboard/logbook/print','MyWindow','width=800,height=600'); 
    // return false;
  }
  
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