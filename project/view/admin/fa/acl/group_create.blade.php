@extends("admin.fa.layout.app")



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
                                <h4 class="card-title mb-0 flex-grow-1">ایجاد گروه</h4>
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
                                    @php
                                        $colors=["","form-check-secondary","form-check-success","form-check-warning","form-check-danger","form-check-info","form-check-dark"];

                                    @endphp
                                    <form action="/adminpanel/Acl-createGroupProcess" method="post"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان گروه <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{old('title')??''}}"
                                                           class="form-control"
                                                           placeholder="عنوان " id="title">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="card-body">
                                                    <div class="live-preview">
                                                        <div class="row">
                                                            <div class="col-md-3 mt-3 border-bottom">
                                                                <div>

                                                                    <h5>زبان یا زبان های مد نظر را انتخاب کنید</h5>
                                                                    <div class="form-check {{$colors[array_rand($colors)]}} mb-3">
                                                                        <input class="form-check-input permission"
                                                                               type="checkbox" name="english"
                                                                               id="english"
                                                                        >
                                                                        <label class="form-check-label"
                                                                               for="english">
                                                                            English
                                                                        </label>
                                                                    </div>

                                                                    <div class="form-check {{$colors[array_rand($colors)]}} mb-3">
                                                                        <input class="form-check-input permission"
                                                                               type="checkbox" name="farsi"
                                                                               id="farsi"
                                                                        >
                                                                        <label class="form-check-label"
                                                                               for="farsi">
                                                                            فارسی
                                                                        </label>
                                                                    </div>

                                                                    <div class="form-check {{$colors[array_rand($colors)]}} mb-3">
                                                                        <input class="form-check-input permission"
                                                                               type="checkbox"
                                                                               id="arabic" name="arabic"
                                                                        >
                                                                        <label class="form-check-label"
                                                                               for="arabic">
                                                                            العربیه
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5>با انتخاب نقش مورد نظر، دسترسی های مربوطه را انتخاب نمایید</h5>
                                            <div class="card-body">
                                                <div class="live-preview">
                                                    <div class="row">

                                                        @foreach($roles as $roleKey=>$role)
                                                            <div class="col-md-3 mt-3 border-bottom">
                                                                <div>
                                                                    <div class="form-check {{$colors[array_rand($colors)]}} mb-3">
                                                                        <input class="form-check-input role"
                                                                               type="checkbox"
                                                                               name="role{{($roleKey+1)}}"
                                                                               id="role{{$roleKey}}"
                                                                               data-id="{{$role['id']}}">
                                                                        <h2 class=""><label
                                                                                    class="form-check-label border-bottom"
                                                                                    for="role{{$roleKey}}">
                                                                                {{$role['title']}}
                                                                            </label>
                                                                        </h2>
                                                                    </div>
                                                                    @php $counter=0; @endphp
                                                                    @foreach($permissions as $permKey=>$permission)

                                                                        @if($permission['roleId']==$role['id'])
                                                                            <div class="form-check {{$colors[array_rand($colors)]}} mb-3">
                                                                                <input class="form-check-input permission"
                                                                                       type="checkbox"
                                                                                       name="permission{{($permission['permissionId'])}}"
                                                                                       data-id="{{$permission['permissionId']}}"
                                                                                       id="per{{$roleKey.$permKey}}"
                                                                                       disabled>
                                                                                <label class="form-check-label"
                                                                                       for="per{{$roleKey.$permKey}}">
                                                                                    {{$permission['permissionTitle']}}
                                                                                </label>
                                                                            </div>
                                                                            @php $counter++; @endphp
                                                                        @endif

                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
{{--                                            <div class="">--}}

{{--                                                <img src="{{$builder->inline()}}"/>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-md-4 col-sm-8 mb-3">--}}
{{--                                                    <label for="captcha" class="form-label">کپچا</label>--}}
{{--                                                    <input type="text" name="captcha" class="form-control"--}}
{{--                                                           placeholder="کپچا را وارد کنید" id="captcha">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

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
    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/prismjs/prism.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>


    <script>

        $(".role").click(function (e) {

            if ($(this).is(":checked")) {
                $(this).parent().siblings().children(".permission").attr("disabled", false);
            } else {
                $(this).parent().siblings().children(".permission").attr("disabled", true);
                $(this).parent().siblings().children(".permission").prop( "checked", false );
            }
        });
    </script>
@endsection
