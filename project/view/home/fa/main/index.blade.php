@extends("home.fa.landing_layout.app")

@section('head')

    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{baseUrl(httpCheck())}}assets/css/ia.css" rel="stylesheet" type="text/css"/>
@endsection

@if($metatag)
    @section("title",$metatag['page_title_seo'])
    @section("description",$metatag['page_description_seo'])
    @section("keywords",$metatag['page_keywords_seo'])
    @section("ogTitle",$metatag['page_og_title_seo'])
    @section("ogDescription",$metatag['page_og_description_seo'])
    @section("ogType",$metatag['page_og_type_seo'])
    @section("ogImage",baseUrl(httpCheck()).$metatag['page_og_image_seo'])

@endif

@section("content")

    <section class="section pb-0 hero-section" id="hero">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-sm-10">
                    <div class="text-center mt-lg-4">
                        <h1 class="display-6 fw-semibold mb-3 lh-base">{{$slider['title']}}</h1>
                        <p class="lead text-muted lh-base">{{$slider['description']}}</p>

                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <a @if($slider['first_link']) href="{{$slider['first_link']}}" @else id="gooo"
                               @endif class="btn btn-primary">{{$slider['first_link_title']}} <i
                                        class="ri-arrow-right-line align-middle ms-1"></i></a>
                            <a href="{{$slider['second_link']}}" class="btn btn-danger">{{$slider['second_link_title']}}
                                <i class="ri-eye-line align-middle ms-1"></i></a>
                        </div>
                    </div>

                    <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                        <div class="demo-img-patten-top d-none d-sm-block">
                            <img src="{{baseUrl(httpCheck())}}home/assets/images/landing/img-pattern.png"
                                 class="d-block img-fluid" alt="...">
                        </div>
                        <div class="demo-img-patten-bottom d-none d-sm-block">
                            <img src="{{baseUrl(httpCheck())}}home/assets/images/landing/img-pattern.png"
                                 class="d-block img-fluid" alt="...">
                        </div>
                        <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                @foreach(json_decode($slider['images']) as $key=>$image)
                                    <div class="carousel-item @if($key==0) active @endif " data-bs-interval="5000">
                                        <img src="{{baseUrl(httpCheck()).$image}}"
                                             class="d-block w-100" alt="{{json_decode($slider['alts'])[$key]}}">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 1440 120">
                <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                    <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                    </path>
                </g>
            </svg>
        </div>

    </section>

    @if($services)
        <section class="section bg-light" id="team">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">{{$setting['index_service_title']}}</h3>
                            <p class="text-muted mb-4 ">{{$setting['index_service_description']}}</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row justify-content-center">
                    @foreach($services as $key=>$service)

                        <div class="col-lg-3 col-sm-6 mt-4">
                            <div class="card ribbon-box right h-100">
                                <div class="card-body text-center p-4">
                                    @if($service['is_coming']==1)
                                        <div class="ribbon-two ribbon-two-danger "><span>به زودی</span>
                                        </div>

                                    @endif

                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <a @if($service['is_coming']==0) href="{{baseUrl(httpCheck()).$service['catTitle']."/".($service['page_url']??$service['id'])}}" @endif><img
                                                    src="{{baseUrl(httpCheck()).$service['index_image']}}"
                                                    alt="{{$service['index_image_alt']}}"
                                                    class="img-fluid rounded-circle"></a>
                                        {{--                                        <a @if($service['is_coming']==0) href="{{baseUrl(httpCheck()).($service['page_url']??$service['id'])}}" @endif--}}
                                        {{--                                           class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">--}}
                                        {{--                                            <div class="avatar-title bg-transparent">--}}
                                        {{--                                                <i class="ri-mail-fill align-bottom"></i>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </a>--}}
                                    </div>
                                    <!-- end card body -->
                                    <h5 class="mb-1"><a @if($service['is_coming']==0)
                                                            href="{{baseUrl(httpCheck()).$service['catTitle']."/".($service['page_url']??$service['id'])}}"
                                                        @endif
                                                        class="text-body">{{$service['title']}}</a></h5>
                                    <a @if($service['is_coming']==0) href="{{baseUrl(httpCheck()).$service['catTitle']."/".($service['page_url']??$service['id'])}}" @endif>
                                        <p class="text-muted mb-0 ">{{$service['brief_description']}}</p></a>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>

                    @endforeach

                </div>
                <!-- end row -->
                {{--                <div class="row">--}}
                {{--                    @foreach($services as $key=>$service)--}}
                {{--                        @if($key>3 and )--}}
                {{--                            <div class="col-lg-3 col-sm-6">--}}
                {{--                                <div class="card">--}}
                {{--                                    <div class="card-body text-center p-4">--}}
                {{--                                        <div class="avatar-xl mx-auto mb-4 position-relative">--}}
                {{--                                            <img src="{{baseUrl(httpCheck()).$service['index_image']}}"--}}
                {{--                                                 alt="{{$service['index_image_alt']}}" class="img-fluid rounded-circle">--}}
                {{--                                            <a href="{{baseUrl(httpCheck()).($service['page_url']??$service['id'])}}"--}}
                {{--                                               class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">--}}
                {{--                                                <div class="avatar-title bg-transparent">--}}
                {{--                                                    <i class="ri-mail-fill align-bottom"></i>--}}
                {{--                                                </div>--}}
                {{--                                            </a>--}}
                {{--                                        </div>--}}
                {{--                                        <!-- end card body -->--}}
                {{--                                        <h5 class="mb-1"><a--}}
                {{--                                                    href="{{baseUrl(httpCheck()).($service['page_url']??$service['id'])}}"--}}
                {{--                                                    class="text-body">{{$service['title']}}</a></h5>--}}
                {{--                                        <p class="text-muted mb-0 ">{{$service['brief_description']}}</p>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <!-- end card -->--}}
                {{--                            </div>--}}
                {{--                        @endif--}}
                {{--                    @endforeach--}}
                {{--                </div>--}}
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <div class="text-center mt-2">
                            <a href="/services" class="btn btn-primary">مشاهده همه سرویس ها <i
                                        class="ri-arrow-right-line ms-1 align-bottom"></i></a>
                        </div>
                    </div>
                </div>

            </div>

        </section>
    @endif

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
        <section class="section">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 col-sm-7 col-10 mx-auto">
                        <div>

                            @if($video['video'] == strip_tags($video['video']))
                                <video width="100%" poster="{{baseUrl(httpCheck()).$video['poster']}}" controls>
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

        <section class="section bg-light" id="services">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="mb-3 fw-semibold lh-base">{{$khadamats[0]['main_title']}}</h1>
                            <p class="text-muted">{{$khadamats[0]['main_brief_description']}}</p>
                        </div>
                    </div>

                </div>


                <div class="row justify-content-center g-3">
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
                                        <a href="{{$khadamat['link']??''}}" class="fs-14 fw-medium">بیشتر <i
                                                    class="ri-arrow-right-s-line align-bottom"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </section>

    @endif

    @if($companies)

        <div class="pt-1 mt-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="text-center mt-5">
                            <h5 class="fs-20">{{$setting['index_company_title']}}</h5>

                            <!-- Swiper -->
                            <div class="swiper trusted-client-slider mt-sm-5 mt-4 mb-sm-5 mb-4" dir="ltr">
                                <div class="swiper-wrapper">
                                    @foreach($companies as $key=>$company)
                                        <div class="swiper-slide">
                                            <div class="client-images">
                                                <a href="{{$company['link']}}">
                                                    <img src="{{baseUrl(httpCheck()).$company['image']}}"
                                                         alt="{{$company['alt']}}" class="mx-auto img-fluid d-block">
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    @endif
    <section class="section bg-primary" id="reviews">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center">
                        <div>
                            <i class="ri-double-quotes-l text-success display-3"></i>
                        </div>
                        <h4 class="text-white mb-5">{{$setting['index_satisfy_title']}}</h4>

                        <!-- Swiper -->
                        <div class="swiper client-review-swiper rounded" dir="ltr">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <div class="text-white-50">
                                                <p class="fs-19  mb-4">"ما بالای 10 سال هستش که داریم باهاشون کار میکنیم
                                                    و تا حالا جایی لنگ نموندیم و همه چی خوب پیش رفته "</p>

                                                <div>
                                                    <h5 class="text-white">ع.اسدی</h5>
                                                    <p>ادمینی اینستاگرام</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end slide -->
                                <div class="swiper-slide">
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <div class="text-white-50">
                                                <p class="fs-19  mb-4">" بچه های خوبی هستن و بعضی جاها از خود مجموعه ما
                                                    هم پیگیر ترن، ما به اطرافیان معرفیشون کردیم "</p>

                                                <div>
                                                    <h5 class="text-white">ب.قورچیان</h5>
                                                    <p>طراحی سایت</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end slide -->
                                <div class="swiper-slide">
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <div class="text-white-50">
                                                <p class="fs-19  mb-4">" تا الان که با تیم بالا 24 مشکلی نداشیم و همچی
                                                    خوب پیش رفته! به امید خدا ازین به بعدم همینجوری باشن"</p>

                                                <div>
                                                    <h5 class="text-white">م.احمدی</h5>
                                                    <p>طراحی سایت</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end slide -->
                            </div>
                            <div class="swiper-button-next bg-white rounded-circle"></div>
                            <div class="swiper-button-prev bg-white rounded-circle"></div>
                            <div class="swiper-pagination position-relative mt-2"></div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section>

    <section class=" py-5 position-relative ">
        <div class="container">
            <div class="row text-center gy-4">
                <div class="col-lg-3 col-6">
                    <div>
                        <h2 class="mb-2"><span class="counter-value"
                                               data-target="{{json_decode($setting['index_functionality_values'])[0]}}">0</span>
                        </h2>
                        <div class="text-muted">{{json_decode($setting['index_functionality_titles'])[0]}}</div>
                    </div>
                </div>


                <div class="col-lg-3 col-6">
                    <div>
                        <h2 class="mb-2"><span class="counter-value"
                                               data-target="{{json_decode($setting['index_functionality_values'])[1]}}">0</span>
                        </h2>
                        <div class="text-muted"> {{json_decode($setting['index_functionality_titles'])[1]}}</div>
                    </div>
                </div>


                <div class="col-lg-3 col-6">
                    <div>
                        <h2 class="mb-2"><span class="counter-value"
                                               data-target="{{json_decode($setting['index_functionality_values'])[2]}}">0</span>
                        </h2>
                        <div class="text-muted">{{json_decode($setting['index_functionality_titles'])[2]}}</div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div>
                        <h2 class="mb-2"><span class="counter-value"
                                               data-target="{{json_decode($setting['index_functionality_values'])[3]}}">0</span>
                        </h2>
                        <div class="text-muted">{{json_decode($setting['index_functionality_titles'])[3]}}</div>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <section class="section bg-light" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">ارتباط با ما</h3>
                        <p class="text-muted mb-4 ">برای ارتباط با ما از روش های زیر استفاده کنید</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

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
                        @if($setting['instagram'] or $setting['linkedin'] or $setting['telegram'] or $setting['whatsapp'])
                            <div class="mt-4">
                                <h5 class="fs-13 text-muted text-uppercase">شبکه های اجتماعی : </h5>
                                <div class="">
                                    @if($setting['linkedin'])
                                        <a href="{{$setting['linkedin']}}" target="_blank"><i
                                                    class="ri-linkedin-box-fill text-info font_xx_l"></i></a>
                                    @endif
                                    @if($setting['telegram'])
                                        <a href="{{$setting['telegram']}}" target="_blank"><i
                                                    class="ri-telegram-fill text-primary font_xx_l"></i></a>
                                    @endif
                                    @if($setting['instagram'])
                                        <a href="{{$setting['instagram']}}" target="_blank"><i
                                                    class="ri-instagram-fill text-danger font_xx_l"></i></a>
                                    @endif
                                    @if($setting['whatsapp'])
                                        <a href="{{$setting['whatsapp']}}" target="_blank"><i
                                                    class="ri-whatsapp-fill text-success font_xx_l"></i></a>
                                    @endif

                                </div>
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

    @if($stickFooter)
        <section class=" py-5 bg-primary position-relative">
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

        $("#gooo").click(function () {
            $('html, body').animate({
                scrollTop: $("#team").offset().top
            }, 2000);
        });
    </script>
@endsection