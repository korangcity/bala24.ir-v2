@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | تنظیمات")


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
                                <h4 class="card-title mb-0 flex-grow-1"> تنظیمات</h4>
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
                                    <form action="/adminpanel/Setting-createGeneralInformationProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">


                                        <div class="row">
                                            <h4>شبکه های اجتماعی</h4>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="telegram" class="form-label">Telegram
                                                        </label>
                                                    <input type="text" name="telegram" value="{{old('telegram')??''}}"
                                                           class="form-control"
                                                           placeholder="Telegram" id="telegram">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="instagram" class="form-label">Instagram
                                                        </label>
                                                    <input type="text" name="instagram" value="{{old('instagram')??''}}"
                                                           class="form-control"
                                                           placeholder="Instagram" id="instagram">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="whatsapp" class="form-label">WhatsApp
                                                        </label>
                                                    <input type="text" name="whatsapp" value="{{old('whatsapp')??''}}"
                                                           class="form-control"
                                                           placeholder="WhatsApp" id="whatsapp">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="linkedin" class="form-label">LinkedIn
                                                        </label>
                                                    <input type="text" name="linkedin" value="{{old('linkedin')??''}}"
                                                           class="form-control"
                                                           placeholder="LinkedIn" id="linkedin">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email
                                                        </label>
                                                    <input type="text" name="email" value="{{old('email')??''}}"
                                                           class="form-control"
                                                           placeholder="Email" id="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone1" class="form-label">Phone1
                                                        </label>
                                                    <input type="text" name="phone1" value="{{old('phone1')??''}}"
                                                           class="form-control"
                                                           placeholder="Phone1" id="phone1">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone2" class="form-label">Phone2
                                                        </label>
                                                    <input type="text" name="phone2" value="{{old('phone2')??''}}"
                                                           class="form-control"
                                                           placeholder="Phone2" id="phone2">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone3" class="form-label">Phone3
                                                        </label>
                                                    <input type="text" name="phone3" value="{{old('phone3')??''}}"
                                                           class="form-control"
                                                           placeholder="Phone3" id="phone3">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">آدرس
                                                        </label>
                                                    <input type="text" name="address" value="{{old('address')??''}}"
                                                           class="form-control"
                                                           placeholder="address" id="address">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <h4>موقعیت</h4>
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">Location
                                                       </label>
                                                    <input type="text" name="location" value="{{old('location')??''}}"
                                                           class="form-control"
                                                           placeholder="Location from Google Map" id="location">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">لوگوی سایت (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class=" resultAddImage">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="logo">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="logoAlt"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">

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

        CKEDITOR.addCss('figure[class*=easyimage-gradient]::before { content: ""; position: absolute; top: 0; bottom: 0; left: 0; right: 0; }' +
            'figure[class*=easyimage-gradient] figcaption { position: relative; z-index: 2; }' +
            '.easyimage-gradient-1::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 66, 174, 234, .72 ) 100% ); }' +
            '.easyimage-gradient-2::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 228, 66, 234, .72 ) 100% ); }');

        CKEDITOR.replace('editor', {
            extraPlugins: 'image2,uploadimage',
            removePlugins: 'image',
            language: 'fa',
            editorplaceholder: 'متن خود را اینجا درج نمایید',
            filebrowserUploadUrl: "/adminpanel/Setting-uploadCkeditorFile",
            filebrowserUploadMethod: 'form'

        });


        $(".addImage").click(function () {
            $(".resultAddImage").append('<div class="d-flex"><div class="col-lg-6">' +
                '<input type="file" class="form-control mb-2" name="pageImages[]">' +
                '</div> <div class="col-lg-6">' +
                '<input type="text" placeholder="مقدار alt تصویر را وارد کنید" class="form-control mb-2" name="pageImageAlts[]">' +
                '</div></div>');
        });

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
