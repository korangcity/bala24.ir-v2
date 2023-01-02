@extends("admin.ar.layout.app")

@section("title","إدارة الموقع |تحرير الأخبار")


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
                                <h4 class="card-title mb-0 flex-grow-1"> الأخبار</h4>
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
                                    <form action="/adminpanel/News-editNewsProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="news_id" value="{{$news["id"]}}">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h6 class="fw-semibold">فئة الأخبار <span
                                                            class="text-danger">*</span></h6>
                                                <select class="js-example-basic-single form-control"
                                                        name="category">
                                                    <option value="">يختار</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category['id']}}" {{$news["category_id"]==$category['id']?'selected':''}}>{{$category['title']}}</option>

                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان الأخبار
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{$news["title"]}}"
                                                           class="form-control"
                                                           placeholder="عنوان الأخبار" id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="brief_description" class="form-label">شرح موجز
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="brief_description" id="brief_description"
                                                              value="" id="" cols="30"
                                                              rows="5"
                                                              class="form-control">{{$news["brief_description"]}}</textarea>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="h1_title" class="form-label">العنوان H1
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="h1_title" value="{{$news["h1_title"]}}"
                                                           class="form-control"
                                                           placeholder="العنوان H1" id="title">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">نص الأخبار
                                                <span class="text-danger">*</span></label>
                                            <textarea name="description" id="editor" cols="30"
                                                      rows="10">{{$news["description"]}}</textarea>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 mt-2">
                                                <div class="mb-3">
                                                    <label for="keywords" class="form-label">الكلمات الرئيسية (منفصلة بعلامة +)
                                                    </label>
                                                    <input type="text" name="keywords" value="{{$news["keywords"]}}"
                                                           class="form-control"
                                                           placeholder="مثال : مهدی+زهرا + ..." id="title">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            @foreach(json_decode($news["images"]) as $key=>$image)
                                            <div class="col-4">
                                                <img src="{{baseUrl(httpCheck()).$image}}" class="img-thumbnail d-block" alt="">
                                                <input type="text" class="form-control d-block mx-auto mt-2" name="" value="{{json_decode($news["alts"])[$key]}}" disabled id="">
                                                <button type="button" class="btn btn-outline-danger btn-sm deleteImg d-block mx-auto mt-2" data-key="{{$key+1}}">حذف</button>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">صورة  (التنسيق المسموح به:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class=" resultAddImage">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="newsImages[]">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="newsImageAlts[]"
                                                                   placeholder="أدخل القيمة alt للصورة.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2 mt-2">
                                                <button type="button" class="btn btn-info addImage">أضف صورة أخرى
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="">

                                                <img src="{{$builder->inline()}}"/>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="captcha" class="form-label">كلمة التحقق</label>
                                                    <input type="text" name="captcha" class="form-control"
                                                           placeholder="أدخل كلمة التحقق" id="captcha">
                                                </div>
                                            </div>
                                            <hr>
                                            <h4 class=" text-bold">SEO</h4>
                                            <div class="row mt-3">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageUrl" class="form-label">Page Url  </label>
                                                    <input type="text" name="pageUrl" class="form-control"
                                                           placeholder="أدخل pageUrl "
                                                           value="{{$news['page_url']}}" id="pageUrl">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageTitle" class="form-label">Page Title  </label>
                                                    <input type="text" name="pageTitle" class="form-control"
                                                           placeholder="أدخل pageTitle "
                                                           value="{{$news['page_title_seo']}}" id="pageTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageDescription" class="form-label">Page
                                                        Description</label>
                                                    <input type="text" name="pageDescription" class="form-control"
                                                           placeholder="أدخل pageDescription  "
                                                           value="{{$news['page_description_seo']}}" id="pageDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageKeywords" class="form-label">Page Keywords (separate
                                                        with +)</label>
                                                    <input type="text" name="pageKeywords"
                                                           value="{{$news['page_keywords_seo']}}" class="form-control"
                                                           placeholder="مثال: مهدی + زهرا + ... " id="pagKeywordsn">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="text-danger">og means open graph</span>
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgTitle" class="form-label">Page og:Title</label>
                                                    <input type="text" name="pageOgTitle"
                                                           value="{{$news['page_og_title_seo']}}" class="form-control"
                                                           placeholder="أدخل pageOgTitle" id="pageOgTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgDescription" class="form-label">Page
                                                        og:Description</label>
                                                    <input type="text" name="pageOgDescription"
                                                           value="{{$news['page_og_description_seo']}}" class="form-control"
                                                           placeholder="أدخل pageOgDescription"
                                                           id="pageOgDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgType" class="form-label">Page og:Type</label>
                                                    <div>
                                                        <select name="pageOgType" id="pageOgType"
                                                                class="form-select rounded-pill mb-3"
                                                                aria-label="Default select example">
                                                            <option value="website" {{$news['page_og_type_seo']=="website"?'selected':''}}>
                                                                موقع على الإنترنت
                                                            </option>
                                                            <option value="article" {{$news['page_og_type_seo']=="article"?'selected':''}}>
                                                                مقالة
                                                            </option>
                                                            <option value="blog" {{$news['page_og_type_seo']=="blog"?'selected':''}}>
                                                                المدونات
                                                            </option>
                                                            <option value="book" {{$news['page_og_type_seo']=="book"?'selected':''}}>
                                                                الكتاب
                                                            </option>
                                                            <option value="game" {{$news['page_og_type_seo']=="game"?'selected':''}}>
                                                                لعبه
                                                            </option>
                                                            <option value="film" {{$news['page_og_type_seo']=="film"?'selected':''}}>
                                                                فيلم
                                                            </option>
                                                            <option value="food" {{$news['page_og_type_seo']=="food"?'selected':''}}>
                                                                غذاء
                                                            </option>
                                                            <option value="city" {{$news['page_og_type_seo']=="city"?'selected':''}}>
                                                                مدينة
                                                            </option>
                                                            <option value="country" {{$news['page_og_type_seo']=="country"?'selected':''}}>
                                                                بلد
                                                            </option>
                                                            <option value="actor" {{$news['page_og_type_seo']=="actor"?'selected':''}}>
                                                                الممثل
                                                            </option>
                                                            <option value="author" {{$news['page_og_type_seo']=="author"?'selected':''}}>
                                                                مؤلف
                                                            </option>
                                                            <option value="politician" {{$news['page_og_type_seo']=="politician"?'selected':''}}>
                                                                سياسي
                                                            </option>
                                                            <option value="company" {{$news['page_og_type_seo']=="company"?'selected':''}}>
                                                                شركة
                                                            </option>
                                                            <option value="hotel" {{$news['page_og_type_seo']=="hotel"?'selected':''}}>
                                                                الفندق
                                                            </option>
                                                            <option value="restaurant" {{$news['page_og_type_seo']=="restaurant"?'selected':''}}>
                                                                مطعم
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p><span class="text-danger text-bold">حول og:type</span> في معظم الأوقات تستخدم نوع موقع الويب لأنك تشارك رابطًا من موقع الويب على Facebook. في الواقع ، إذا لم تقم بتعريف علامة meta tag هذه ، فسوف يراها Facebook تلقائيًا كموقع ويب.</p>


                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <div class="justify-content-between d-flex align-items-center mb-3">
                                                        <h5 class="mb-0 pb-1 "> page og:image (allowed format:
                                                            jpg,jpeg,png,svg,gif)</h5>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="newsOgImage">
                                                        </div>
                                                        <p>هذه هي العلامة الوصفية لـ Open Graph الأكثر جاذبية بين المسوقين ، لأن الصورة يمكن أن تساعد كثيرًا في زيادة جاذبية المقالة. باستخدام علامة meta tag هذه ، يمكنك تحديد الصورة التي تريدها عند مشاركة محتوى ، لذلك يمكن أن يكون لاستخدام العلامة الوصفية تأثير كبير في زيادة معدل التحويل.</p>
                                                        الأبعاد المقترحة للصورة في هذه العلامة الوصفية هي 1200 × 627 بكسل. بهذه الأبعاد ، ستكون صورتك كبيرة بما يكفي وستلاحظ. تأكد من أن حجم صورتك لا يزيد عن 5 ميغا بايت.</p>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="text-start">
                                                    <button type="submit" class="btn btn-primary">إرسال</button>
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
            language: 'ar',
            editorplaceholder: 'أدخل النص الخاص بك هنا',
            filebrowserUploadUrl: "/adminpanel/Setting-uploadCkeditorFile",
            filebrowserUploadMethod: 'form'

        });


        $(".addImage").click(function () {
            $(".resultAddImage").append('<div class="d-flex"><div class="col-lg-6">' +
                '<input type="file" class="form-control mb-2" name="newsImages[]">' +
                '</div> <div class="col-lg-6">' +
                '<input type="text" placeholder="أدخل القيمة alt للصورة." class="form-control mb-2" name="newsImageAlts[]">' +
                '</div></div>');
        });

        $(".deleteImg").click(function(){
            let image_no=$(this).data('key');
            let news_id="{{$news['id']}}";
            let chk=confirm("هل أنت متأكد من حذف الصورة المطلوبة؟");
            if(chk){
                $.ajax({
                    type:'post',
                    url:'/adminpanel/News-newsDeleteImage',
                    data:{image_no:image_no,news_id:news_id},
                    success:function(response){
                        window.location.href="/adminpanel/News-newsList?success=true"
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
                '<div class="mt-4 pt-2 fs-15"><h4>واجه الطلب المطلوب خطأ!</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "فهمت",
            buttonsStyling: !1,
            showCloseButton: !0
        })

        @endif

    </script>
@endsection
