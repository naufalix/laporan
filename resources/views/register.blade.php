@extends('layouts.auth')

@section('content')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
  <div class="auth-box border-top border-secondary">
    <div id="loginform">
      <div class="text-center p-t-20 p-b-20">
        <b class="logo-icon col-12 p-0 text-center" style="font-size: 20px;">
          Buat akun baru
        </b>
        {{-- <span class="db"><img src="/assets/images/logoX.jpg" alt="logo" style="width:200px"/></span> --}}
      </div>
      <!-- Form -->
      <form class="form-horizontal m-t-20" id="loginform" method="post" action="">
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-account"></i></span>
              </div>
              <input type="text" class="form-control form-control-lg" name="name" placeholder="Name" required>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-success text-white"><i class="mdi mdi-email"></i></span>
              </div>
              <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-warning text-white"><i class="mdi mdi-lock"></i></span>
              </div>
              <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required="">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-account"></i></span>
              </div>
              <input type="number" class="form-control form-control-lg" name="telp" placeholder="No telepon" required>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-account"></i></span>
              </div>
              <input type="text" class="form-control form-control-lg" name="city" placeholder="Tempat lahir" required>
            </div>
            <label for="">Tanggal lahir</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-account"></i></span>
              </div>
              <input type="date" class="form-control form-control-lg" name="birthday" placeholder="Tanggal lahir" required>
            </div>
            <label for="">Upline</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white"><i class="mdi mdi-account"></i></span>
              </div>
              <select class="form-control" name="upline" required>
                <option value="">Tidak ada</option>
                @foreach ($users as $u)
                  <option value="{{$u->id}}">{{$u->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div>
          <p>Sudah punya akun? <a href="/login">login disini!</a></p>
        </div>
        <div class="row border-top border-secondary">
          <div class="col-12">
            <div class="form-group row">
              <div class="p-t-20 mx-auto">
                <button class="btn btn-success" type="submit">Register</button>
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