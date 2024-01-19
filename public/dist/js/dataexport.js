const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

function dataexport(method){
  if(method=='copy'){
    $('.buttons-copy').click()
    Toast.fire({icon: 'success',title: 'Data berhasil dicopy'})
  }
  if(method=='csv'){
    $('.buttons-csv').click()
  }
  if(method=='excel'){
    $('.buttons-excel').click()
  }
  if(method=='pdf'){
    $('.buttons-pdf').click()
  }
  if(method=='print'){
    $('.buttons-print').click()
  }
}