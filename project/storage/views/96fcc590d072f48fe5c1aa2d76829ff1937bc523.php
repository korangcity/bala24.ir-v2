

<?php $__env->startSection("head"); ?>

    <link href="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>

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
                                            <img src="<?php echo e(baseUrl(httpCheck())); ?>assets/images/logo-light.png" alt=""
                                                 height="20">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-5">
                                <div class="card mt-4">

                                    <div class="card-body p-4">
                                        <div class="text-end">
                                            <div class=" ms-1">
                                                <button type="button"
                                                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <img id="header-lang-img1"
                                                         src="<?php echo e(baseUrl(httpCheck())); ?>assets/images/flags/<?php echo e(getLanguage()=='en'?'us':(getLanguage()=='fa'?'ir':'sa')); ?>.svg"
                                                         alt="Header Language" height="20" class="rounded">
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <!-- item-->
                                                    <a href="<?php echo e(baseUrl(httpCheck())); ?>adminpanel/Setting-changeLanguage-en"
                                                       class="dropdown-item notify-item language py-2" data-lang="en"
                                                       title="English">
                                                        <img src="<?php echo e(baseUrl(httpCheck())); ?>assets/images/flags/us.svg"
                                                             alt="user-image"
                                                             class="me-2 rounded" height="18">
                                                        <span class="align-middle">English</span>
                                                    </a>


                                                    <a href="<?php echo e(baseUrl(httpCheck())); ?>adminpanel/Setting-changeLanguage-fa"
                                                       class="dropdown-item notify-item language" data-lang="fa"
                                                       title="فارسی">
                                                        <img src="<?php echo e(baseUrl(httpCheck())); ?>assets/images/flags/ir.svg"
                                                             alt="user-image"
                                                             class="me-2 rounded" height="18">
                                                        <span class="align-middle">فارسی</span>
                                                    </a>


                                                    <a href="<?php echo e(baseUrl(httpCheck())); ?>adminpanel/Setting-changeLanguage-ar"
                                                       class="dropdown-item notify-item language" data-lang="ar"
                                                       title="العربیه">
                                                        <img src="<?php echo e(baseUrl(httpCheck())); ?>assets/images/flags/sa.svg"
                                                             alt="user-image"
                                                             class="me-2 rounded" height="18">
                                                        <span class="align-middle">العربیه</span>
                                                    </a>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h5 class="text-primary">ایجاد اکانت جدید</h5>
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
                                            <form class="needs-validation" method="post" novalidate
                                                  action="/adminpanel/Auth-signupProcess">

                                                <input type="hidden" name="token" value="<?php echo e($token); ?>">
                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">ایمیل <span
                                                                class="text-danger">*</span></label>
                                                    <input type="email" name="email" class="form-control" id="useremail"
                                                           placeholder="ایمیل را وارد کنید"
                                                           value="<?php echo e(old('email')??''); ?>"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        ایمیل را وارد نمایید
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">پسورد <span
                                                                class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" name="password"
                                                               class="form-control pe-5 password-input"
                                                               onpaste="return false" placeholder="پسورد را وارد نمایید"
                                                               id="password-input" aria-describedby="passwordInput"
                                                               required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                                type="button" id="password-addon"><i
                                                                    class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            پسورد را وارد نمایید
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input1">تایید پسورد
                                                        <span
                                                                class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" name="confirm_password"
                                                               class="form-control pe-5 password-input"
                                                               onpaste="return false"
                                                               placeholder="تایید پسورد را وارد نمایید"
                                                               id="password-input1" aria-describedby="passwordInput"
                                                               required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                                type="button" id="password-addon"><i
                                                                    class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            تایید پسورد را وارد نمایید
                                                        </div>
                                                    </div>
                                                </div>

                                                <img src="<?php echo e($builder->inline()); ?>"/>
                                                <div class="mb-3">
                                                    <label for="captcha" class="form-label">کپچا <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" name="captcha" class="form-control" id="captcha"
                                                           placeholder="کپچا را وارد نمایید" pattern="(?=.*\d).{5,}"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        گپچا را وارد نمایید
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <p class="mb-0 fs-12 text-muted fst-italic">با ثبت نام شما موافق
                                                        <a href="#"
                                                           class="text-primary text-decoration-underline fst-normal fw-medium">قوانین
                                                            و مقررات
                                                        </a> هستید</p>
                                                </div>

                                                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                    <p id="pass-length" class="invalid fs-12 mb-2">حداقل <b>4
                                                            کارکتر</b>
                                                    </p>

                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">ثبت نام</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title text-muted">ایجاد حساب با </h5>
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
                                    <p class="mb-0">اکانت دارید؟<a href="/adminpanel/Auth-signin"
                                                                   class="fw-semibold text-primary text-decoration-underline">
                                            ورود </a></p>
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
    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/particles.js/particles.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/particles.app.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/form-validation.init.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/passowrd-create.init.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/sweetalerts.init.js"></script>

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
<?php echo $__env->make('admin.fa.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\bala24.ir-v2\project\view/admin/fa/auth/signup.blade.php ENDPATH**/ ?>