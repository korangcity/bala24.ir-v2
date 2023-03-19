@extends("home.fa.layout.app")

@if($sampleService)
    @section("title",$sampleService['page_title_seo'])
    @section("description",$sampleService['page_description_seo'])
    @section("keywords",$sampleService['page_keywords_seo'])
    @section("ogTitle",$sampleService['page_og_title_seo'])
    @section("ogDescription",$sampleService['page_og_description_seo'])
    @section("ogType",$sampleService['page_og_type_seo'])
    @section("ogImage",baseUrl(httpCheck()).$sampleService['page_og_image_seo'])

@endif

@section("content")


       <section class="section pb-0 " style="padding-top: 0 !important" id="hero">
           <div class="bg-overlay bg-overlay-pattern"></div>
           <div class="container">
               <div class="row justify-content-center">
                   <div class="col-lg-8 col-sm-10">
                       <div class="text-center">
                           <h1 class="display-6 fw-semibold mb-3 lh-base">{{$sampleService['h1_title']}}</h1>
                           <p class="lead text-muted lh-base">{{$sampleService['brief_description']}}</p>

                           {{--                        <div class="d-flex gap-2 justify-content-center mt-4">--}}
                           {{--                            <a href="auth-signup-basic.html" class="btn btn-primary">Get Started <i class="ri-arrow-right-line align-middle ms-1"></i></a>--}}
                           {{--                            <a href="pages-pricing.html" class="btn btn-danger">View Plans <i class="ri-eye-line align-middle ms-1"></i></a>--}}
                           {{--                        </div>--}}
                       </div>

                       <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                           <div class="demo-img-patten-top d-none d-sm-block">
                               <img src="{{baseUrl(httpCheck())}}assets/images/landing/img-pattern.png" class="d-block img-fluid" alt="...">
                           </div>
                           <div class="demo-img-patten-bottom d-none d-sm-block">
                               <img src="{{baseUrl(httpCheck())}}assets/images/landing/img-pattern.png" class="d-block img-fluid" alt="...">
                           </div>
                           <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                               <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                   @foreach(json_decode($sampleService['images']) as $key=>$image)
                                       <div class="carousel-item {{$key==0?"active":""}} " data-bs-interval="2000">
                                           <img src="{{baseUrl(httpCheck()).$image}}" class="d-block w-100" alt="{{json_decode($sampleService['alts'])[$key]}}">
                                       </div>
                                   @endforeach
                               </div>
                           </div>
                       </div>


                   </div>
               </div>
               <!-- end row -->
           </div>

           <!-- end container -->
           <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
               <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                   <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                       <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                       </path>
                   </g>
               </svg>
           </div>
           <!-- end shape -->
       </section>

       <div class="row section mt-5">
           <div class="container">
           {!! html_entity_decode($sampleService['description']) !!}

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
                                  class="btn bg-gradient btn-danger"><i class="{{$stickFooter['stick_footer_icon']}} align-middle me-1"></i>
                                   {{$stickFooter['stick_footer_title']}}</a>
                           </div>
                       </div>

                   </div>

               </div>

           </section>
       @endif
   
@endsection
