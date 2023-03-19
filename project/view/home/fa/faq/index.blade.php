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

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">{{$faq_constant['title']}}</h3>
                        <p class="text-muted mb-4 ff-secondary">{{$faq_constant['brief_constant']}}</p>

                        <div class="">
                            <a target="_blank" href="{{$faq_constant['first_link']}}">
                                <button type="button" class="btn btn-primary btn-label rounded-pill"><i
                                            class="{{$faq_constant['first_link_icon']}} label-icon align-middle rounded-pill fs-16 me-2"></i> {{$faq_constant['first_link_title']}}
                                </button>
                            </a>
                            <a target="_blank" href="{{$faq_constant['second_link']}}">
                                <button type="button" class="btn btn-info btn-label rounded-pill"><i
                                            class="{{$faq_constant['second_link_icon']}} label-icon align-middle rounded-pill fs-16 me-2"></i> {{$faq_constant['first_link_title']}}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row g-lg-5 g-4">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0 me-1">
                            <i class="ri-question-line fs-24 align-middle text-success me-1"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fw-semibold">سوالات متداول</h5>
                        </div>
                    </div>
                    <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box"
                         id="genques-accordion">
                        @if(!empty($faqs))
                            @foreach($faqs as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="genques-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#genques-collapseOne" aria-expanded="true"
                                                aria-controls="genques-collapseOne">
                                            {!! html_entity_decode($faq['question']) !!}
                                        </button>
                                    </h2>
                                    <div id="genques-collapseOne" class="accordion-collapse collapse @if($loop->index==0) show @endif"
                                         aria-labelledby="genques-headingOne" data-bs-parent="#genques-accordion">
                                        <div class="accordion-body ">
                                            {!! html_entity_decode($faq['answer']) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>


                </div>

            </div>

        </div>

    </section>

@endsection

@section('script')

    <script>


    </script>
@endsection