@php
    $set_obj=new \App\controller\home\Setting();
        $setting=$set_obj->settingInfo()[0];
        $pg=new \App\controller\home\Page();
        $pages=$pg->getPages();

        $user_info=[];
    if(checkUserLogin()){
        $auth_obj = new \App\controller\home\Auth();
        $user_id=getUserEncryptInfo()['user_id'];
        $user_info=$auth_obj->getUserInfo($user_id)[0];
    }

@endphp


<nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{baseUrl(httpCheck()).$setting['large_logo_dark']}}" alt="{{$setting['large_logo_dark_alt']}}"
                 class="card-logo card-logo-dark" height="17">
            <img src="{{baseUrl(httpCheck()).$setting['large_logo_light']}}" alt="{{$setting['large_logo_light_alt']}}"
                 class="card-logo card-logo-light" height="17">
        </a>
        <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                <li class="nav-item">
                    <a class="nav-link fs-15 {{isActive2("")?"active":''}} " href="/">خانه</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-15 {{isActive2("services")?"active":''}}" href="/services">سرویس ها</a>
                </li>
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link fs-15" href="#">اخبار</a>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link fs-15" href="#">وبلاگ</a>--}}
                {{--                </li>--}}

                @foreach($pages as $page)
                    <li class="nav-item">
                        <a class="nav-link fs-15 {{isActive2($page['page_url'])?"active":''}} "
                           href="{{$page['page_url']}}">{{$page['title']}}</a>
                    </li>
                @endforeach
                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link fs-15" href="#">ارتباط با ما</a>--}}
                {{--                </li>--}}
            </ul>

            <div class="">
                @if(empty($user_info))
                <a href="/signin" class="btn btn-link fw-medium text-decoration-none text-dark">ورود</a>
                <a href="/signup" class="btn btn-primary">ثبت نام</a>
                @else
                    <a href="/signout" class="btn btn-link fw-medium text-decoration-none text-danger">خروج</a>
                @endif
            </div>
        </div>

    </div>
</nav>


