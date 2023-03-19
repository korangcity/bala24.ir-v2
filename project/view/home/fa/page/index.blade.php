@extends("home.fa.landing_layout.app")

@section('head')

    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection

@if($page)
    @section("title",$page['page_title_seo'])
    @section("description",$page['page_description_seo'])
    @section("keywords",$page['page_keywords_seo'])
    @section("ogTitle",$page['page_og_title_seo'])
    @section("ogDescription",$page['page_og_description_seo'])
    @section("ogType",$page['page_og_type_seo'])
    @section("ogImage",baseUrl(httpCheck()).$page['page_og_image_seo'])

@endif

@section("content")

    @if($main_url=="contactus")
        <section class="section" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">ارتباط با ما</h3>
                            <p class="text-muted mb-4 ">برای ارتباط با ما از روش های زیر استفاده کنید</p>
                        </div>
                    </div>
                </div>


                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div>
                            @if($setting['address'])
                                <div class="mt-4">
                                    <h5 class="fs-13 text-muted text-uppercase">آدرس :</h5>
                                    <div class="">{{$setting['address']}}</div>
                                </div>
                            @endif
                            @if($setting['phone1'] or $setting['phone2'] or $setting['phone3'])
                                <div class="mt-4">
                                    <h5 class="fs-13 text-muted text-uppercase">شماره تلفن : </h5>
                                    @if($setting['phone1'])
                                        <div class="">{{$setting['phone1']}}</div>
                                    @endif
                                    @if($setting['phone2'])
                                        <div class="">{{$setting['phone2']}}</div>
                                    @endif
                                    @if($setting['phone3'])
                                        <div class="">{{$setting['phone3']}}</div>
                                    @endif

                                </div>
                            @endif
                            @if($setting['email'])
                                <div class="mt-4">
                                    <h5 class="fs-13 text-muted text-uppercase">ایمیل : </h5>
                                    <div class="">{{$setting['email']}}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-8">
                        <div>
                            @if (!empty(getErrors()))
                                <div class="alert alert-danger col-md-12 col-sm-12">
                                    <ul>
                                        @foreach (getErrors() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post"
                                  action="{{htmlspecialchars(substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],'?')))}}">

                                <input type="hidden" name="token" value="{{$token}}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="name" class="form-label fs-13">نام و نام خانوادگی<span
                                                        class="text-danger">*</span></label>
                                            <input name="name" value="{{old('name')??''}}" id="name" type="text"
                                                   class="form-control  border-light"
                                                   placeholder="نام و نام خانوادگی">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="email" class="form-label fs-13">ایمیل<span
                                                        class="text-danger">*</span></label>
                                            <input name="email" id="email" type="email" value="{{old('email')??''}}"
                                                   class="form-control  border-light" placeholder="ایمیل">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label for="subject" class="form-label fs-13">موضوع<span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control  border-light" id="subject"
                                                   name="subject" placeholder="موضوع" value="{{old('subject')??''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="comments" class="form-label fs-13">پیام<span
                                                        class="text-danger">*</span></label>
                                            <textarea name="message" id="comments" rows="3"
                                                      class="form-control  border-light"
                                                      placeholder="پیام خود را اینجا درج نمایید">{{old('message')??''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="">

                                    <img src="{{$builder->inline()}}"/><span class="text-danger">*</span>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <input type="text" name="captcha" class="form-control  border-light"
                                                   placeholder="کد تصویر را وارد کنید" id="captcha">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-end">
                                        <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary"
                                               value="ارسال پیام">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    @endif

    <div class=" section bg-light">
        <div class="container">
            <div>
                {{$page['brief_description']}}
            </div>
            <div>

                {!! html_entity_decode($page['description']) !!}
            </div>



        </div>
    </div>

    @if($plan)
        <section class="section " id="plans">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">{{$plan['title']??''}}</h3>
                            <p class="text-muted mb-4">{{$plan['brief_description']??''}}</p>

                            <div class="d-flex justify-content-center align-items-center">
                                @php $firsKey=0; @endphp
                                @foreach(json_decode($plan['time_period']) as $kee=>$time)
                                    <div class="col-md-4">
                                        <div class="form-check form-radio-outline form-radio-primary mb-3 changeTimePeriod"
                                             data-id="{{$time}}">
                                            <input class="form-check-input timee" type="radio" name="time"
                                                   id="formradioRight{{$kee}}" @if($kee==0) checked @endif>
                                            <label class="form-check-label" for="formradioRight{{$kee}}">
                                                @foreach($time_periods as $time_period)
                                                    @if($time_period['id']==$time)
                                                        {{$time_period['title']}}
                                                        @if($kee==0)
                                                            @php $firsKey=$time_period['id']; @endphp
                                                        @endif
                                                    @endif
                                                @endforeach

                                            </label>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row gy-4">


                    @foreach($subPlans as $key=>$subPlan)

                        @php

                            $planFeaturePrices=$service_obj->getPlanFeaturePrices($subPlan['id']);

                        @endphp
                        <div class="col-lg-4 d-flex">
                            <div class="card plan-box mb-0 ribbon-box right">
                                <div class="card-body flex-column p-4 m-2">

                                    <div class="ribbon-two ribbon-two-danger d-none showParticular"><span>ویژه</span>
                                    </div>


                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 fw-semibold">{{$subPlan['title']}}</h5>
                                            <p class="text-muted mb-0">{{$subPlan['brief_description']}}</p>
                                        </div>
                                        <div class="avatar-sm">
                                            <div class="avatar-title bg-light rounded-circle text-primary">
                                                <i class="{{$subPlan['icon']}} fs-20"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-4 text-center">
                                        @foreach($planFeaturePrices as $price)
                                            <h1 data-timeid="{{$price['time_period_id']}}"
                                                data-particular="{{$price['particular']}}"
                                                class="month showPricee @if($firsKey!=$price['time_period_id']) d-none @else d-block @endif">
                                                <span class=" fw-bold">{{$price['price']?number_format($price['price']):0}}</span><sup><small>تومان</small></sup><br>
                                                <span class="fs-13 text-muted">/@php foreach($time_periods as $time_periodd): if($time_periodd['id']==$price['time_period_id']):  echo $time_periodd['title'];  endif; endforeach;  @endphp</span>
                                            </h1>

                                        @endforeach

                                    </div>

                                    <div>
                                        <ul class="list-unstyled text-muted vstack gap-3 ">
                                            @foreach(json_decode($subPlan['positive_features']) as $item)
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 text-success me-1">
                                                            <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            {{$item}}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach

                                            @foreach(json_decode($subPlan['negative_features']) as $vall)
                                                <li>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 text-danger me-1">
                                                            <i class="ri-close-circle-fill fs-15 align-middle"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            {{$vall}}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="mt-4">
                                            <a href="javascript:void(0);" class="btn btn-soft-success  w-100">شروع
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!--end col-->

                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!-- end container -->
        </section>
    @endif

    @if($video)
        <section class="section" >
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 col-sm-7 col-10 mx-auto">
                        <div>

                            @if($video['video'] == strip_tags($video['video']))
                                <video width="100%"  poster="{{baseUrl(httpCheck()).$video['poster']}}" controls>
                                    <source src="{{baseUrl(httpCheck()).$video['video']}}" type="video/mp4">
                                </video>

                            @else
                                {!! html_entity_decode($video['video']) !!}
                            @endif


                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-muted ps-lg-5">
                            <h5 class="fs-12 text-uppercase text-success">{{$serviceCategory}}</h5>
                            <h4 class="mb-3">{{$video['title']}}</h4>
                            <p class="mb-4">{{$video['brief_description']}}</p>

                            <div class="vstack gap-2">
                                @foreach(json_decode($video['options']) as $item)
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar-xs icon-effect">
                                                <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                    <i class="ri-check-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0">{{$item}}</p>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>

    @endif

    @if($khadamats)
        <div class="container section">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h1 class="mb-3  fw-semibold lh-base">{{$khadamats[0]['main_title']}}</h1>
                        <p class="text-muted">{{$khadamats[0]['main_brief_description']}}</p>
                    </div>
                </div>

            </div>


            <div class="row g-3">
                @foreach($khadamats as $khadamat)
                    <div class="col-lg-4">
                        <div class="d-flex p-3">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle">
                                        <i class="{{$khadamat['icon']}} fs-36"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-18">{{$khadamat['title']??''}}</h5>
                                <p class="text-muted my-3 ">{{$khadamat['brief_description']??''}}</p>
                                <div>
                                    <a target="_blank" href="{{$khadamat['link']??''}}" class="fs-14 fw-medium">بیشتر <i
                                                class="ri-arrow-right-s-line align-bottom"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    @endif


    @if($stickFooter)
        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-sm">
                        <div>
                            <h4 class="text-white mb-0 fw-semibold">{{$stickFooter['stick_footer_text']}}</h4>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-auto">
                        <div>
                            <a href="{{$stickFooter['stick_footer_link']}}" target="_blank"
                               class="btn bg-gradient btn-danger"><i
                                        class="{{$stickFooter['stick_footer_icon']}} align-middle me-1"></i>
                                {{$stickFooter['stick_footer_title']}}</a>
                        </div>
                    </div>

                </div>

            </div>

        </section>
    @endif
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>

        $(document).ready(function () {
            $(".showPricee").each(function (index) {
                let x = $(this).data('timeid');
                let particular;
                particular = $(this).data('particular');

                if (particular) {
                    $(this).parent().siblings(".showParticular").removeClass("d-none").addClass("d-block");
                } else {
                    $(this).parent().siblings(".showParticular").removeClass("d-block").addClass("d-none");
                }
            });
        })

        $(".changeTimePeriod").click(function () {
            let time_id = $(this).data('id');
            let particular
            $(".showPricee").each(function (index) {
                let x = $(this).data('timeid');

                if (time_id == x) {
                    particular = $(this).data('particular');
                    $(this).removeClass("d-none").addClass('d-block');
                } else {
                    $(this).removeClass("d-block").addClass('d-none');
                }

                if (particular) {
                    $(this).parent().siblings(".showParticular").removeClass("d-none").addClass("d-block");
                } else {
                    $(this).parent().siblings(".showParticular").removeClass("d-block").addClass("d-none");
                }
            });

        });

        @if(getRegisterMessageOk()==true)
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>پیام شما با موفقیت ثبت شد</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "فهمیدم",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then(function (t) {
            window.location.href = "{{baseUrl(httpCheck()).substr($_SERVER['REQUEST_URI'],1)."?verify=true"}}";
        })

        @endif
    </script>
@endsection