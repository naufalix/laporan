@extends('layouts.shop')
@section('content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Laporan penjualan</h4>
      <div class="ml-auto text-right d-none">
        <a href="/cashier/invoice" class="btn btn-info">Tambah</a>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">

    <div class="col-12 col-md-6">
      <div class="card mb-0">
        <div class="card-body">
          <h5 class="card-title">Filter</h5>
          <form method="post">
            @csrf
            <p class="fw-bold mb-2">Rentang waktu</p>
            <div class="row mb-2">
              <div class="col-12 col-md-5 mb-2">
                <input type="date" name="start" class="form-control">
              </div>
              <div class="col-12 col-md-5 mb-2">
                <input type="date" name="end" class="form-control">
              </div>
              <div class="col-12 col-md-2 mb-2">
                <button type="submit" class="btn btn-primary" name="submit" value="filter">Cari</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="card mb-0">
        <div class="card-body">
          @php
            $total = 0;
          @endphp
          @foreach ($invoices as $i)
            @php
              $total += $i->amount;  
            @endphp  
          @endforeach
          <h5 class="card-title">Laporan profit</h5>
          <h2>Total profit = Rp. {{ number_format($total, 0, '.', '.') }}</h2>
        </div>
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
            <h5 class="card-title mr-auto">Laporan penjualan</h5>
            <button class="btn btn-success mb-2" onclick="dataexport('excel')">Excel</button>
            <button class="btn btn-danger mb-2 mx-2" onclick="dataexport('pdf')">PDF</button>
          </div>
          <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="width: 30px">No.</th>
                  <th style="width: 200px">Tanggal</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($invoices as $i)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  @php
                    $date = date_create($i->created_at);
                  @endphp
                  <td>{{date_format($date,"d F Y H:i")}}</td>
                  <td>Rp. {{ number_format($i->amount, 0, '.', '.') }}</td>
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
  
  function edit(id){
		$.ajax({
			url: "/api/product/"+id,
			type: 'GET',
			dataType: 'json', // added data type
			success: function(response) {
        var mydata = response.data;
				$("#eid").val(id);
				$("#enm").val(mydata.name);
				$("#epr").val(mydata.price);
        $("#et").text("Edit "+mydata.name);
			}
		});
	}
	
  function hapus(id){
		$.ajax({
			url: "/api/product/"+id,
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