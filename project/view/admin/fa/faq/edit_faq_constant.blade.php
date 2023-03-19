@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | ویرایش اطلاعات ثابت faq")


@section("head")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"> اطلاعات ثابت faq</h4>
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
                                    <form action="/adminpanel/FAQ-editFaConstantProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="faq_constant_id" value="{{$faq_constant["id"]}}">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{$faq_constant["title"]}}"
                                                           class="form-control"
                                                           placeholder="عنوان " id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="brief_description" class="form-label">توضیح مختصر
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="brief_description" id="brief_description"
                                                              value="" id="" cols="30"
                                                              rows="5"
                                                              class="form-control">{{$faq_constant["brief_description"]}}</textarea>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="first_link_title" class="form-label">عنوان لینک اول
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_link_title" value="{{$faq_constant["first_link_title"]}}"
                                                           class="form-control"
                                                           placeholder="عنوان لینک اول" id="first_link_title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="first_link_icon" class="form-label">آیکن لینک اول
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_link_icon" value="{{$faq_constant["first_link_icon"]}}"
                                                           class="form-control"
                                                           placeholder="آیکن لینک اول" id="first_link_icon">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="first_link" class="form-label"> لینک اول
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="first_link" value="{{$faq_constant["first_link"]}}"
                                                           class="form-control"
                                                           placeholder=" لینک اول" id="first_link">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="second_link_title" class="form-label"> عنوان لینک دوم
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="second_link_title" value="{{$faq_constant["second_link_title"]}}"
                                                           class="form-control"
                                                           placeholder="عنوان لینک دوم" id="second_link_title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="second_link_icon" class="form-label"> آیکن لینک دوم
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="second_link_icon" value="{{$faq_constant["second_link_icon"]}}"
                                                           class="form-control"
                                                           placeholder="آیکن لینک دوم" id="second_link_icon">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="second_link" class="form-label">  لینک دوم
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="second_link" value="{{$faq_constant["second_link"]}}"
                                                           class="form-control"
                                                           placeholder=" لینک دوم" id="second_link">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="text-start">
                                                    <button type="submit" class="btn btn-primary">ثبت</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/select2.init.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.2/full-all/ckeditor.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/prismjs/prism.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>

    <script>


        @if($_REQUEST['error'])
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>درخواست شما با خطا مواجه شد</h4>' +
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

    </script>
@endsection
