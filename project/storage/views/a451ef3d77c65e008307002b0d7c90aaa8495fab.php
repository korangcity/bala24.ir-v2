

<?php $__env->startSection("title","مدیریت سایت | ایجاد راهنمای سرویس"); ?>


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
                                <h4 class="card-title mb-0 flex-grow-1"> راهنمای سرویس</h4>
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
                                    <form action="/adminpanel/Service-createGuideProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="<?php echo e($token); ?>">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان راهنمای سرویس
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
                                                                   name="guideImage">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control mb-2"
                                                                   name="guideImageAlt"
                                                                   placeholder="مقدار alt تصویر را وارد کنید.">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">

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

<?php echo $__env->make("admin.fa.layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\bala24.ir-v2\project\view/admin/fa/service/guide_create.blade.php ENDPATH**/ ?>