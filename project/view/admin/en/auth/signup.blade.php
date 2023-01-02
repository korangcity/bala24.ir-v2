@extends('admin.en.layout.app')

@section("head")

    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section("content")

    <div class="main-content">
        <div class="page-content">
            <div class="auth-page-wrapper pt-5">

                <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
                    <div class="bg-overlay"></div>

                    <div class="shape">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 0 1440 120">
                            <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                        </svg>
                    </div>
                </div>


                <div class="auth-page-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center mt-sm-5 mb-4 text-white-50">
                                    <div>
                                        <a href="" class="d-inline-block auth-logo">
                                            <img src="{{baseUrl(httpCheck())}}assets/images/logo-light.png" alt="" height="20">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <div class="card mt-4">

                                    <div class="card-body p-4">
                                        <div class="text-start">
                                            <div class=" ms-1">
                                                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <img id="header-lang-img1"
                                                         src="{{baseUrl(httpCheck())}}assets/images/flags/{{getLanguage()=='en'?'us':(getLanguage()=='fa'?'ir':'sa')}}.svg"
                                                         alt="Header Language" height="20" class="rounded">
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <!-- item-->
                                                    <a href="{{baseUrl(httpCheck())}}adminpanel/Setting-changeLanguage-en"
                                                       class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                                                        <img src="{{baseUrl(httpCheck())}}assets/images/flags/us.svg" alt="user-image"
                                                             class="me-2 rounded" height="18">
                                                        <span class="align-middle">English</span>
                                                    </a>


                                                    <a href="{{baseUrl(httpCheck())}}adminpanel/Setting-changeLanguage-fa"
                                                       class="dropdown-item notify-item language" data-lang="fa" title="فارسی">
                                                        <img src="{{baseUrl(httpCheck())}}assets/images/flags/ir.svg" alt="user-image"
                                                             class="me-2 rounded" height="18">
                                                        <span class="align-middle">فارسی</span>
                                                    </a>


                                                    <a href="{{baseUrl(httpCheck())}}adminpanel/Setting-changeLanguage-ar"
                                                       class="dropdown-item notify-item language" data-lang="ar" title="العربیه">
                                                        <img src="{{baseUrl(httpCheck())}}assets/images/flags/sa.svg" alt="user-image"
                                                             class="me-2 rounded" height="18">
                                                        <span class="align-middle">العربیه</span>
                                                    </a>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h5 class="text-primary">Create New Account</h5>
                                        </div>
                                        @if (!empty(getErrors()))
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach (getErrors() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="p-2 mt-4">
                                            <form class="needs-validation" method="post" novalidate
                                                  action="/adminpanel/Auth-signupProcess">

                                                <input type="hidden" name="token" value="{{$token}}">
                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Email <span
                                                                class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control" id="useremail"
                                                           placeholder="Enter email address"
                                                           value="{{old('email')??''}}"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        Please enter email
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password <span
                                                                class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" name="password"
                                                               class="form-control pe-5 password-input"
                                                               onpaste="return false" placeholder="Enter password"
                                                               id="password-input" aria-describedby="passwordInput"
                                                               required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                                type="button" id="password-addon"><i
                                                                    class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Please enter password
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input1">Confirm Password
                                                        <span
                                                                class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" name="confirm_password"
                                                               class="form-control pe-5 password-input"
                                                               onpaste="return false"
                                                               placeholder="Enter confirm password"
                                                               id="password-input1" aria-describedby="passwordInput"
                                                               required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                                type="button" id="password-addon"><i
                                                                    class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Please enter confirm password
                                                        </div>
                                                    </div>
                                                </div>

                                                <img src="{{$builder->inline()}}"/>
                                                <div class="mb-3">
                                                    <label for="captcha" class="form-label">Enter captcha value <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" name="captcha" class="form-control" id="captcha"
                                                           placeholder="Enter captcha value" pattern="(?=.*\d).{5,}"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        Please enter captcha value
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree
                                                        to the
                                                        Bala24 <a href="#"
                                                                  class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                                            of Use</a></p>
                                                </div>

                                                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                    <h5 class="fs-13">Password must contain:</h5>
                                                    <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>4
                                                            characters</b>
                                                    </p>

                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Sign Up</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                                    </div>

                                                    <div>

                                                        <button type="button"
                                                                class="btn btn-danger btn-icon waves-effect waves-light">
                                                            <i
                                                                    class="ri-google-fill fs-16"></i></button>


                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                                <div class="mt-4 text-center">
                                    <p class="mb-0">Already have an account ? <a href="/signin"
                                                                                 class="fw-semibold text-primary text-decoration-underline">
                                            Signin </a></p>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection

@section("script")
    <script src="{{baseUrl(httpCheck())}}assets/libs/particles.js/particles.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/particles.app.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/form-validation.init.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/passowrd-create.init.js"></script>
    
    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>


    <script>
        @if($_REQUEST['error'])
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>Your request encountered an error.</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "Ok",
            buttonsStyling: !1,
            showCloseButton: !0
        })

        @endif
    </script>


@endsection