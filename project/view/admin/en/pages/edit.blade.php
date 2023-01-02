@extends("admin.en.layout.app")

@section("title","website management | edit page")


@section("head")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
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
                                <h4 class="card-title mb-0 flex-grow-1"> page</h4>
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
                                    <form action="/adminpanel/Page-editPageProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="page_id" value="{{$page["id"]}}">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Page title
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{$page["title"]}}"
                                                           class="form-control"
                                                           placeholder="title " id="title">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="h1_title" class="form-label"> H1 title
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="h1_title" value="{{$page["h1_title"]}}"
                                                           class="form-control"
                                                           placeholder=" H1 title" id="title">
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label for="brief_description" class="form-label">Brief description
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="brief_description" id="brief_description"
                                                              value="" id="" cols="30"
                                                              rows="5"
                                                              class="form-control">{{$page["brief_description"]}}</textarea>

                                                </div>
                                            </div>



                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Content
                                                <span class="text-danger">*</span></label>
                                            <textarea name="description" id="editor" cols="30"
                                                      rows="10">{{$page["description"]}}</textarea>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 mt-2">
                                                <div class="mb-3">
                                                    <label for="keywords" class="form-label">Keywords (separate with +)
                                                    </label>
                                                    <input type="text" name="keywords" value="{{$page["keywords"]}}"
                                                           class="form-control"
                                                           placeholder="example : Mahdi+ Zahra +..." id="keywords">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            @foreach(json_decode($page["images"]) as $key=>$image)
                                            <div class="col-4">
                                                <img src="{{baseUrl(httpCheck()).$image}}" class="img-thumbnail d-block" alt="">
                                                <input type="text" class="form-control d-block mx-auto mt-2" name="" value="{{json_decode($page["alts"])[$key]}}" disabled id="">
                                                <button type="button" class="btn btn-outline-danger btn-sm deleteImg d-block mx-auto mt-2" data-key="{{$key+1}}">delete</button>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="row">
                                            <h4>Social networks</h4>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="telegram" class="form-label">Telegram
                                                    </label>
                                                    <input type="text" name="telegram" value="{{$page['telegram']??''}}"
                                                           class="form-control"
                                                           placeholder="Telegram" id="telegram">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="instagram" class="form-label">Instagram
                                                    </label>
                                                    <input type="text" name="instagram" value="{{$page['instagram']??''}}"
                                                           class="form-control"
                                                           placeholder="Instagram" id="instagram">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="whatsapp" class="form-label">WhatsApp
                                                    </label>
                                                    <input type="text" name="whatsapp" value="{{$page['whatsapp']??''}}"
                                                           class="form-control"
                                                           placeholder="WhatsApp" id="whatsapp">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="linkedin" class="form-label">LinkedIn
                                                    </label>
                                                    <input type="text" name="linkedin" value="{{$page['linkedin']??''}}"
                                                           class="form-control"
                                                           placeholder="LinkedIn" id="linkedin">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email
                                                    </label>
                                                    <input type="text" name="email" value="{{$page['email']??''}}"
                                                           class="form-control"
                                                           placeholder="Email" id="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone1" class="form-label">Phone1
                                                    </label>
                                                    <input type="text" name="phone1" value="{{$page['phone1']??''}}"
                                                           class="form-control"
                                                           placeholder="Phone1" id="phone1">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone2" class="form-label">Phone2
                                                    </label>
                                                    <input type="text" name="phone2" value="{{$page['phone2']??''}}"
                                                           class="form-control"
                                                           placeholder="Phone2" id="phone2">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone3" class="form-label">Phone3
                                                    </label>
                                                    <input type="text" name="phone3" value="{{$page['phone3']??''}}"
                                                           class="form-control"
                                                           placeholder="Phone3" id="phone3">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <h4>Location</h4>
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">Location
                                                    </label>
                                                    <input type="text" name="location" value="{{$page['location']??''}}"
                                                           class="form-control"
                                                           placeholder="Location from Google Map" id="location">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 "> image (allowed format:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class=" resultAddImage">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="pageImages[]">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="pageImageAlts[]"
                                                                   placeholder="Enter the alt value">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2 mt-2">
                                                <button type="button" class="btn btn-info addImage">Add another image
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="">

                                                <img src="{{$builder->inline()}}"/>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="captcha" class="form-label">Captcha</label>
                                                    <input type="text" name="captcha" class="form-control"
                                                           placeholder="Enter captcha" id="captcha">
                                                </div>
                                            </div>
                                            <hr>
                                            <h4 class=" text-bold">SEO</h4>
                                            <div class="row mt-3">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageUrl" class="form-label">Page Url </label>
                                                    <input type="text" name="pageUrl" class="form-control"
                                                           placeholder="Enter PageUrl"
                                                           value="{{$page['page_url']}}" id="pageUrl">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageTitle" class="form-label">Page title </label>
                                                    <input type="text" name="pageTitle" class="form-control"
                                                           placeholder="Enter page title "
                                                           value="{{$page['page_title_seo']}}" id="pageTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageDescription" class="form-label">Page
                                                        Description
                                                    </label>
                                                    <input type="text" name="pageDescription" class="form-control"
                                                           placeholder="Enter pageDescription "
                                                           value="{{$page['page_description_seo']}}" id="pageDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageKeywords" class="form-label">Page Keywords (separate
                                                        with +)
                                                    </label>
                                                    <input type="text" name="pageKeywords"
                                                           value="{{$page['page_keywords_seo']}}" class="form-control"
                                                           placeholder="example : Mahdi+ Zahra +..." id="pagKeywordsn">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="text-danger">og means open graph</span>
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgTitle" class="form-label">Page og:Title </label>
                                                    <input type="text" name="pageOgTitle"
                                                           value="{{$page['page_og_title_seo']}}" class="form-control"
                                                           placeholder="Enter pageOgTitle " id="pageOgTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgDescription" class="form-label">Page
                                                        og:Description
                                                    </label>
                                                    <input type="text" name="pageOgDescription"
                                                           value="{{$page['page_og_description_seo']}}" class="form-control"
                                                           placeholder="Enter pageOgDescription "
                                                           id="pageOgDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgType" class="form-label">Page og:Type </label>
                                                    <div>
                                                        <select name="pageOgType" id="pageOgType"
                                                                class="form-select rounded-pill mb-3"
                                                                aria-label="Default select example">
                                                            <option value="website" {{$page['page_og_type_seo']=="website"?'selected':''}}>
                                                                website
                                                            </option>
                                                            <option value="article" {{$page['page_og_type_seo']=="article"?'selected':''}}>
                                                                article
                                                            </option>
                                                            <option value="blog" {{$page['page_og_type_seo']=="blog"?'selected':''}}>
                                                                blog
                                                            </option>
                                                            <option value="book" {{$page['page_og_type_seo']=="book"?'selected':''}}>
                                                                book
                                                            </option>
                                                            <option value="game" {{$page['page_og_type_seo']=="game"?'selected':''}}>
                                                                game
                                                            </option>
                                                            <option value="film" {{$page['page_og_type_seo']=="film"?'selected':''}}>
                                                                film
                                                            </option>
                                                            <option value="food" {{$page['page_og_type_seo']=="food"?'selected':''}}>
                                                                food
                                                            </option>
                                                            <option value="city" {{$page['page_og_type_seo']=="city"?'selected':''}}>
                                                                city
                                                            </option>
                                                            <option value="country" {{$page['page_og_type_seo']=="country"?'selected':''}}>
                                                                country
                                                            </option>
                                                            <option value="actor" {{$page['page_og_type_seo']=="actor"?'selected':''}}>
                                                                actor
                                                            </option>
                                                            <option value="author" {{$page['page_og_type_seo']=="author"?'selected':''}}>
                                                                author
                                                            </option>
                                                            <option value="politician" {{$page['page_og_type_seo']=="politician"?'selected':''}}>
                                                                politician
                                                            </option>
                                                            <option value="company" {{$page['page_og_type_seo']=="company"?'selected':''}}>
                                                                company
                                                            </option>
                                                            <option value="hotel" {{$page['page_og_type_seo']=="hotel"?'selected':''}}>
                                                                hotel
                                                            </option>
                                                            <option value="restaurant" {{$page['page_og_type_seo']=="restaurant"?'selected':''}}>
                                                                restaurant
                                                            </option>
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
                                                        <h5 class="mb-0 pb-1 "> page og:image (allowed format:
                                                            jpg,jpeg,png,svg,gif)</h5>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="pageOgImage">
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
                                                    <button type="submit" class="btn btn-primary">Submit</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/select2.init.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.2/full-all/ckeditor.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/prismjs/prism.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>

    <script>

        CKEDITOR.addCss('figure[class*=easyimage-gradient]::before { content: ""; position: absolute; top: 0; bottom: 0; left: 0; right: 0; }' +
            'figure[class*=easyimage-gradient] figcaption { position: relative; z-index: 2; }' +
            '.easyimage-gradient-1::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 66, 174, 234, .72 ) 100% ); }' +
            '.easyimage-gradient-2::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 228, 66, 234, .72 ) 100% ); }');

        CKEDITOR.replace('editor', {
            extraPlugins: 'image2,uploadimage',
            removePlugins: 'image',
            language: 'en',
            editorplaceholder: 'insert your content',
            filebrowserUploadUrl: "/adminpanel/Setting-uploadCkeditorFile",
            filebrowserUploadMethod: 'form'

        });


        $(".addImage").click(function () {
            $(".resultAddImage").append('<div class="d-flex"><div class="col-lg-6">' +
                '<input type="file" class="form-control mb-2" name="pageImages[]">' +
                '</div> <div class="col-lg-6">' +
                '<input type="text"  placeholder="Enter alt value" class="form-control mb-2" name="pageImageAlts[]">' +
                '</div></div>');
        });

        $(".deleteImg").click(function(){
            let image_no=$(this).data('key');
            let page_id="{{$page['id']}}";
            let chk=confirm("Are you sure to delete image?");
            if(chk){
                $.ajax({
                    type:'post',
                    url:'/adminpanel/Page-pageDeleteImage',
                    data:{image_no:image_no,page_id:page_id},
                    success:function(response){
                        window.location.href="/adminpanel/Page-pageList"
                    },
                    error:function(){
                        alert("oops")
                    }
                });
            }
        });
        @if($_REQUEST['error'])
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>Your request encountered an error.</h4>' +
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
