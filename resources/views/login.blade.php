@extends('layouts.auth')

@section('content')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
  <div class="auth-box border-top border-secondary">
    <div id="loginform">
      <div class="text-center p-t-20 p-b-20">
        <b class="logo-icon col-12 p-0 text-center" style="font-size: 20px;">
          <i class="mdi mdi-chart-line-stacked"></i> Aplikasi laporan
        </b>
        {{-- <span class="db"><img src="/assets/images/logoX.jpg" alt="logo" style="width:200px"/></span> --}}
      </div>
      <!-- Form -->
      <form class="form-horizontal m-t-20" id="loginform" method="post" action="">
        @csrf
        <div class="row p-b-30">
          <div class="col-12">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="mdi mdi-email"></i></span>
              </div>
              <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" aria-describedby="basic-addon1" required>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="mdi mdi-lock"></i></span>
              </div>
              <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" aria-describedby="basic-addon1" required="">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-info text-white" id="basic-addon2"><i class="mdi mdi-clipboard-account"></i></span>
              </div>
              <select class="form-control form-control-lg" name="type" aria-describedby="basic-addon1" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row border-top border-secondary">
          <div class="col-12">
            <div class="form-group row">
              <div class="p-t-20 mx-auto">
                <button class="btn btn-success" type="submit">Login</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div id="recoverform">
      <div class="text-center">
        <span class="text-white">Enter your e-mail address below and we will send you instructions how to recover a password.</span>
      </div>
      <div class="row m-t-20">
        <!-- Form -->
        <form class="col-12" action="index.html">
          <!-- email -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
            </div>
            <input type="text" class="form-control form-control-lg" placeholder="Email Address" aria-label="Username" aria-describedby="basic-addon1">
          </div>
          <!-- pwd -->
          <div class="row m-t-20 p-t-20 border-top border-secondary">
            <div class="col-12">
              <a class="btn btn-success" href="#" id="to-login" name="action">Back To Login</a>
              <button class="btn btn-info float-right" type="button" name="action">Recover</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  $('[data-toggle="tooltip"]').tooltip();
  $(".preloader").fadeOut();
  // ============================================================== 
  // Login and Recover Password 
  // ============================================================== 
  $('#to-recover').on("click", function() {
      $("#loginform").slideUp();
      $("#recoverform").fadeIn();
  });
  $('#to-login').click(function(){
      
      $("#recoverform").hide();
      $("#loginform").fadeIn();
  });
</script>
@endsection