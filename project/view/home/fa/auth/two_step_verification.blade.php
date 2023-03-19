<!doctype html>
<html lang="en" dir="rtl" data-layout="vertical" data-layout-style="detached" data-sidebar="light" data-topbar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>کد تایید</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="بالا 24" name="description" />

    <!-- App favicon -->
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

                    </div>
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="mb-4">
                                <div class="avatar-lg mx-auto">
                                    <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                                        <i class="ri-code-fill"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 mt-4">
                                <div class="text-muted text-center mb-4 mx-lg-3">
                                    <h4>تایید کد</h4>

                                </div>
                                @if (!empty(getErrors()))
                                    <div class="alert alert-danger col-md-12 col-sm-12">
                                        <ul>
                                            @foreach (getErrors() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form autocomplete="off" method="post" action="{{htmlspecialchars(substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],'?')))}}">
                                    <input type="hidden" name="token" value="{{$token}}">
                                    <input type="hidden" name="user_id" value="{{$user_id}}">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit1-input" class="visually-hidden">رقم اول</label>
                                                <input type="text" value="{{substr($user_code,3,1)}}" name="digit1" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(1, event)" maxLength="1" id="digit1-input">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit2-input" class="visually-hidden">رقم دوم</label>
                                                <input type="text" value="{{substr($user_code,2,1)}}" name="digit2" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(2, event)" maxLength="1" id="digit2-input">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit3-input" class="visually-hidden">رقم سوم</label>
                                                <input type="text" value="{{substr($user_code,1,1)}}" name="digit3" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(3, event)" maxLength="1" id="digit3-input">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="digit4-input" class="visually-hidden">رقم چهارم</label>
                                                <input type="text" value="{{substr($user_code,0,1)}}" name="digit4" class="form-control form-control-lg bg-light border-light text-center" onkeyup="moveToNext(4, event)" maxLength="1" id="digit4-input">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-info w-100">تایید</button>
                                    </div>
                                </form>


                            </div>
                        </div>

                    </div>


                </div>
            </div>

        </div>

    </div>


</div>

<script src="{{baseUrl(httpCheck())}}home/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/node-waves/waves.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/feather-icons/feather.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/js/plugins.js"></script>


<script src="{{baseUrl(httpCheck())}}home/assets/libs/particles.js/particles.js"></script>

<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/particles.app.js"></script>

<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/two-step-verification.init.js"></script>
</body>

</html>

@php  die(); @endphp