@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | ایجاد سابپلن")


@section("head")
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
                                <h4 class="card-title mb-0 flex-grow-1"> سابپلن</h4>
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
                                    <form action="/adminpanel/Plan-createPlanFeatureProcess" method="post"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="plan" class="form-label">پلن مورد نظر را انتخاب
                                                        کنید<span class="text-danger">*</span></label>
                                                    <select name="plan" id="plan" class="form-control plansInfo">
                                                        <option value="">انتخاب کنید</option>
                                                        @foreach($plans as $key=>$plan)
                                                            <option value="{{$plan['id']}}" {{old("plan")==$plan['id']?"selected":""}}>{{$plan['title']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-md-6">--}}
                                            {{--                                                <div class="mb-3">--}}
                                            {{--                                                    <label for="time_period" class="form-label">دوره زمانی مورد نظر را انتخاب--}}
                                            {{--                                                        کنید<span class="text-danger">*</span></label>--}}
                                            {{--                                                    <select name="time_period" id="time_period " class="form-control InsertResultt">--}}

                                            {{--                                                    </select>--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{old('title')??''}}"
                                                           class="form-control"
                                                           placeholder="" id="title">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="brief_description" class="form-label">توضیح
                                                        مختصر </label>
                                                    <textarea name="brief_description" class="form-control"
                                                              id="brief_description" cols="30"
                                                              rows="10">{{old('brief_description')??''}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="icon" class="form-label">آیکن </label>
                                                    <input type="text" name="icon" value="{{old('icon')??''}}"
                                                           class="form-control"
                                                           placeholder="کد آیکن " id="icon">
                                                </div>
                                            </div>

                                            {{--                                            <div class="col-md-6">--}}
                                            {{--                                                <div class="mb-3">--}}
                                            {{--                                                    <label for="price" class="form-label">قیمت </label>--}}
                                            {{--                                                    <input type="text" name="price" id="price" class="form-control"--}}
                                            {{--                                                           value="{{old("price")??''}}">--}}
                                            {{--                                                </div>--}}
                                            {{--                                            </div>--}}

                                            <div class="row positiveResult">
                                                @if(!empty(old('positive_features')))
                                                    @foreach(old('positive_features') as $key=>$feature)
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <div class="mb-3">
                                                                        <label for="positive_features"
                                                                               class="form-label">@if($key==0)
                                                                                ویژگی های مثبت
                                                                            @endif </label>
                                                                        <input type="text" name="positive_features[]"
                                                                               id="positive_features"
                                                                               placeholder="ویژگی مثبت"
                                                                               class="form-control"
                                                                               value="{{$feature}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="mt-4 deleteItemsibling">
                                                                        <i class="ri-close-circle-fill fs-36 text-danger"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <div class="mb-3">
                                                                    <label for="positive_features" class="form-label">
                                                                        ویژگی های
                                                                        مثبت </label>
                                                                    <input type="text" name="positive_features[]"
                                                                           id="positive_features"
                                                                           placeholder="ویژگی مثبت"
                                                                           class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="mt-4 deleteItemsibling">
                                                                    <i class="ri-close-circle-fill fs-36 text-danger"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <button type="button" class="btn btn-info btn-sm addPositive">افزودن
                                                        ویژگی مثبت
                                                        جدید
                                                    </button>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row negativeResult">
                                                @if(!empty(old('negative_features')))
                                                    @foreach(old('negative_features') as $ke=>$featur)
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                            <div class="mb-3">
                                                                <label for="negative_features"
                                                                       class="form-label">@if($ke==0)
                                                                        ویژگی های منفی
                                                                    @endif</label>
                                                                <input type="text" name="negative_features[]"
                                                                       id="negative_features" placeholder="ویژگی منفی"
                                                                       class="form-control" value="{{$featur}}">
                                                            </div>
                                                        </div>
                                                                <div class="col-md-2">
                                                                    <div class="mt-4 deleteItemsibling">
                                                                        <i class="ri-close-circle-fill fs-36 text-danger"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                        <div class="mb-3">
                                                            <label for="negative_features" class="form-label">ویژگی های
                                                                منفی </label>
                                                            <input type="text" name="negative_features[]"
                                                                   id="negative_features" placeholder="ویژگی منفی"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                            <div class="col-md-2">
                                                                <div class="mt-4 deleteItemsibling">
                                                                    <i class="ri-close-circle-fill fs-36 text-danger"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <button type="button" class="btn btn-danger btn-sm addNegative">
                                                        افزودن ویژگی منفی
                                                        جدید
                                                    </button>
                                                </div>
                                            </div>


                                        </div>

                                        <br>
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="text-start">
                                                    <button type="submit" class="btn btn-success">ثبت</button>
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


        $(".plansInfo").change(function () {

            let plan_id = $(this).val();
            $.ajax({
                type: 'post',
                url: "/adminpanel/Plan-getPlanTimePeriods",
                data: {plan_id: plan_id},
                success: function (response) {
                    $(".InsertResultt").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".addPositive").click(function () {
            $(".positiveResult").append('<div class="col-md-6"><div class="row"><div class="col-md-9">' +
                '<div class="mb-3">' +
                '<label for="" class="form-label"> </label>' +
                '<input type="text" name="positive_features[]" id="" placeholder="ویژگی مثبت" class="form-control">' +
                '</div></div><div class="col-md-2">'+
                '<div class="mt-4 deleteItemsibling">'+
                '<i class="ri-close-circle-fill fs-36 text-danger"></i>'+
                '</div></div></div></div>');

            $(".deleteItemsibling").click(function () {
                $(this).parent().parent().remove();
            });

        });

        $(".addNegative").click(function () {
            $(".negativeResult").append('<div class="col-md-6"><div class="row"><div class="col-md-9">' +
                '<div class="mb-3">' +
                '<label for="" class="form-label"> </label>' +
                '<input type="text" name="negative_features[]" id="" placeholder="ویژگی منفی" class="form-control">' +
                '</div></div><div class="col-md-2">'+
                '<div class="mt-4 deleteItemsibling">'+
                '<i class="ri-close-circle-fill fs-36 text-danger"></i>'+
                '</div></div></div></div>');

            $(".deleteItemsibling").click(function () {
                $(this).parent().parent().remove();
            });
        });

        $(".deleteItemsibling").click(function () {
            $(this).parent().parent().remove();
        });
    </script>
@endsection
