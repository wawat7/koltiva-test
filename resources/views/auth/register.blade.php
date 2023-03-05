<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets') }}/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" id="form-register">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="name" name="name"
                                            placeholder="Full name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        placeholder="Foto">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ url('/login') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="{{ asset('assets') }}/js/custom.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets') }}/js/sb-admin-2.min.js"></script>

    <script>
        let base64file = '';

        $('#foto').on('change', async function() {
            const file = this.files[0];
            base64file = await convertFileToBase64(file);
        });

        $('#form-register').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '/api/register',
                data: {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    foto: base64file
                },
                success: function(response) {
                    window.location.href = '/login';
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 400 || xhr.status === 422) {
                        if (xhr.responseJSON?.message) {
                            $('#alert').html(`<p class="alert alert-danger">${xhr.responseJSON.message}</p>`)
                        }
                    } else if (xhr.status === 500){
                        if (xhr.responseJSON?.message) {
                            $('#alert').html(`<span class="alert alert-danger">Server Error</span>`)
                        }
                    }

                }
            });
        });
    </script>

</body>

</html>
