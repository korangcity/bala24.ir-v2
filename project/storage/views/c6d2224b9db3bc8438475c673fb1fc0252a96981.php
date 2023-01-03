

<?php $__env->startSection("head"); ?>

    <link href="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="auth-page-wrapper pt-5">

                <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
                    <div class="bg-overlay"></div>

                    <div class="shape">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 0 1440 120">
                            <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                        </svg>
                    </div>
                </div>


                <div class="auth-page-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center mt-sm-5 mb-4 text-white-50">
                                    <div>
                                        <a href="" class="d-inline-block auth-logo">
                                            <img src="<?php echo e(baseUrl(httpCheck())); ?>assets/images/logo-light.png" alt="" height="20">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <div class="card mt-4">

                                    <div class="card-body p-4">














































                                        <div class="text-center mt-2">
                                            <h5 class="text-primary">خوش آمدید</h5>
                                        </div>
                                        <?php if(!empty(getErrors())): ?>
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <?php $__currentLoopData = getErrors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($error); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-2 mt-4">
                                            <form action="/adminpanel/Auth-signinProcess"
                                                  method="post">
                                                <input type="hidden" name="token" value="<?php echo e($token); ?>">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">ایمیل <span
                                                                class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control"
                                                           value="<?php echo e(old('email')??''); ?>" id="email"
                                                           placeholder="ایمیل را وارد کنید">
                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="auth-pass-reset-basic.html" class="text-muted">رمز خود را فراموش کرده اید؟</a>
                                                    </div>
                                                    <label class="form-label" for="password-input">پسورد <span
                                                                class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" name="password"
                                                               class="form-control pe-5 password-input"
                                                               placeholder="پسورد را وارد نمایید" id="password-input">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                                type="button" id="password-addon"><i
                                                                    class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>
                                                <img src="<?php echo e($builder->inline()); ?>"/>
                                                <div class="mb-3">
                                                    <label for="captcha" class="form-label">کپچا <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" name="captcha" class="form-control" id="captcha"
                                                           placeholder="کپچا" pattern="(?=.*\d).{5,}"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        کپچا را وارد نمایید
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" name="remember_me" type="checkbox"
                                                           value="" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">مرا به خاطر داشته باش
                                                        </label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">ورود</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title">ورود با</h5>
                                                    </div>
                                                    <div>

                                                        <button type="button"
                                                                class="btn btn-danger btn-icon waves-effect waves-light">
                                                            <i class="ri-google-fill fs-16"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4 text-center">
                                    <p class="mb-0">اکانت ندارید؟<a href="/adminpanel/Auth-signup"
                                                                               class="fw-semibold text-primary text-decoration-underline">
                                            ثبتنام </a></p>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/particles.js/particles.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/particles.app.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/password-addon.init.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
        <?php if($_REQUEST['error']): ?>
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>درخواست شما با خطا مواجه شد.</h4>' +
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

<?php echo $__env->make('admin.fa.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\bala24.ir-v2\project\view/admin/fa/auth/signin.blade.php ENDPATH**/ ?>