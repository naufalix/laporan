@extends('layouts.shop')
@section('content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Profil Toko</h4>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-body">
          <form class="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="d-none" name="id" required>
            <div class="modal-body">
              <div class="row mb-2">
                <div class="col-12 col-md-6">
                  <label class="required fw-bold mb-2">Nama kantin</label>
                  <input type="text" class="form-control" name="name" required value="{{auth()->user()->name}}">
                </div>
                <div class="col-12 col-md-6">
                  <label class="required fw-bold mb-2">Nama pemilik</label>
                  <input type="text" class="form-control" name="owner" required value="{{auth()->user()->owner}}">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-12 col-md-5">
                  <label class="required fw-bold mb-2">Username</label>
                  <input type="text" class="form-control" name="username" required value="{{auth()->user()->username}}">
                </div>
                <div class="col-12 col-md-7">
                  <label class="required fw-bold mb-2">Password</label>
                  <input type="password" class="form-control" name="password">
                  <sub class="text-danger">*Kosongkan jika tidak ingin mengganti password</sub>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info" name="submit" value="update">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="edit" tabindex="-1" role="dialog"aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="et">Edit kantin</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="form" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="d-none" id="eid" name="id" required>
        <div class="modal-body">
          <div class="row mb-2">
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Nama kantin</label>
              <input type="text" class="form-control" id="enm" name="name" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Nama pemilik</label>
              <input type="text" class="form-control" id="eow" name="owner" required>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-5">
              <label class="required fw-bold mb-2">Username</label>
              <input type="text" class="form-control" id="eun" name="username" required>
            </div>
            <div class="col-12 col-md-7">
              <label class="required fw-bold mb-2">Password</label>
              <input type="password" class="form-control" id="eps" name="password">
              <sub class="text-danger">*Kosongkan jika tidak ingin menghapus password</sub>
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
        <h5 class="modal-title">Hapus program</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form class="form" method="post" action="">
        @csrf
        <input type="hidden" class="d-none" id="hi" name="id">
        <div class="modal-body">
          <p id="hd">Apakah anda yakin ingin menghapus program ini?</p>
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
			url: "/api/shop/"+id,
			type: 'GET',
			dataType: 'json', // added data type
			success: function(response) {
        var mydata = response.data;
				$("#eid").val(id);
				$("#enm").val(mydata.name);
				$("#eun").val(mydata.username);
				$("#eow").val(mydata.owner);
        $("#et").text("Edit "+mydata.name);
			}
		});
	}
	
  function hapus(id){
		$.ajax({
			url: "/api/shop/"+id,
			type: 'GET',
			dataType: 'json', // added data type
			success: function(response) {
        var mydata = response.data;
				$("#hi").val(id);
				$("#hd").text('Apakah anda yakin ingin menghapus "'+mydata.name+'"?');
			}
		});
	}
</script>
@endsection