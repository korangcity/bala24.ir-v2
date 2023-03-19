@extends("home.fa.layout.app")

@if($blog)
    @section("title",$blog['page_title_seo'])
    @section("description",$blog['page_description_seo'])
    @section("keywords",$blog['page_keywords_seo'])
    @section("ogTitle",$blog['page_og_title_seo'])
    @section("ogDescription",$blog['page_og_description_seo'])
    @section("ogType",$blog['page_og_type_seo'])
    @section("ogImage",baseUrl(httpCheck()).$blog['page_og_image_seo'])

@endif

@section("content")

    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{baseUrl(httpCheck()).json_decode($blog['images'])[0]}}" alt="{{baseUrl(httpCheck()).json_decode($blog['alts'])[0]}}" class="profile-wid-img"/>
        </div>
    </div>
    <div class="mt-xl-4 mt-lg-4">
        <div class="row g-4 mb-2">
            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-3">
                <div class="avatar-lg">
                    <img src="{{baseUrl(httpCheck()).$blog['avatar']}}"  alt="{{$blog['name']}}" class="img-thumbnail rounded-circle avater_img_size"/>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-8 col-lg-7 col-md-7 col-sm-6 col-5">
                <div class="p-2">
                    @if($blog['name'])
                        <h3 class="text-white mb-1">{{$blog['name']}}</h3>
                    @endif
                    <p class="text-white-75">
                        ادمین,

                        @if($blog['address'])
                            <i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>{{$blog['address']}}
                        @endif
                        @if($blog['departman'])

                            <i class="ri-building-line me-1 text-white-75 fs-16 align-middle"></i>{{$blog['departman']}}

                        @endif
                    </p>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-4">
                <div class="row text text-white-50 text-center">
                    <div class="col">
                        <div class="p-2">
                            <h4 class="text-white mb-1">{{$authorPaperNumber}}</h4>
                            <p class="fs-14 mb-0">مقالات</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2">
                            <h4 class="text-white mb-1">5</h4>
                            <p class="fs-14 mb-0">بازخورد</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex">

                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" aria-selected="true" href="#overview-tab" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                        class="d-none d-md-inline-block">شرح بلاگ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#documents" role="tab">
                                <i class="ri-list-unordered d-inline-block d-md-none"></i> <span
                                        class="d-none d-md-inline-block">مقالات نویسنده</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#projects" role="tab">
                                <i class="ri-price-tag-line d-inline-block d-md-none"></i> <span
                                        class="d-none d-md-inline-block">ویدیوهای نویسنده</span>
                            </a>
                        </li>
                    </ul>

                </div>

                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane fade active show" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-3 order-xl-1 order-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-5">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-0">امتیاز نویسنده</h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <a href="javascript:void(0);" class="badge bg-light text-primary fs-12">
                                                    <i class="ri-star-line align-bottom"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                <div class="label">30%</div>
                                            </div>
                                        </div>

                                        <!-- <h5 class="card-title mb-5">درصد امتیاز نویسنده</h5>
                                        <div class="progress animated-progress custom-progress progress-label">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                 style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                                                 aria-valuemax="100">
                                                <div class="label">30%</div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                {{--                                <div class="card">--}}
                                {{--                                    <div class="card-body">--}}
                                {{--                                        <h5 class="card-title mb-3">اطلاعات</h5>--}}
                                {{--                                        <div class="table-responsive">--}}
                                {{--                                            <table class="table table-borderless mb-0">--}}
                                {{--                                                <tbody>--}}
                                {{--                                                <tr>--}}
                                {{--                                                    <th class="ps-0" scope="row">نام و نام خانوادگی :</th>--}}
                                {{--                                                    <td class="text-muted">{{$blog['name']??''}}</td>--}}
                                {{--                                                </tr>--}}
                                {{--                                                <tr>--}}
                                {{--                                                    <th class="ps-0" scope="row">موبایل :</th>--}}
                                {{--                                                    <td class="text-muted">{{$blog['mobile']??''}}</td>--}}
                                {{--                                                </tr>--}}
                                {{--                                                <tr>--}}
                                {{--                                                    <th class="ps-0" scope="row">ایمیل :</th>--}}
                                {{--                                                    <td class="text-muted">{{$blog['email']??''}}</td>--}}
                                {{--                                                </tr>--}}
                                {{--                                                <tr>--}}
                                {{--                                                    <th class="ps-0" scope="row">آدرس :</th>--}}
                                {{--                                                    <td class="text-muted">{{$blog['address']??''}}--}}
                                {{--                                                    </td>--}}
                                {{--                                                </tr>--}}
                                {{--                                                <tr>--}}
                                {{--                                                    <th class="ps-0" scope="row">تاریخ پیوستن</th>--}}
                                {{--                                                    <td class="text-muted">{{\Morilog\Jalali\CalendarUtils::strftime("Y/m/d",strtotime($blog['created_at']))}}</td>--}}
                                {{--                                                </tr>--}}
                                {{--                                                </tbody>--}}
                                {{--                                            </table>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">اشتراک گذاری</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <div>
                                                <a target="_blank"
                                                   href="https://api.whatsapp.com/send?text={{$blog['title']}}%20{{baseUrl(httpCheck())."blog/".($blog['page_url']??$blog['id'])}}"
                                                   class="avatar-xs d-block">
                                                                    <span class="avatar-title rounded-circle fs-16 bg-success text-light">
                                                                        <i class="ri-whatsapp-fill"></i>
                                                                    </span>
                                                </a>
                                            </div>
                                            <div>
                                                <a target="_blank"
                                                   href="https://t.me/share/url?url={{baseUrl(httpCheck())."blog/".($blog['page_url']??$blog['id'])}}&text={{$blog['title']}}"
                                                   class="avatar-xs d-block">
                                                                    <span class="avatar-title rounded-circle fs-16 bg-primary">
                                                                        <i class="ri-telegram-fill"></i>
                                                                    </span>
                                                </a>
                                            </div>
                                            <div>
                                                <a target="_blank"
                                                   href="https://www.facebook.com/sharer.php?u={{baseUrl(httpCheck())."blog/".($blog['page_url']??$blog['id'])}}"
                                                   class="avatar-xs d-block">
                                                                    <span class="avatar-title rounded-circle fs-16 bg-info">
                                                                        <i class="ri-facebook-fill"></i>
                                                                    </span>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">کلمات کلیدی</h5>
                                        <div class="d-flex flex-wrap gap-2 fs-15">
                                            @php $colors=["badge-soft-primary","badge-soft-info","badge-soft-success","badge-soft-danger","badge-soft-dark"]; @endphp
                                            @foreach(explode("+",$blog['keywords']) as $k=>$keyword)
                                                <a href="javascript:void(0);" class="badge {{$colors[array_rand($colors)]}}">{{$keyword}}</a>
                                            @endforeach


{{--                                            @foreach($authorsArray as $author)--}}
{{--                                                <a href="javascript:void(0);" class="badge badge-soft-primary">{{$author}}</a>--}}
{{--                                            @endforeach--}}
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-0">دیگر نویسندگان</h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a href="#" role="button" id="dropdownMenuLink2"
                                                       data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill fs-14"></i>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            @foreach($authorsArray as $author)
                                                <div class="d-flex align-items-center py-3">
                                                    <div class="avatar-xs flex-shrink-0 me-3">
                                                        <img src="{{baseUrl(httpCheck()).($author['avatar']?:"home/assets/images/users/user-dummy-img.jpg")}}"
                                                             alt="{{$author['name']}}"
                                                             class="img-fluid rounded-circle"/>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <h5 class="fs-15 mb-1">{{$author['name']??""}}</h5>
                                                            {{--                                                        <p class="fs-13 text-muted mb-0">توضیح مختصر</p>--}}
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-info"><i
                                                                    class="ri-user-add-line align-middle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-0">وبلاگ های مرتبط</h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a href="#" role="button" id="dropdownMenuLink1"
                                                       data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill fs-14"></i>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>

                                        @foreach($blogs_in_category as $kk=>$blogCat)
                                        <div class="d-flex mb-4">
                                            <div class="flex-shrink-0">
                                                <img src="{{baseUrl(httpCheck()).json_decode($blogCat['images'])[0]}}"
                                                     alt="{{json_decode($blogCat['alts'])[0]}}" height="50"
                                                     class="rounded"/>
                                            </div>
                                            <div class="flex-grow-1 ms-3 overflow-hidden">
                                                <a href="{{baseUrl(httpCheck()).($blogCat['page_url']??$blogCat['id'])}}">
                                                    <h6 class="text-truncate fs-14">{{$blogCat['title']}}</h6>
                                                </a>
                                                <p class="text-muted mb-0">{{\Morilog\Jalali\CalendarUtils::strftime("Y/m/d",strtotime($blogCat['created_at']))}}</p>
                                            </div>
                                        </div>
                                       @endforeach


                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-9 order-xl-2 order-1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">


                                                <div class="row align-items-center gy-4">
                                                    <div class="col-lg-6 col-sm-7 col-10 mx-auto">
                                                        <div>
                                                            <img src="{{baseUrl(httpCheck()).json_decode($blog['images'])[0]}}"
                                                                 alt="{{json_decode($blog['alts'])[0]}}"
                                                                 class="img-fluid">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="text-muted ps-lg-5">
                                                            <h5 class="fs-12 text-uppercase text-success">{{$blog_category['title']}}</h5>
                                                            <h4 class="mb-3">{{$blog['title']}}</h4>
                                                            <p class="mb-4">{{$blog['brief_description']}}</p>

                                                        </div>
                                                    </div>

                                                </div>


                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body border">
                                                <div class="row align-items-center gy-4 mt-3 mb-5">
                                                    <div class="col-lg-6 col-sm-7 col-10 mx-auto">
                                                        <div>
                                                            <style>.h_iframe-aparat_embed_frame{position:relative;}.h_iframe-aparat_embed_frame .ratio{display:block;width:100%;height:auto;}.h_iframe-aparat_embed_frame iframe{position:absolute;top:0;left:0;width:100%;height:100%;}</style><div class="h_iframe-aparat_embed_frame"><span style="display: block;padding-top: 57%"></span><iframe src="https://www.aparat.com/video/video/embed/videohash/4AWrK/vt/frame" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="text-muted ps-lg-5">
                                                            <h5 class="fs-12 text-uppercase text-success">اینستاگرام</h5>
                                                            <h4 class="mb-3">ادمین پیج اینستاگرام</h4>
                                                            <p class="mb-4">ادمینی و تولید محتوای حرفه ای پیج اینستاگرام شما با رعایت آخرین الگوریم های روز اینستاگرام</p>

                                                            <div class="vstack gap-2">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">
                                                                        <div class="avatar-xs icon-effect">
                                                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                                                <i class="ri-check-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0">تولید محتوا و برندینگ</p>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">
                                                                        <div class="avatar-xs icon-effect">
                                                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                                                <i class="ri-check-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0">انتخاب بیزینس پلن</p>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">
                                                                        <div class="avatar-xs icon-effect">
                                                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                                                <i class="ri-check-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="mb-0">آنالیز پیج اینستاگرام</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>



                                                <!-- <div class="row align-items-center gy-4">
                                                    <div class="col-12 mx-auto">
                                                        @if($blog['video'] == strip_tags($blog['video']))
                                                    <video width="100%"
                                                           poster="{{baseUrl(httpCheck()).$blog['poster']}}" controls>
                                                                <source src="{{baseUrl(httpCheck()).$blog['video']}}"
                                                                        type="video/mp4">
                                                            </video>

                                                        @else
                                                    {!! html_entity_decode($blog['video']) !!}
                                                @endif
                                                </div>


                                            </div> -->


                                            </div>

                                        </div>


                                    </div>

                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body border">
                                                <br>
                                                {!! html_entity_decode($blog['description']) !!}

                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="d-flex mt-4">
                                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                                    <i class="ri-user-2-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="mt-3">
                                                                    امضا :
                                                                    <span class="text-primary"><b>نمونه امضا</b></span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="d-flex mt-4">
                                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                                    <i class="ri-global-line"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="mt-3">
                                                                    منبع :
                                                                    <a href="#" class="fw-semibold">منبع مورد نظر</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="d-flex mt-4">
                                                            <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                                                                <div class="avatar-title bg-light rounded-circle fs-16 text-primary">
                                                                    <i class="ri-calendar-2-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <p class="mt-3">
                                                                    تاریخ :
                                                                    <a href="#" class="fw-semibold">{{\Morilog\Jalali\CalendarUtils::strftime("Y/m/d",strtotime($blog['created_at']))}}</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="projects" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-warning">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Chat
                                                                App Update</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">2 year Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-warning fs-10">
                                                            Inprogress
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-1.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-3.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                                            J
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-success">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">ABC
                                                                Project Customization</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            : <span class="fw-semibold text-dark">2 month Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-primary fs-10">
                                                            Progress
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-8.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-7.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-6.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-primary">
                                                                            2+
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-info">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Client
                                                                - Frank Hook</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">1 hr Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-info fs-10">New</div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0"> Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-4.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                                            M
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-3.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-primary">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Velzon
                                                                Project</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">11 hr Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-success fs-10">
                                                            Completed
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-7.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-5.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-danger">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Brand
                                                                Logo Design</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">10 min Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-info fs-10">New</div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-7.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-6.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                                            E
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-primary">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Chat
                                                                App</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">8 hr Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-warning fs-10">
                                                            Inprogress
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                                            R
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-3.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-8.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-warning">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Project
                                                                Update</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">48 min Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-warning fs-10">
                                                            Inprogress
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-6.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-5.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-4.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none profile-project-success">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Client
                                                                - Jennifer</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">30 min Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-primary fs-10">
                                                            Process
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0"> Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-1.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none mb-xxl-0 profile-project-info">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Bsuiness
                                                                Template - UI/UX design</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            : <span class="fw-semibold text-dark">7 month Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-success fs-10">
                                                            Completed
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-2.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-3.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-4.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-primary">
                                                                            2+
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none mb-xxl-0  profile-project-success">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Update
                                                                Project</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            : <span class="fw-semibold text-dark">1 month Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-info fs-10">New</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-7.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid">
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-light text-primary">
                                                                            A
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none mb-sm-0  profile-project-danger">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">Bank
                                                                Management System</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            : <span class="fw-semibold text-dark">10 month Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-success fs-10">
                                                            Completed
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-7.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-6.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-5.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title rounded-circle bg-primary">
                                                                            2+
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card profile-project-card shadow-none mb-0  profile-project-primary">
                                            <div class="card-body p-4">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 text-muted overflow-hidden">
                                                        <h5 class="fs-14 text-truncate"><a href="#"
                                                                                           class="text-dark">PSD
                                                                to HTML Convert</a></h5>
                                                        <p class="text-muted text-truncate mb-0">Last Update
                                                            :
                                                            <span class="fw-semibold text-dark">29 min Ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-2">
                                                        <div class="badge badge-soft-info fs-10">New</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div>
                                                                <h5 class="fs-12 text-muted mb-0">Members
                                                                    :</h5>
                                                            </div>
                                                            <div class="avatar-group">
                                                                <div class="avatar-group-item">
                                                                    <div class="avatar-xs">
                                                                        <img src="assets/images/users/avatar-7.jpg"
                                                                             alt=""
                                                                             class="rounded-circle img-fluid"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mt-4">
                                            <ul class="pagination pagination-separated justify-content-center mb-0">
                                                <li class="page-item disabled">
                                                    <a href="javascript:void(0);" class="page-link"><i
                                                                class="mdi mdi-chevron-left"></i></a>
                                                </li>
                                                <li class="page-item active">
                                                    <a href="javascript:void(0);" class="page-link">1</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="javascript:void(0);" class="page-link">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="javascript:void(0);" class="page-link">3</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="javascript:void(0);" class="page-link">4</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="javascript:void(0);" class="page-link">5</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="javascript:void(0);" class="page-link"><i
                                                                class="mdi mdi-chevron-right"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <div class="tab-pane fade" id="documents" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <h5 class="card-title flex-grow-1 mb-0">Documents</h5>
                                    <div class="flex-shrink-0">
                                        <input class="form-control d-none" type="file" id="formFile">
                                        <label for="formFile" class="btn btn-primary"><i
                                                    class="ri-upload-2-fill me-1 align-bottom"></i> Upload File</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-borderless align-middle mb-0">
                                                <thead class="table-light">
                                                <tr>
                                                    <th scope="col">File Name</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Upload Date</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm">
                                                                <div class="avatar-title bg-soft-primary text-primary rounded fs-20">
                                                                    <i class="ri-file-zip-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 flex-grow-1">
                                                                <h6 class="fs-15 mb-0"><a
                                                                            href="javascript:void(0)"
                                                                            class="link-dark">Artboard-documents.zip</a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Zip File</td>
                                                    <td>4.57 MB</td>
                                                    <td>12 Dec 2021</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-light btn-icon"
                                                               id="dropdownMenuLink15"
                                                               data-bs-toggle="dropdown"
                                                               aria-expanded="true">
                                                                <i class="ri-equalizer-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink15">
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-eye-fill me-2 align-middle text-muted"></i>View</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm">
                                                                <div class="avatar-title bg-soft-danger text-danger rounded fs-20">
                                                                    <i class="ri-file-pdf-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 flex-grow-1">
                                                                <h6 class="fs-15 mb-0"><a
                                                                            href="javascript:void(0);"
                                                                            class="link-dark">Bank Management
                                                                        System</a></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>PDF File</td>
                                                    <td>8.89 MB</td>
                                                    <td>24 Nov 2021</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-light btn-icon"
                                                               id="dropdownMenuLink3"
                                                               data-bs-toggle="dropdown"
                                                               aria-expanded="true">
                                                                <i class="ri-equalizer-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink3">
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-eye-fill me-2 align-middle text-muted"></i>View</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm">
                                                                <div class="avatar-title bg-soft-secondary text-secondary rounded fs-20">
                                                                    <i class="ri-video-line"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 flex-grow-1">
                                                                <h6 class="fs-15 mb-0"><a
                                                                            href="javascript:void(0);"
                                                                            class="link-dark">Tour-video.mp4</a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>MP4 File</td>
                                                    <td>14.62 MB</td>
                                                    <td>19 Nov 2021</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-light btn-icon"
                                                               id="dropdownMenuLink4"
                                                               data-bs-toggle="dropdown"
                                                               aria-expanded="true">
                                                                <i class="ri-equalizer-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink4">
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-eye-fill me-2 align-middle text-muted"></i>View</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm">
                                                                <div class="avatar-title bg-soft-success text-success rounded fs-20">
                                                                    <i class="ri-file-excel-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 flex-grow-1">
                                                                <h6 class="fs-15 mb-0"><a
                                                                            href="javascript:void(0);"
                                                                            class="link-dark">Account-statement.xsl</a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>XSL File</td>
                                                    <td>2.38 KB</td>
                                                    <td>14 Nov 2021</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-light btn-icon"
                                                               id="dropdownMenuLink5"
                                                               data-bs-toggle="dropdown"
                                                               aria-expanded="true">
                                                                <i class="ri-equalizer-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink5">
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-eye-fill me-2 align-middle text-muted"></i>View</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm">
                                                                <div class="avatar-title bg-soft-info text-info rounded fs-20">
                                                                    <i class="ri-folder-line"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 flex-grow-1">
                                                                <h6 class="fs-15 mb-0"><a
                                                                            href="javascript:void(0);"
                                                                            class="link-dark">Project
                                                                        Screenshots Collection</a></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Floder File</td>
                                                    <td>87.24 MB</td>
                                                    <td>08 Nov 2021</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-light btn-icon"
                                                               id="dropdownMenuLink6"
                                                               data-bs-toggle="dropdown"
                                                               aria-expanded="true">
                                                                <i class="ri-equalizer-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink6">
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-eye-fill me-2 align-middle"></i>View</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-download-2-fill me-2 align-middle"></i>Download</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm">
                                                                <div class="avatar-title bg-soft-danger text-danger rounded fs-20">
                                                                    <i class="ri-image-2-fill"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 flex-grow-1">
                                                                <h6 class="fs-15 mb-0"><a
                                                                            href="javascript:void(0);"
                                                                            class="link-dark">Velzon-logo.png</a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>PNG File</td>
                                                    <td>879 KB</td>
                                                    <td>02 Nov 2021</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-light btn-icon"
                                                               id="dropdownMenuLink7"
                                                               data-bs-toggle="dropdown"
                                                               aria-expanded="true">
                                                                <i class="ri-equalizer-fill"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink7">
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-eye-fill me-2 align-middle"></i>View</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-download-2-fill me-2 align-middle"></i>Download</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="javascript:void(0);"><i
                                                                                class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="javascript:void(0);" class="text-info"><i
                                                        class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i>
                                                Load more </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

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

    <script src="{{baseUrl(httpCheck())}}home/assets/js/pages/profile.init.js"></script>
@endsection

@section('script')


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
