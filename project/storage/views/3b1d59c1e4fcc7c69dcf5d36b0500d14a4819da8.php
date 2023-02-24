

<?php $__env->startSection("title","مدیریت سایت | لیست راهنمای سرویس ها"); ?>


<?php $__env->startSection("head"); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>


<?php $__env->startSection("content"); ?>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <h5 class="card-title mb-0"> راهنمای سرویس ها</h5>
                                    <a href="<?php echo e(baseUrl(httpCheck())."adminpanel/Service-createGuide"); ?>"
                                       class="btn btn-outline-info btn-sm ms-auto">ایجاد راهنمای سرویس جدید</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="buttons-datatables" class="display table table-bordered text-center"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>عنوان</th>
                                        <th>توضیح مختصر</th>
                                        <th>تصویر</th>
                                        <th>alt تصویر</th>
                                        <th>اقدامات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $guideServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->index+1); ?></td>
                                            <td><?php echo e($service['title']); ?></td>
                                            <td><?php echo e($service['brief_description']); ?></td>
                                            <td><img style="width:150px" src="<?php echo e(baseUrl(httpCheck()).$service['image']); ?>" class="img-thumbnail" alt=""></td>
                                            <td><?php echo e($service['image_alt']); ?></td>

                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="/adminpanel/Service-editGuideService-<?php echo e($service['id']); ?>"
                                                               class="dropdown-item edit-item-btn"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                ویرایش</a></li>







                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
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

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/pages/datatables.init.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="<?php echo e(baseUrl(httpCheck())); ?>assets/js/app.js"></script>
    <script>



        <?php if($_REQUEST['success']): ?>
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>درخواست شما با موفقیت انجام شد</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "فهمیدم",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then(function (t) {
            window.location.href = "<?php echo e(baseUrl(httpCheck()).substr($_SERVER['REQUEST_URI'],1,strpos($_SERVER['REQUEST_URI'],"?")-1)); ?>";
        })

        <?php endif; ?>


        $(".delItem").click(function (e) {
            e.preventDefault();
            let item_id = $(this).data('id');
            let chk = confirm('از حذف گزینه مورد نظر مطمئن هستید؟');
            if (chk) {
                window.location.href = "/adminpanel/Service-guideServiceDelete-" + item_id;
            }
        });

    

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.fa.layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\bala24.ir-v2\project\view/admin/fa/service/guideServiceList.blade.php ENDPATH**/ ?>