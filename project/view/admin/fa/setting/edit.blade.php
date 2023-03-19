@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | ویرایش تنظیمات")


@section("head")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-12">
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
                                    <form action="/adminpanel/Setting-editGeneralInformationProcess" method="post"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="setting_id" value="{{$setting["id"]}}">

                                        <div class="row">
                                            <h4>شبکه های اجتماعی</h4>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="telegram" class="form-label">Telegram
                                                    </label>
                                                    <input type="text" name="telegram"
                                                           value="{{$setting['telegram']??''}}"
                                                           class="form-control"
                                                           placeholder="Telegram" id="telegram">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="instagram" class="form-label">Instagram
                                                    </label>
                                                    <input type="text" name="instagram"
                                                           value="{{$setting['instagram']??''}}"
                                                           class="form-control"
                                                           placeholder="Instagram" id="instagram">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="whatsapp" class="form-label">WhatsApp
                                                    </label>
                                                    <input type="text" name="whatsapp"
                                                           value="{{$setting['whatsapp']??''}}"
                                                           class="form-control"
                                                           placeholder="WhatsApp" id="whatsapp">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="linkedin" class="form-label">LinkedIn
                                                    </label>
                                                    <input type="text" name="linkedin"
                                                           value="{{$setting['linkedin']??''}}"
                                                           class="form-control"
                                                           placeholder="LinkedIn" id="linkedin">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email
                                                    </label>
                                                    <input type="text" name="email" value="{{$setting['email']??''}}"
                                                           class="form-control"
                                                           placeholder="Email" id="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone1" class="form-label">Phone1
                                                    </label>
                                                    <input type="text" name="phone1" value="{{$setting['phone1']??''}}"
                                                           class="form-control"
                                                           placeholder="Phone1" id="phone1">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone2" class="form-label">Phone2
                                                    </label>
                                                    <input type="text" name="phone2" value="{{$setting['phone2']??''}}"
                                                           class="form-control"
                                                           placeholder="Phone2" id="phone2">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone3" class="form-label">Phone3
                                                    </label>
                                                    <input type="text" name="phone3" value="{{$setting['phone3']??''}}"
                                                           class="form-control"
                                                           placeholder="Phone3" id="phone3">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">آدرس
                                                    </label>
                                                    <input type="text" name="address"
                                                           value="{{$setting['address']??''}}"
                                                           class="form-control"
                                                           placeholder="address" id="address">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="footer_aboutus_title" class="form-label">عنوان درباره ما در فوتر
                                                    </label>
                                                    <input type="text" name="footer_aboutus_title"
                                                           value="{{$setting['footer_aboutus_title']??''}}"
                                                           class="form-control"
                                                           placeholder="" id="footer_aboutus_title">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="footer_aboutus" class="form-label">درباره ما در فوتر
                                                    </label>
                                                    <textarea name="footer_aboutus" id="footer_aboutus" cols="30" rows="4"
                                                              class="form-control">{{$setting['footer_aboutus']??''}}</textarea>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <h4>موقعیت</h4>
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">Location
                                                    </label>
                                                    <input type="text" name="location"
                                                           value="{{$setting['location']??''}}"
                                                           class="form-control"
                                                           placeholder="Location from Google Map" id="location">
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <h4 class="text-danger">برای لوگوها، هر قسمت به طور مجزا قابلیت ویرایش دارد به
                                            عنوان مثال، اگر فقط عکس لوگوی تاریک بزرگ را تغییر دهید بدون اینکه مقدار alt
                                            عکس مورد نظر را تغییر دهید، هیچ مشکلی پیش نخواهد آمد و درست عمل خواهد
                                            کرد </h4>
                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">تصویر لوگو تاریک بزرگ (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class="">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="largeLogoDark">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="largeLogoDarkAlt"
                                                                   value="{{$setting['large_logo_dark_alt']??''}}"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">تصویر لوگو تاریک کوچیک (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class="">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="smallLogoDark">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="smallLogoDarkAlt"
                                                                   value="{{$setting['small_logo_dark_alt']??''}}"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">تصویر لوگو روشن بزرگ (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class="">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="largeLogoLight">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="largLogoLightAlt"
                                                                   value="{{$setting['large_logo_light_alt']??''}}"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">تصویر لوگو روشن کوچیک (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class="">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="smallLogoLight">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="smallLogoLightAlt"
                                                                   value="{{$setting['small_logo_light_alt']??''}}"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br><br>
                                        <div class="row">

                                            <h4>عناوین صفحه اصلی</h4>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_service_title" class="form-label">عنوان سرویس
                                                    </label>
                                                    <input type="text" name="index_service_title"
                                                           value="{{$setting['index_service_title']??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_service_title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_service_description" class="form-label">توضیح مختصر سرویس
                                                    </label>
                                                    <textarea class="form-control" name="index_service_description" id="index_service_description" cols="30" rows="5">{{$setting['index_service_description']??''}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_company_title" class="form-label">عنوان قسمت شرکت ها
                                                    </label>
                                                    <input type="text" name="index_company_title"
                                                           value="{{$setting['index_company_title']??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_company_title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_satisfy_title" class="form-label">عنوان قسمت رضایتمندی کاربران
                                                    </label>
                                                    <input type="text" name="index_satisfy_title"
                                                           value="{{$setting['index_satisfy_title']??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_satisfy_title">
                                                </div>
                                            </div>

                                            <br>

                                            <br>
                                            <hr style="border: none;height: 5px;background-color: #ff0000; ">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_titles1" class="form-label">عنوان اول عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_titles1"
                                                           value="{{json_decode($setting['index_functionality_titles'])[0]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_titles1">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_values1" class="form-label">مقدار اول عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_values1"
                                                           value="{{json_decode($setting['index_functionality_values'])[0]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_values1">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_titles2" class="form-label">عنوان دوم عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_titles2"
                                                           value="{{json_decode($setting['index_functionality_titles'])[1]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_titles2">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_values2" class="form-label">مقدار دوم عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_values2"
                                                           value="{{json_decode($setting['index_functionality_values'])[1]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_values2">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_titles3" class="form-label">عنوان سوم عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_titles3"
                                                           value="{{json_decode($setting['index_functionality_titles'])[2]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_titles3">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_values3" class="form-label">مقدار سوم عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_values3"
                                                           value="{{json_decode($setting['index_functionality_values'])[3]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_values3">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_titles4" class="form-label">عنوان چهارم عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_titles4"
                                                           value="{{json_decode($setting['index_functionality_titles'])[3]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_titles4">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="index_functionality_values4" class="form-label">مقدار چهارم عملکرد سال
                                                    </label>
                                                    <input type="text" name="index_functionality_values4"
                                                           value="{{json_decode($setting['index_functionality_values'])[3]??''}}"
                                                           class="form-control"
                                                           placeholder="" id="index_functionality_values4">
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


        $(".deleteImg").click(function () {
            let setting_id = "{{$setting['id']}}";
            let chk = confirm("از حذف تصویر مورد نظر مطمئن هستید؟");
            if (chk) {
                $.ajax({
                    type: 'post',
                    url: '/adminpanel/Setting-settingDeleteImage',
                    data: {setting_id: setting_id},
                    success: function (response) {
                        window.location.href = "/adminpanel/Setting-GeneralInformationList"
                    },
                    error: function () {
                        alert("oops")
                    }
                });
            }
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
