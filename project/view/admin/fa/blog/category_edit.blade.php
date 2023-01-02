@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | ویرایش دسته بندی وبلاگ")

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
                                <h4 class="card-title mb-0 flex-grow-1">دسته بندی وبلاگ</h4>
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
                                    <form action="/adminpanel/Blog-blogCategoryEditProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="category_id" value="{{$category['id']}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان دسته بندی (حداقل 3 کاراکتر) <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{$category['title']}}" class="form-control"
                                                           placeholder="Enter category title" id="title">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">تصویر دسته بندی (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6">

                                                        <input type="file" class="form-control mb-2"
                                                               name="categoryImage">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="">

                                                <img src="{{$builder->inline()}}"/>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="captcha" class="form-label">کپچا</label>
                                                    <input type="text" name="captcha" class="form-control"
                                                           placeholder="Enter captcha" id="captcha">
                                                </div>
                                            </div>

                                            <hr>
                                            <h4 class=" text-bold">SEO</h4>
                                            <div class="row mt-3">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageUrl" class="form-label">Url صفحه </label>
                                                    <input type="text" name="pageUrl" class="form-control"
                                                           placeholder="pageUrl وارد کنید " value="{{$category['page_url']??''}}" id="pageUrl">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageTitle" class="form-label">Title صفحه </label>
                                                    <input type="text" name="pageTitle" class="form-control"
                                                           placeholder="pageTitle وارد کنید " value="{{$category['page_title_seo']??''}}" id="pageTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageDescription" class="form-label">صفحهDescription
                                                    </label>
                                                    <input type="text" name="pageDescription" class="form-control"
                                                           placeholder="pageDescription وارد کنید " value="{{$category['page_description_seo']??''}}" id="pageDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageKeywords" class="form-label">Keywords صفحه  (
                                                        با + جدا کنید)</label>
                                                    <input type="text" name="pageKeywords" value="{{$category['page_keywords_seo']??''}}" class="form-control"
                                                           placeholder="مثال: مهدی + زهرا + ... " id="pagKeywordsn">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="text-danger">og means open graph</span>
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgTitle" class="form-label">og:Title صفحه </label>
                                                    <input type="text" name="pageOgTitle" value="{{$category['page_og_title_seo']??''}}" class="form-control"
                                                           placeholder="pageOgTitle وارد کنید " id="pageOgTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgDescription" class="form-label">og:Description صفحه
                                                    </label>
                                                    <input type="text" name="pageOgDescription" value="{{$category['page_og_description_seo']??''}}" class="form-control"
                                                           placeholder="pageOgDescription وارد کنید " id="pageOgDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgType" class="form-label">og:Type صفحه </label>
                                                    <div>
                                                        <select name="pageOgType" id="pageOgType"
                                                                class="form-select rounded-pill mb-3"
                                                                aria-label="Default select example">
                                                            <option value="website" {{$category['page_og_type_seo']=="website"?'selected':''}}>website</option>
                                                            <option value="article" {{$category['page_og_type_seo']=="article"?'selected':''}}>مقاله</option>
                                                            <option value="blog" {{$category['page_og_type_seo']=="blog"?'selected':''}}>وبلاگ</option>
                                                            <option value="book" {{$category['page_og_type_seo']=="book"?'selected':''}}>کتاب</option>
                                                            <option value="game" {{$category['page_og_type_seo']=="game"?'selected':''}}>بازی</option>
                                                            <option value="film" {{$category['page_og_type_seo']=="film"?'selected':''}}>فیلم</option>
                                                            <option value="food" {{$category['page_og_type_seo']=="food"?'selected':''}}>غذا</option>
                                                            <option value="city" {{$category['page_og_type_seo']=="city"?'selected':''}}>شهر</option>
                                                            <option value="country" {{$category['page_og_type_seo']=="country"?'selected':''}}>کشور</option>
                                                            <option value="actor" {{$category['page_og_type_seo']=="actor"?'selected':''}}>بازیگر</option>
                                                            <option value="author" {{$category['page_og_type_seo']=="author"?'selected':''}}>نویسنده</option>
                                                            <option value="politician" {{$category['page_og_type_seo']=="politician"?'selected':''}}>سیاسی</option>
                                                            <option value="company" {{$category['page_og_type_seo']=="company"?'selected':''}}>شرکت</option>
                                                            <option value="hotel" {{$category['page_og_type_seo']=="hotel"?'selected':''}}>هتل</option>
                                                            <option value="restaurant" {{$category['page_og_type_seo']=="restaurant"?'selected':''}}>رستوران</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p><span class="text-danger text-bold"> درباره og:type </span> در اغلب مواقع شما از نوع website استفاده می کنید، چرا که شما در حال اشتراک گذاری یک لینک از وبسایت در فیسبوک هستید. در واقع اگر این متا تگ را تعریف نکرده باشید، فیسبوک به صورت اتوماتیک آن را از نوع website خواهد دید.</p>

                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <div class="justify-content-between d-flex align-items-center mb-3">
                                                        <h5 class="mb-0 pb-1 ">صفحه دسته بندی og:image (allowed format:
                                                            jpg,jpeg,png,svg,gif)</h5>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="categoryOgImage">
                                                        </div>
                                                        <p><span class="text-danger text-bold"> درباره og:image </span>
                                                        <p>این مورد جذاب ترین متا تگ Open Graph در بین بازاریابین است، چرا که یک تصویر می تواند کمک زیادی به افزایش جذابیت یک مطلب کند. با استفاده از این متا تگ می توانید تصویر مورد نظر خود در هنگام به اشتراک گذاشتن یک محتوا را مشخص کنید. بنابراین استفاده از این متا تگ می تواند تاثیر زیادی در افزایش نرخ تبدیل داشته باشد.</p>
                                                        ابعاد پیشنهادی برای عکس در این متا تگ 1200 در 627 پیکسل می باشد. با این ابعاد عکس شما به اندازه کافی بزرگ بوده و مورد توجه قرار خواهد گرفت. دقت داشته باشید که حجم عکستان بیش از 5MB نباشد.</p>

                                                    </div>
                                                </div>
                                            </div>

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
