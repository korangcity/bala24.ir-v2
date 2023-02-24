@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | ویرایش زمان پلن")


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
                                <h4 class="card-title mb-0 flex-grow-1">زمان پلن</h4>
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
                                    <form action="/adminpanel/Plan-editPlanTimeProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="time_id" value="{{$time['id']}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="time_period" class="form-label">دوره زمانی  <span class="text-danger">*</span></label>
                                                    <select name="time_period" id="time_period" class="form-control">
                                                        <option value="">انتخاب کنید</option>
                                                        <option value="1" {{$time["period"]=="1"?"selected":""}}>ساعتی</option>
                                                        <option value="2" {{$time["period"]=="2"?"selected":""}}>روزانه</option>
                                                        <option value="3" {{$time["period"]=="3"?"selected":""}}>ماهیانه</option>
                                                        <option value="4" {{$time["period"]=="4"?"selected":""}}>سالیانه</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان  <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{$time['title']??''}}" class="form-control"
                                                           placeholder="مثال : دو ماهه" id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title_value" class="form-label">مقدار عنوان  <span class="text-danger">*</span></label>
                                                    <p class="text-danger">مقدار عنوان به این مفهوم است که اگر در قسمت قبل عنوان را دوماهه در نظر گرفته اید، مقدار عنوان عدد 2 خواهد بود یا اگر عنوان شش ساعته باشد مقدار عنوان عدد 6 خواهد بود</p>
                                                    <input type="text" name="title_value" value="{{$time['value']??''}}" class="form-control"
                                                           placeholder="مثال : 2" id="title_value">
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
