@extends("admin.fa.layout.app")

@section("title","مدیریت وبسایت | ویرایش اطلاعات ادمین")


@section("head")

    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        @if (!empty(getErrors()))
                                            <div class="alert alert-danger col-md-6 col-sm-12">
                                                <ul>
                                                    @foreach (getErrors() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="/adminpanel/Auth-changeAdminAvatar" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="token" value="{{$token}}">
                                            <input type="hidden" name="user_id" value="{{$user['id']}}">
                                            <input type="submit" value="ثبت" class="btn btn-outline-success btn-sm">
                                            <img src="{{baseUrl(httpCheck()).($user['avatar']??"assets/images/users/avatar-1.jpg")}}"
                                                 class="rounded-circle avatar-xl img-thumbnail user-profile-image" id="preloadImageShow"
                                                 alt="user-profile-image">

                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                <input id="profile-img-file-input" name="avatar" type="file"
                                                       class="profile-img-file-input">
                                                <label for="profile-img-file-input"
                                                       class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </label>

                                            </div>

                                        </form>
                                    </div>
                                    <h5 class="fs-17 mb-1">{{$user['name']??'---'}}</h5>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails"
                                           role="tab">
                                            <i class="fas fa-home"></i>
                                            جزییات اطلاعات
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        @if (!empty(getErrors()))
                                            <div class="alert alert-danger col-md-6 col-sm-12">
                                                <ul>
                                                    @foreach (getErrors() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="/adminpanel/Auth-adminEditProcess" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="token" value="{{$token}}">
                                            <input type="hidden" name="user_id" value="{{$user['id']}}">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">نام</label>
                                                        <input type="text" class="form-control" name="name" id="name"
                                                               placeholder="" value="{{$user['name']}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="mobile" class="form-label">موبایل</label>
                                                        <input type="text" name="mobile" class="form-control"
                                                               id="mobile"
                                                               placeholder="" value="{{$user['mobile']}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="civilization_code" class="form-label">کد ملی</label>
                                                        <input type="text" name="civilization_code" class="form-control"
                                                               id="civilization_code"
                                                               placeholder=""
                                                               value="{{$user['civilization_code']}}">
                                                    </div>
                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="departman" class="form-label">دپارتمان</label>
                                                        <input type="text" name="departman" class="form-control"
                                                               id="departman"
                                                               placeholder=""
                                                               value="{{$user['departman']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="address" class="form-label">آدرس</label>
                                                        <input type="text" name="address" class="form-control"
                                                               id="address"
                                                               placeholder=""
                                                               value="{{$user['address']}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="iban" class="form-label">شماره شبا</label>
                                                        <input type="text" name="iban" class="form-control" id="iban"
                                                               placeholder=""
                                                               value="{{$user['iban']}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="credit_card_number" class="form-label">شماره کارت</label>
                                                        <input type="text" name="credit_card_number"
                                                               class="form-control" id="credit_card_number"
                                                               placeholder=""
                                                               value="{{$user['credit_card_number']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div>
                                                    <img style="width:150px;height:50px" class="d-block"
                                                         src="{{$builder->inline()}}"/>
                                                </div>
                                                <div class="mb-3 col-md-6 d-block">
                                                    <label for="captcha" class="form-label">کپچا <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" name="captcha" class="form-control " id="captcha"
                                                           placeholder="کپچا" pattern="(?=.*\d).{5,}"
                                                           required>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-start">
                                                        <button type="submit" class="btn btn-primary ">ویرایش</button>

                                                    </div>
                                                </div>

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
    </div>
@endsection

@section("script")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>

    <script>

        @if($_REQUEST['error'])
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>درخواست شما با خطا مواجه شد!</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "فهمیدم",
            buttonsStyling: !1,
            showCloseButton: !0
        })

        @endif

        @if($_REQUEST['success'])
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>درخواست شما با موفقیت انجام شد.!</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "فهمیدم",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then(function (t) {
            window.location.href = "{{baseUrl(httpCheck()).substr($_SERVER['REQUEST_URI'],1,strpos($_SERVER['REQUEST_URI'],"?")-1)}}";
        })

        @endif

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preloadImageShow').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#profile-img-file-input").change(function () {
            readURL(this);
        });
    </script>
@endsection


