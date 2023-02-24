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

   
@endsection
