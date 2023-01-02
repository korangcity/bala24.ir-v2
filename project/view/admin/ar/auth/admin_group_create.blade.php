@extends("admin.ar.layout.app")



@section("head")
    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <style>
        .select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #5ea3cb !important;
            border: none !important;
            color: #fff !important;
            border-radius: 3px !important;
            padding: 3px !important;
            margin-top: 6px !important;
        }

        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 7px !important;
            border-color: #6eacd0 !important;
            padding: 0 8px !important;
            top: 3px !important;
        }

        .select2-container .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #fff !important;
            background-color: #5ea3cb !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            padding-left: 36px !important;
            padding-right: 5px !important;
        }
    </style>
@endsection

@section("content")

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">مستوى وصول المسؤول</h4>
                            </div>

                            <div class="card-body">
                                <div class="live-preview">
                                    @if (!empty(getErrors()))
                                        <div class="alert alert-danger col-md-6 col-sm-12">
                                            <ul>
                                                @foreach (getErrors() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <h4>حدد مجموعة وصول المسؤول المسماة {{$user_name}}</h4>
                                    <form action="/adminpanel/Auth-applyAccessLevelProcess" method="post"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="user_id" value="{{$user_id}}">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body col-lg-7">
                                                        <div class="vstack gap-3">
                                                            <label for="permission" class="form-label"> مجموعة <span
                                                                        class="text-danger">*</span></label>
                                                            <div class="vstack gap-3">
                                                                <select class="js-example-disabled"
                                                                        name="group">
                                                                    <option value="">يختار</option>
                                                                    @foreach($groups as $key=>$group)
                                                                        <option value="{{$group['id']}}" {{(in_array($group['id'],old("group"))?"selected":'')}}>{{$group['title']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-8 mt-3">
                                                            <img src="{{$builder->inline()}}"/>
                                                            <div class="mb-3">
                                                                <label for="captcha" class="form-label">كلمة التحقق <span
                                                                            class="text-danger">*</span></label>
                                                                <input type="text" name="captcha" class="form-control" id="captcha"
                                                                       placeholder="كلمة التحقق" pattern="(?=.*\d).{5,}"
                                                                       required>

                                                            </div>
                                                        </div>

                                                        <div class="row">



                                                            <div class="col-lg-12">
                                                                <div class="text-start">
                                                                    <button type="submit" class="btn btn-primary">إرسال</button>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
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

@endsection

@section("script")

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/prismjs/prism.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{--    <script src="{{baseUrl(httpCheck())}}assets/js/pages/select2.init.js"></script>--}}
    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>


    <script>
        $(".js-example-disabled").select2();

        @if($_REQUEST['error'])
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>واجه طلبك خطأ.</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "فهمت",
            buttonsStyling: !1,
            showCloseButton: !0
        })

        @endif
    </script>


@endsection
