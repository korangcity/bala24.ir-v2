

<?php $__env->startSection("title","مدیریت سایت | لیست وبلاگ"); ?>


<?php $__env->startSection("head"); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
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
                                   <h5 class="card-title mb-0"> وبلاگ</h5>
                                   <a href="<?php echo e(baseUrl(httpCheck())."adminpanel/Blog-createBlog"); ?>" class="btn btn-outline-info btn-sm ms-auto">ایجاد وبلاگ جدید</a>
                               </div>
                            </div>
                            <div class="card-body">
                                <table id="buttons-datatables" class="display table table-bordered text-center" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>عنوان</th>
                                        <th>دسته بندی</th>
                                        <th>توضیح مختصر</th>
                                        <th>محتوا</th>
                                        <th>جزییات</th>
                                        <th>SEO</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>اقدامات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->index+1); ?></td>
                                        <td><?php echo e($blog['title']); ?></td>
                                        <td><?php echo e($blog['CatTitle']); ?></td>
                                        <td><button type="button"  data-id="<?php echo e($blog['id']); ?>"  data-bs-toggle="modal" data-bs-target="#staticBackdrop1" class="btn btn-info btn-sm showBriefdescription">مشاهده</button></td>
                                        <td><button type="button"  data-id="<?php echo e($blog['id']); ?>"  data-bs-toggle="modal" data-bs-target="#staticBackdrop2" class="btn btn-success btn-sm showDescription">مشاهده</button></td>
                                        <td><button type="button"  data-id="<?php echo e($blog['id']); ?>"  data-bs-toggle="modal" data-bs-target="#staticBackdrop3" class="btn btn-warning btn-sm showBlogDetails">مشاهده</button></td>


                                        <td>
                                            <button type="button" data-id="<?php echo e($blog['id']); ?>"
                                                    class="btn btn-danger btn-sm getSEOData" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                جزییات
                                            </button>
                                        </td>

                                        <td><?php echo e($blog['created_at_jalali']); ?></td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="/adminpanel/Blog-blogEdit-<?php echo e($blog['id']); ?>" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> ویرایش</a></li>
                                                    <li>
                                                        <a href="" data-id="<?php echo e($blog['id']); ?>"  class="dropdown-item remove-item-btn delItem">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> حذف
                                                        </a>
                                                    </li>
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

    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">توضیح خلاصه</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="resultIdModal1">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">محتوای وبلاگ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="resultIdModal2">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">جزییات وبلاگ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="resultIdModal3">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> وبلاگ SEO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="resultIdModal">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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

        $(".getSEOData").click(function () {

            let blog_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Blog-getBlogSeoInfo",
                data: {blog_id: blog_id},
                success: function (response) {

                    $("#resultIdModal").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showDescription").click(function () {

            let blog_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Blog-getBlogDescription",
                data: {blog_id: blog_id},
                success: function (response) {
                    $("#resultIdModal2").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showBriefdescription").click(function () {

            let blog_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Blog-getBlogBriefdescription",
                data: {blog_id: blog_id},
                success: function (response) {
                    $("#resultIdModal1").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showBlogDetails").click(function () {

            let blog_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Blog-getBlogDetails",
                data: {blog_id: blog_id},
                success: function (response) {
                    $("#resultIdModal3").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

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
            let chk =confirm('از حذف گزینه مورد نظر مطمئن هستید؟');
            if (chk) {
                window.location.href = "/adminpanel/Blog-blogDelete-" + item_id;
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.fa.layout.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\bala24.ir-v2\project\view/admin/fa/blog/list.blade.php ENDPATH**/ ?>