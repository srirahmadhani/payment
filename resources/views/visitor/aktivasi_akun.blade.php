<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Verifikasi Akun</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <link href=" {{ asset ('css/sb-admin-2.css') }}" }} rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-6 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
                <div class="p-5">
                  <div class="text-center">
                    @if($error)
                    <h1 class="h4 text-gray-900 mb-4">Token sudah tidak valid!</h1>
                    @else
                    <h1 class="h4 text-gray-900 mb-4">
                      Akun Anda berhasil diaktifkan. Anda sudah bisa login ke aplikasi sekarang!
                    </h1>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset ('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset ('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset ('js/sb-admin-2.min.js') }}"></script>

</body>

</html>