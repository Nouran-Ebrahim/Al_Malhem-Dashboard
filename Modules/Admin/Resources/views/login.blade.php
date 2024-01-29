<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>اسره ال ملحم</title>
    <link rel="apple-touch-icon" href="{{ asset('') }}admin/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}admin/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;500&display=swap" rel="stylesheet">


    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/vendors-rtl.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/css-rtl/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/custom-rtl.css">
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style-rtl.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body id="login-body" class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  "
    data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <section class="vh-100" style="background-color: #0F2C59; ">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-8  ">
                    <div class="card " style="border-radius: 1rem;margin-bottom:0px">
                        <div class="row g-0">
                            <div class="mb-2 col-md-6 col-lg-5 d-none d-md-block">
                                <img src="{{ asset('') }}admin/images/pages/738-01.jpg" alt="login form"
                                    class="img-fluid" style="" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form class="was-validated" dir="rtl"
                                        action="{{ route('admin.login.submit') }}" method="post">
                                        @csrf

                                        <div class="d-flex  align-items-center mb-3 ">
                                            <img width="50"
                                                src="{{ asset('') }}admin/images/pages/reading.png">
                                            <span class="h1 fw-bold mb-0 ms-2"> آل ملحم</span>
                                        </div>

                                        <h4 class="fw-normal mb-2 " style="letter-spacing: 1px;">تسجيل الدخول👋
                                        </h4>

                                        <div class="form-outline mb-2">
                                            <label class="form-label pb-1" style="font-size: 15px"
                                                for="login-email">البريد الالكترونى</label>

                                            <input required id="login-email"
                                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                type="email" name="email" placeholder=""
                                                aria-describedby="login-email" value="{{ old('email') }}"
                                                autofocus="" tabindex="1" />
                                            @error('email')
                                                @foreach ($errors->get('email') as $message)
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @endforeach

                                            @enderror

                                        </div>

                                        <div class="form-outline mb-2">
                                            <label class="form-label pb-1" for="login-password"
                                                style="font-size: 15px">كلمة المرور</label>

                                            <div class="input-group input-group-merge form-password-toggle">

                                                <input required
                                                    class="form-control form-control-merge form-control-lg @error('password') is-invalid @enderror"
                                                    id="login-password" type="password" name="password"
                                                    placeholder="············" aria-describedby="login-password"
                                                    tabindex="2" /><span class="input-group-text cursor-pointer"><i
                                                        data-feather="eye"></i></span>
                                                @error('password')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror

                                            </div>

                                        </div>

                                        <div class="pt-1 ">
                                            <button class="btn btn-dark btn-lg btn-block">تسجيل
                                                الدخول</button>
                                        </div>


                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('') }}admin/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('') }}admin/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('') }}admin/js/core/app-menu.js"></script>
    <script src="{{ asset('') }}admin/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('') }}admin/js/scripts/pages/auth-login.js"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>
