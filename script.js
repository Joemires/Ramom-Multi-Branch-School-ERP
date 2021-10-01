Swal.fire({
  title: 'Welcome To Lina Teresa School',
  showDenyButton: true,
  showCancelButton: false,
  confirmButtonText: 'Visit Secondary Portal',
  denyButtonText: `Visit Primary Portal`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "https://linateresa.org/home/index/linateresaorg";
  } else if (result.isDenied) {
    window.location = "https://linateresa.org/home/index/primary";
  }
})
