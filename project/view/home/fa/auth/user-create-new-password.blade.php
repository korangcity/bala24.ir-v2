<!doctype html>
<html lang="fa" dir="rtl" data-layout="vertical" data-layout-style="detached" data-sidebar="light" data-topbar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>فراموشی رمز عبور</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="فراموشی رمز عبور" name="description" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{baseUrl(httpCheck())}}apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{baseUrl(httpCheck())}}favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{baseUrl(httpCheck())}}favicon-16x16.png">
    <link rel="manifest" href="{{baseUrl(httpCheck())}}site.webmanifest">
    <link rel="mask-icon" href="{{baseUrl(httpCheck())}}safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">


    <!-- Layout config Js -->
    <script src="{{baseUrl(httpCheck())}}home/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{baseUrl(httpCheck())}}home/assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{baseUrl(httpCheck())}}home/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{baseUrl(httpCheck())}}home/assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{baseUrl(httpCheck())}}home/assets/css/layoutCustom.css" rel="stylesheet" type="text/css" />
    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

</head>

<body>

<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="/" class="d-inline-block auth-logo">
                                <img src="{{baseUrl(httpCheck()).$setting['large_logo_light']}}" alt="" height="20">
                            </a>
                        </div>
{{--                        <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>--}}
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">رمز عبور جدید</h5>

                            </div>
                            <div class="p-2 mt-4">
                                @if (!empty(getErrors()))
                                    <div class="alert alert-danger col-md-12 col-sm-12">
                                        <ul>
                                            @foreach (getErrors() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form class="needs-validation" method="post" action="{{htmlspecialchars(substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],'?')))}}">
                                    <input type="hidden" name="token" value="{{$token}}">
                                    <input type="hidden" name="user_mobile" value="{{$user_mobile}}">

                                    <div class="mb-3">
                                        <label for="password" class="form-label">رمز عبور جدید<span class="text-danger">*</span> </label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="پسورد" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirm" class="form-label">تایید رمز عبور جدید<span class="text-danger">*</span> </label>
                                        <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="پسورد" required>
                                    </div>

                                    <div class="">

                                        <img src="{{$builder->inline()}}"/><span class="text-danger">*</span>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="mb-4">
                                                <input type="text" name="captcha" class="form-control  border-light"
                                                       placeholder="کد تصویر را وارد کنید" id="captcha">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-info w-100" type="submit">ثبت </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>


                    <div class="mt-4 text-center">
                        <p class="mb-0">آیا اکانت دارید؟ <a href="/" class="fw-semibold text-primary text-decoration-underline"> ورود </a> </p>
                    </div>

                </div>
            </div>

        </div>

    </div>



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/node-waves/waves.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/feather-icons/feather.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/js/plugins.js"></script>


<script src="{{baseUrl(httpCheck())}}home/assets/libs/particles.js/particles.js"></script>

<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/particles.app.js"></script>

<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/form-validation.init.js"></script>

<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/passowrd-create.init.js"></script>

<script>

    @if(getRegisterMessageOk()==true)
    Swal.fire({
        html: '<div class="mt-3">' +
            '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
            'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
            'style="width:120px;height:120px">' +
            '</lord-icon>' +
            '<div class="mt-4 pt-2 fs-15"><h4>پیام شما با موفقیت ثبت شد</h4>' +
            '</div>' +
            '</div>',
        showCancelButton: !1,
        showConfirmButton: 1,
        confirmButtonClass: "btn btn-success w-xs mb-1",
        confirmButtonText: "فهمیدم",
        buttonsStyling: !1,
        showCloseButton: !0
    }).then(function (t) {
        window.location.href = "{{baseUrl(httpCheck()).substr($_SERVER['REQUEST_URI'],1)."?verify=true"}}";
    })

    @endif
</script>
</body>

</html>

{{die()}}