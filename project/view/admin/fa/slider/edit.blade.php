@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | ویرایش اسلایدر")


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
                                <h4 class="card-title mb-0 flex-grow-1">اسلایدر</h4>
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
                                    <form action="/adminpanel/Slider-editSliderProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">

                                        <div class="row">

                                            <div class="col-6">
                                                <label for="title" class="form-label">عنوان
                                                </label>
                                                <input type="text" value="{{$slider["title"]??''}}" name="title" id="title" class="form-control">
                                            </div>

                                            <div class="col-6">
                                                <label for="description" class="form-label">توضیح مختصر
                                                </label>
                                                <textarea name="description" class="form-control" id="description" cols="30" rows="3">{{$slider["description"]??''}}</textarea>
                                            </div>

                                            <div class="col-6">
                                                <label for="first_link_title" class="form-label">عنوان لینک اول
                                                </label>
                                                <input type="text" value="{{$slider["first_link_title"]??''}}" name="first_link_title" id="first_link_title" class="form-control">
                                            </div>

                                            <div class="col-6">
                                                <label for="first_link" class="form-label"> لینک اول
                                                </label>
                                                <input type="text" value="{{$slider["first_link"]??''}}" name="first_link" id="first_link" class="form-control">
                                            </div>

                                            <div class="col-6">
                                                <label for="second_link_title" class="form-label">عنوان لینک دوم
                                                </label>
                                                <input type="text" value="{{$slider["second_link_title"]??''}}" name="second_link_title" id="second_link_title" class="form-control">
                                            </div>

                                            <div class="col-6">
                                                <label for="second_link" class="form-label"> لینک دوم
                                                </label>
                                                <input type="text" value="{{$slider["second_link"]??''}}" name="second_link" id="second_link" class="form-control">
                                            </div>

                                        </div>

                                        <div class="row">
                                            @foreach(json_decode($slider["images"]) as $key=>$image)
                                                <div class="col-4">
                                                    <img src="{{baseUrl(httpCheck()).$image}}" class="img-thumbnail d-block" alt="">
                                                    <input type="text" class="form-control d-block mx-auto mt-2" name="" value="{{json_decode($slider["alts"])[$key]}}" disabled id="">
                                                    <button type="button" class="btn btn-outline-danger btn-sm deleteImg d-block mx-auto mt-2" data-key="{{$key+1}}">حذف</button>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">تصویر (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class=" resultAddImage">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="sliderImages[]">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="sliderImageAlts[]"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-2 mt-2">
                                                        <button type="button" class="btn btn-info addImage">افزودن تصویر دیگر
                                                        </button>
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


        $(".addImage").click(function () {
            $(".resultAddImage").append('<div class="d-flex"><div class="col-lg-6">' +
                '<input type="file" class="form-control mb-2" name="sliderImages[]">' +
                '</div> <div class="col-lg-6">' +
                '<input type="text" placeholder="مقدار alt تصویر را وارد کنید" class="form-control mb-2" name="sliderImageAlts[]">' +
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

        $(".deleteImg").click(function(){
            let image_no=$(this).data('key');
            let chk=confirm("از حذف تصویر مورد نظر مطمئن هستید؟");
            if(chk){
                $.ajax({
                    type:'post',
                    url:'/adminpanel/Slider-sliderDeleteImage',
                    data:{image_no:image_no},
                    success:function(response){
                        window.location.href="/adminpanel/Slider-sliderEdit-1"
                    },
                    error:function(){
                        alert("oops")
                    }
                });
            }
        });
    </script>
@endsection
