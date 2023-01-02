@extends("admin.en.layout.app")

@section("title","website management | edit blog category")


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
                                <h4 class="card-title mb-0 flex-grow-1">Blog Category</h4>
                            </div>

                            <div class="card-body">
                                <p class="text-muted">Enter blog category title </p>
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
                                                    <label for="title" class="form-label">Category title (at least 3 characters)</label>
                                                    <input type="text" name="title" value="{{$category['title']}}" class="form-control"
                                                           placeholder="Enter category title" id="title">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">Category image (allowed format:
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
                                                    <label for="captcha" class="form-label">Captch</label>
                                                    <input type="text" name="captcha" class="form-control"
                                                           placeholder="Enter captcha" id="captcha">
                                                </div>
                                            </div>
                                            <hr>
                                            <h4 class=" text-bold">SEO</h4>
                                            <div class="row mt-3">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageUrl" class="form-label">Page Url</label>
                                                    <input type="text" name="pageUrl" class="form-control"
                                                           placeholder="Enter pageUrl " value="{{$category['page_url']??''}}" id="pageUrl">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageTitle" class="form-label">Page Title </label>
                                                    <input type="text" name="pageTitle" class="form-control"
                                                           placeholder="Enter pageTitle " value="{{$category['page_title_seo']??''}}" id="pageTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageDescription" class="form-label">Page
                                                        Description
                                                    </label>
                                                    <input type="text" name="pageDescription" class="form-control"
                                                           placeholder="Enter pageDescription " value="{{$category['page_description_seo']??''}}" id="pageDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageKeywords" class="form-label">Page Keywords (separate
                                                        with +)</label>
                                                    <input type="text" name="pageKeywords" value="{{$category['page_keywords_seo']??''}}" class="form-control"
                                                           placeholder="example : Mahdi+ Zahra +... " id="pagKeywordsn">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="text-danger">og means open graph</span>
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgTitle" class="form-label">Page og:Title</label>
                                                    <input type="text" name="pageOgTitle" value="{{$category['page_og_title_seo']??''}}" class="form-control"
                                                           placeholder="Enter pageOgTitle" id="pageOgTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgDescription" class="form-label">Page
                                                        og:Description</label>
                                                    <input type="text" name="pageOgDescription" value="{{$category['page_og_description_seo']??''}}" class="form-control"
                                                           placeholder="Enter pageOgDescription" id="pageOgDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgType" class="form-label">Page og:Type</label>
                                                    <div>
                                                        <select name="pageOgType" id="pageOgType"
                                                                class="form-select rounded-pill mb-3"
                                                                aria-label="Default select example">
                                                            <option value="website" {{$category['page_og_type_seo']=="website"?'selected':''}}>website</option>
                                                            <option value="article" {{$category['page_og_type_seo']=="article"?'selected':''}}>article</option>
                                                            <option value="blog" {{$category['page_og_type_seo']=="blog"?'selected':''}}>blog</option>
                                                            <option value="book" {{$category['page_og_type_seo']=="book"?'selected':''}}>book</option>
                                                            <option value="game" {{$category['page_og_type_seo']=="game"?'selected':''}}>game</option>
                                                            <option value="film" {{$category['page_og_type_seo']=="film"?'selected':''}}>film</option>
                                                            <option value="food" {{$category['page_og_type_seo']=="food"?'selected':''}}>food</option>
                                                            <option value="city" {{$category['page_og_type_seo']=="city"?'selected':''}}>city</option>
                                                            <option value="country" {{$category['page_og_type_seo']=="country"?'selected':''}}>country</option>
                                                            <option value="actor" {{$category['page_og_type_seo']=="actor"?'selected':''}}>actor</option>
                                                            <option value="author" {{$category['page_og_type_seo']=="author"?'selected':''}}>author</option>
                                                            <option value="politician" {{$category['page_og_type_seo']=="politician"?'selected':''}}>politician</option>
                                                            <option value="company" {{$category['page_og_type_seo']=="company"?'selected':''}}>company</option>
                                                            <option value="hotel" {{$category['page_og_type_seo']=="hotel"?'selected':''}}>hotel</option>
                                                            <option value="restaurant" {{$category['page_og_type_seo']=="restaurant"?'selected':''}}>restaurant</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p><span class="text-danger text-bold">About og:type</span> Most of the time
                                                you use the website type because you are sharing a link from the website
                                                on Facebook.
                                                In fact, if you have not defined this meta tag, Facebook will
                                                automatically see it as a website.</p>

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
                                                        <p><span class="text-danger text-bold">About og:image </span>
                                                        <p>This is the most attractive Open Graph meta tag among
                                                            marketers, because an image can help a lot to increase the
                                                            attractiveness of an article. By using this meta tag, you
                                                            can specify the image you want when sharing a content.
                                                            Therefore, using this meta tag can have a great effect on
                                                            increasing the conversion rate.</p>
                                                        The suggested dimensions for the photo in this meta tag are 1200
                                                        x 627 pixels. With these dimensions, your photo will be large
                                                        enough and will be noticed. Make sure that the size of your
                                                        photo is not more than 5MB.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="text-start">
                                                    <button type="submit" class="btn btn-primary">Send</button>
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
                '<div class="mt-4 pt-2 fs-15"><h4>Your request encountered an error.!</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "Ok",
            buttonsStyling: !1,
            showCloseButton: !0
        })

        @endif
    </script>
@endsection
