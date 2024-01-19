<!DOCTYPE html>
<html dir="ltr">
  <head>
    @include('partials.admin-head')
  </head>
  <body>

    <script>
      @if(session()->has('success'))
        Swal.fire({title:'Berhasil', text:'{{session('success')}}', icon:'success'})
      @endif
      @if(session()->has('error'))
        Swal.fire({title:'Error!', text:'{{session('error')}}', icon:'error'})
      @endif
      @if(session()->has('info'))
        Swal.fire({title:'Info', text:'{{session('info')}}', icon:'info'})
      @endif
      @if($errors->any())
        Swal.fire({title:'Error!', html:'{!! implode('', $errors->all(':message<br>')) !!}', icon:'error'})
      @endif
    </script>
    
    <div class="main-wrapper">  
      <div class="preloader">
        <div class="lds-ripple">
          <div class="lds-pos"></div>
          <div class="lds-pos"></div>
        </div>
      </div>
      @yield('content')
    </div>
    
    @include('partials.admin-script')
    @yield('script')
  
  </body>
</html>