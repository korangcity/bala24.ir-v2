@extends("home.fa.layout.app")

@if($service)
    @section("title",$service['page_title_seo'])
    @section("description",$service['page_description_seo'])
    @section("keywords",$service['page_keywords_seo'])
    @section("ogTitle",$service['page_og_title_seo'])
    @section("ogDescription",$service['page_og_description_seo'])
    @section("ogType",$service['page_og_type_seo'])
    @section("ogImage",baseUrl(httpCheck()).$service['page_og_image_seo'])

@endif

@section("content")

    <section class="section" style="padding:0 0 30px !important">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6 col-sm-7 col-10 mx-auto">
                    <div>
                        @if($service['show_video'])

                            @if($service['video'] == strip_tags($service['video']))
                            <video width="100%"  poster="{{baseUrl(httpCheck()).$service['video_poster']}}" controls>
                                <source src="{{baseUrl(httpCheck()).$service['video']}}" type="video/mp4">
                            </video>

                            @else
                              {!! html_entity_decode($service['video']) !!}
                            @endif

                        @else
                            <img src="{{baseUrl(httpCheck()).json_decode($service['images'])[0]}}"
                                 alt="{{json_decode($service['alts'])[0]}}"
                                 class="img-fluid">

                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-muted ps-lg-5">
                        <h5 class="fs-12 text-uppercase text-success">{{$service_category['title']}}</h5>
                        <h4 class="mb-3">{{$service['title']}}</h4>
                        <p class="mb-4">{{$service['brief_description']}}</p>

                        <div class="vstack gap-2">
                            @foreach($serviceProcess as $item)
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs icon-effect">
                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                <i class="ri-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">{{$item['title']}}</p>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    @if(!empty($serviceProcess))
        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">{{$service["service_guide_title"]??"راهنمای سرویس"}}</h3>
                            <p class="text-muted mb-4 ff-secondary">
                                {{$service["service_guide_brief_description"]??"توضیحات راهنمای سرویس"}}
                            </p>
                        </div>
                    </div>
                </div>


                <div class="row text-center">
                    <div class="col-lg-4">
                        <div class="process-card mt-4">
                            <div class="process-arrow-img d-none d-lg-block">
                                <img src="{{baseUrl(httpCheck())}}home/assets/images/landing/process-arrow-img.png"
                                     alt=""
                                     class="img-fluid">
                            </div>
                            <div class="avatar-sm icon-effect mx-auto mb-4">
                                <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                    <i class="{{$serviceProcess[0]['icon']}}"></i>
                                </div>
                            </div>

                            <h5>{{$serviceProcess[0]['title']}}</h5>
                            <p class="text-muted ff-secondary">{{$serviceProcess[0]['brief_description']}}</p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="process-card mt-4">
                            <div class="process-arrow-img d-none d-lg-block">
                                <img src="{{baseUrl(httpCheck())}}home/assets/images/landing/process-arrow-img.png"
                                     alt=""
                                     class="img-fluid">
                            </div>
                            <div class="avatar-sm icon-effect mx-auto mb-4">
                                <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                    <i class="{{$serviceProcess[1]['icon']}}"></i>
                                </div>
                            </div>

                            <h5>{{$serviceProcess[1]['title']}}</h5>
                            <p class="text-muted ff-secondary">{{$serviceProcess[1]['brief_description']}}</p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="process-card mt-4">
                            <div class="avatar-sm icon-effect mx-auto mb-4">
                                <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                    <i class="{{$serviceProcess[2]['icon']}}"></i>
                                </div>
                            </div>

                            <h5>{{$serviceProcess[2]['title']}}</h5>
                            <p class="text-muted ff-secondary">{{$serviceProcess[2]['brief_description']}}</p>
                        </div>
                    </div>

                </div>

            </div>

        </section>
    @endif
    @if(!empty($serviceParts))
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
                            <h5 class="mb-0 pb-1 text-decoration-underline">  {{$service["service_part_title"]??"قسمت های سرویس"}}</h5>
                        </div>
                        <div class="row">
                            @foreach($serviceParts as $part)
                                <div class="col-xxl-6">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img class="rounded-start img-fluid h-100 object-cover"
                                                     src="{{baseUrl(httpCheck()).$part['image']}}"
                                                     alt="{{$part['alt']}}">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">{{$part['title']}}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text mb-2">{{$part['brief_description']}}</p>
                                                    {{--                                            <p class="card-text"><small class="text-muted">Last updated 3 mins--}}
                                                    {{--                                                    ago</small></p>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($sampleServices))
        <section class="section " id="team">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h3 class="mb-3 fw-semibold">{{$service["service_sample_title"]??"نمونه کارها"}}</h3>
                            <p class="text-muted mb-4 ff-secondary">{{$service["service_sample_description"]??"لیست نمونه کارها"}}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach($sampleServices as $key=>$sample)
                        @if($key<4)
                            <div class="col-lg-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar-xl mx-auto mb-4 position-relative">
                                            <img src="{{baseUrl(httpCheck()).$sample['image_small']}}"
                                                 alt="{{$sample['title']}}"
                                                 class="img-fluid rounded-circle">
                                            <a target="_blank"
                                               href="{{baseUrl(httpCheck()).$main_url."/".($sample['page_url']??$sample['id'])}}"
                                               class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                                <div class="avatar-title bg-transparent">
                                                    <i class="ri-mail-fill align-bottom"></i>
                                                </div>
                                            </a>
                                        </div>

                                        <h5 class="mb-1"><a target="_blank"
                                                            href="{{baseUrl(httpCheck()).$main_url."/".($sample['page_url']??$sample['id'])}}"
                                                            class="text-body">{{$sample['title']}}</a>
                                        </h5>
                                        <p class="text-muted mb-0 ff-secondary">{{$sample['brief_description']}}</p>
                                    </div>
                                </div>

                            </div>
                        @endif
                    @endforeach

                </div>

                <div class="row">
                    @foreach($sampleServices as $key=>$sample)
                        @if($key>3)
                            <div class="col-lg-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body text-center p-4">
                                        <div class="avatar-xl mx-auto mb-4 position-relative">
                                            <img src="{{baseUrl(httpCheck()).json_decode($sample['images'])[0]}}"
                                                 alt="{{json_decode($sample['alts'])[0]}}"
                                                 class="img-fluid rounded-circle">
                                            <a target="_blank"
                                               href="{{baseUrl(httpCheck()).$main_url."/".($sample['page_url']??$sample['id'])}}"
                                               class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                                <div class="avatar-title bg-transparent">
                                                    <i class="ri-mail-fill align-bottom"></i>
                                                </div>
                                            </a>
                                        </div>

                                        <h5 class="mb-1"><a target="_blank"
                                                            href="{{baseUrl(httpCheck()).$main_url."/".($sample['page_url']??$sample['id'])}}"
                                                            class="text-body">{{$sample['title']}}</a>
                                        </h5>
                                        <p class="text-muted mb-0 ff-secondary">{{$sample['brief_description']}}</p>
                                    </div>
                                </div>

                            </div>
                        @endif
                    @endforeach

                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-2">
                            <a href="#" class="btn btn-primary">مشاهده تمامی موارد <i
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
                        <div class="col-lg-4">
                            <div class="card plan-box mb-0 ribbon-box right">
                                <div class="card-body p-4 m-2">

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
                                                <span class="ff-secondary fw-bold">{{$price['price']??0}}</span><sup><small>تومان</small></sup>
                                                <span class="fs-13 text-muted">/@php foreach($time_periods as $time_periodd): if($time_periodd['id']==$price['time_period_id']):  echo $time_periodd['title'];  endif; endforeach;  @endphp</span>
                                            </h1>

                                        @endforeach

                                    </div>

                                    <div>
                                        <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
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
                                            <a href="javascript:void(0);" class="btn btn-soft-success w-100">شروع
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

@endsection




@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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
    </script>

@endsection