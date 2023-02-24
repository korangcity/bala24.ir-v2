

<?php $__env->startSection("title","مدیریت سایت | ایجاد نمونه سرویس"); ?>


<?php $__env->startSection("head"); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"> نمونه سرویس</h4>
                            </div>

                            <div class="card-body">
                                <div class="live-preview">
                                    <?php if(!empty(getErrors())): ?>
                                        <div class="alert alert-danger col-md-6 col-sm-12">
                                            <ul>
                                                <?php $__currentLoopData = getErrors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($error); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <form action="/adminpanel/Service-createSampleServiceProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="<?php echo e($token); ?>">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h6 class="fw-semibold">دسته بندی سرویس <span
                                                            class="text-danger">*</span></h6>
                                                <select class="js-example-basic-single form-control"
                                                        name="category">
                                                    <option value="">انتخاب کنید</option>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category['id']); ?>" <?php echo e(old("category")==$category['id']?'selected':''); ?>><?php echo e($category['title']); ?></option>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان نمونه سرویس
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="<?php echo e(old('title')??''); ?>"
                                                           class="form-control"
                                                           placeholder="عنوان " id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="brief_description" class="form-label">توضیح مختصر
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="brief_description" id="brief_description"
                                                              value="" id="" cols="30"
                                                              rows="5"
                                                              class="form-control"><?php echo e(old('brief_description')??''); ?></textarea>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="h1_title" class="form-label">عنوان H1
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="h1_title" value="<?php echo e(old('h1_title')??''); ?>"
                                                           class="form-control"
                                                           placeholder="عنوان H1" id="h1_title">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">متن نمونه سرویس
                                                <span class="text-danger">*</span></label>
                                            <textarea name="description" id="editor" cols="30"
                                                      rows="10"><?php echo e(old("description")??''); ?></textarea>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 mt-2">
                                                <div class="mb-3">
                                                    <label for="keywords" class="form-label">کلمات کلیدی(با علامت + از
                                                        هم جدا شود)
                                                    </label>
                                                    <input type="text" name="keywords" value="<?php echo e(old('keywords')??''); ?>"
                                                           class="form-control"
                                                           placeholder="مثال : مهدی+زهرا + ..." id="title">
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="justify-content-between d-flex align-items-center mb-3">
                                                    <h5 class="mb-0 pb-1 ">تصویر (فرمت مجاز:
                                                        jpg,jpeg,png,svg,gif)</h5>
                                                </div>


                                                <div class=" resultAddImage">
                                                    <div class="d-flex">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="sampleServiceImages[]">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="sampleServiceImageAlts[]"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2 mt-2">
                                                <button type="button" class="btn btn-info addImage">افزودن تصویر دیگر
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">











                                            <hr>
                                            <h4 class=" text-bold">SEO</h4>
                                            <div class="row mt-3">
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageUrl" class="form-label">Url صفحه </label>
                                                    <input type="text" name="pageUrl" class="form-control"
                                                           placeholder="pageUrl وارد کنید "
                                                           value="<?php echo e(old('pageUrl')??''); ?>" id="pageUrl">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageTitle" class="form-label">Title صفحه </label>
                                                    <input type="text" name="pageTitle" class="form-control"
                                                           placeholder="pageTitle وارد کنید "
                                                           value="<?php echo e(old('pageTitle')??''); ?>" id="pageTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageDescription" class="form-label">صفحهDescription
                                                    </label>
                                                    <input type="text" name="pageDescription" class="form-control"
                                                           placeholder="pageDescription وارد کنید "
                                                           value="<?php echo e(old('pageDescription')??''); ?>" id="pageDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageKeywords" class="form-label">Keywords صفحه (
                                                        با + جدا کنید)</label>
                                                    <input type="text" name="pageKeywords"
                                                           value="<?php echo e(old('pageKeywords')??''); ?>" class="form-control"
                                                           placeholder="مثال: مهدی + زهرا + ... " id="pagKeywordsn">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="text-danger">og means open graph</span>
                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgTitle" class="form-label">og:Title صفحه </label>
                                                    <input type="text" name="pageOgTitle"
                                                           value="<?php echo e(old('pageOgTitle')??''); ?>" class="form-control"
                                                           placeholder="pageOgTitle وارد کنید " id="pageOgTitle">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgDescription" class="form-label">og:Description
                                                        صفحه
                                                    </label>
                                                    <input type="text" name="pageOgDescription"
                                                           value="<?php echo e(old('pageOgDescription')??''); ?>" class="form-control"
                                                           placeholder="pageOgDescription وارد کنید "
                                                           id="pageOgDescription">
                                                </div>

                                                <div class="col-md-4 col-sm-8 mb-3">
                                                    <label for="pageOgType" class="form-label">og:Type صفحه </label>
                                                    <div>
                                                        <select name="pageOgType" id="pageOgType"
                                                                class="form-select rounded-pill mb-3"
                                                                aria-label="Default select example">
                                                            <option value="website" <?php echo e(old('pageOgType')=="website"?'selected':''); ?>>
                                                                website
                                                            </option>
                                                            <option value="article" <?php echo e(old('pageOgType')=="article"?'selected':''); ?>>
                                                                مقاله
                                                            </option>
                                                            <option value="blog" <?php echo e(old('pageOgType')=="blog"?'selected':''); ?>>
                                                                وبلاگ
                                                            </option>
                                                            <option value="book" <?php echo e(old('pageOgType')=="book"?'selected':''); ?>>
                                                                کتاب
                                                            </option>
                                                            <option value="game" <?php echo e(old('pageOgType')=="game"?'selected':''); ?>>
                                                                بازی
                                                            </option>
                                                            <option value="film" <?php echo e(old('pageOgType')=="film"?'selected':''); ?>>
                                                                فیلم
                                                            </option>
                                                            <option value="food" <?php echo e(old('pageOgType')=="food"?'selected':''); ?>>
                                                                غذا
                                                            </option>
                                                            <option value="city" <?php echo e(old('pageOgType')=="city"?'selected':''); ?>>
                                                                شهر
                                                            </option>
                                                            <option value="country" <?php echo e(old('pageOgType')=="country"?'selected':''); ?>>
                                                                کشور
                                                            </option>
                                                            <option value="actor" <?php echo e(old('pageOgType')=="actor"?'selected':''); ?>>
                                                                بازیگر
                                                            </option>
                                                            <option value="author" <?php echo e(old('pageOgType')=="author"?'selected':''); ?>>
                                                                نویسنده
                                                            </option>
                                                            <option value="politician" <?php echo e(old('pageOgType')=="politician"?'selected':''); ?>>
                                                                سیاسی
                                                            </option>
                                                            <option value="company" <?php echo e(old('pageOgType')=="company"?'selected':''); ?>>
                                                                شرکت
                                                            </option>
                                                            <option value="hotel" <?php echo e(old('pageOgType')=="hotel"?'selected':''); ?>>
                                                                هتل
                                                            </option>
                                                            <option value="restaurant" <?php echo e(old('pageOgType')=="restaurant"?'selected':''); ?>>
                                                                رستوران
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <p><span class="text-danger text-bold"> درباره og:type </span> در اغلب مواقع
                                                شما از نوع website استفاده می کنید، چرا که شما در حال اشتراک گذاری یک
                                                لینک از وبسایت در فیسبوک هستید. در واقع اگر این متا تگ را تعریف نکرده
                                                باشید، فیسبوک به صورت اتوماتیک آن را از نوع website خواهد دید.</p>

                                            <div class="row mt-2">
                                                <div class="col-lg-12">
                                                    <div class="justify-content-between d-flex align-items-center mb-3">
                                                        <h5 class="mb-0 pb-1 ">صفحه  og:image (allowed format:
                                                            jpg,jpeg,png,svg,gif)</h5>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control mb-2"
                                                                   name="sampleServiceOgImage">
                                                        </div>
                                                        <p><span class="text-danger text-bold"> درباره og:image  </span>
                                                        <p>این مورد جذاب ترین متا تگ Open Graph در بین بازاریابین است،
                                                            چرا که یک تصویر می تواند کمک زیادی به افزایش جذابیت یک مطلب
                                                            کند. با استفاده از این متا تگ می توانید تصویر مورد نظر خود
                                                            در هنگام به اشتراک گذاشتن یک محتوا را مشخص کنید. بنابراین
                                                            استفاده از این متا تگ می تواند تاثیر زیادی در افزایش نرخ
                                                            تبدیل داشته باشد.</p>
                                                        ابعاد پیشنهادی برای عکس در این متا تگ 1200 در 627 پیکسل می باشد.
                                                        با این ابعاد عکس شما به اندازه کافی بزرگ بوده و مورد توجه قرار
                                                        خواهد گرفت. دقت داشته باشید که حجم عکستان بیش از 5MB نباشد.</p>

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

<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/select2.init.js"></script>

    <script src="https://cdn.ckeditor.com/4.16.2/full-all/ckeditor.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/prismjs/prism.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/app.js"></script>

    <script>

        CKEDITOR.addCss('figure[class*=easyimage-gradient]::before { content: ""; position: absolute; top: 0; bottom: 0; left: 0; right: 0; }' +
            'figure[class*=easyimage-gradient] figcaption { position: relative; z-index: 2; }' +
            '.easyimage-gradient-1::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 66, 174, 234, .72 ) 100% ); }' +
            '.easyimage-gradient-2::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 228, 66, 234, .72 ) 100% ); }');

        CKEDITOR.replace('editor', {
            extraPlugins: 'image2,uploadimage',
            removePlugins: 'image',
            language: 'fa',
            editorplaceholder: 'متن خود را اینجا درج نمایید',
            filebrowserUploadUrl: "/adminpanel/Setting-uploadCkeditorFile",
            filebrowserUploadMethod: 'form'

        });


        $(".addImage").click(function () {
            $(".resultAddImage").append('<div class="d-flex"><div class="col-lg-6">' +
                '<input type="file" class="form-control mb-2" name="sampleServiceImages[]">' +
                '</div> <div class="col-lg-6">' +
                '<input type="text" placeholder="مقدار alt تصویر را وارد کنید" class="form-control mb-2" name="sampleServiceImageAlts[]">' +
                '</div></div>');
        });

        <?php if($_REQUEST['error']): ?>
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

        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.fa.layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\bala24.ir-v2\project\view/admin/fa/service/sample_create.blade.php ENDPATH**/ ?>