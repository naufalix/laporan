@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">Dashboard</h4>
    </div>
  </div>
</div>
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Sales Cards  -->
  <!-- ============================================================== -->
  <div class="row">

    <!-- Column -->
    <div class="col-12 col-md-3">
      <div class="card card-hover">
        <div class="box bg-dark d-flex">
          <div class="col-3">
            <h1 class="font-light text-white m-0"><i class="mdi mdi-store" style="font-size: 60px"></i></h1>
          </div>
          <div class="col-9">
            <p class="text-light mt-2 mb-0">Total Kantin</p>
            <h2 class="text-white">{{ $shops->count() }}</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Column -->
    <div class="col-12 col-md-3">
      <div class="card card-hover">
        <div class="box bg-dark d-flex">
          <div class="col-3">
            <h1 class="font-light text-white m-0"><i class="mdi mdi-food" style="font-size: 60px"></i></h1>
          </div>
          <div class="col-9">
            <p class="text-light mt-2 mb-0">Total Produk</p>
            <h2 class="text-white">{{ $products->count() }}</h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Column -->
    <div class="col-12 col-md-3">
      <div class="card card-hover">
        <div class="box bg-dark d-flex">
          <div class="col-3">
            <h1 class="font-light text-white m-0"><i class="mdi mdi-account" style="font-size: 60px"></i></h1>
          </div>
          <div class="col-9">
            <p class="text-light mt-2 mb-0">Total Kasir</p>
            <h2 class="text-white">{{ $cashiers->count() }}</h2>
          </div>
        </div>
      </div>
    </div>
    
  </div>

</div>
@endsection