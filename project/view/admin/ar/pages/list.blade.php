@extends("admin.ar.layout.app")

@section("title","إدارة الموقع | الصفحات")


@section("head")
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

    <style>
        iframe{
            width: 50% !important;
        }
    </style>
@endsection


@section("content")

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                               <div class="d-flex">
                                   <h5 class="card-title mb-0"> الصفحات</h5>
                                   <a href="{{baseUrl(httpCheck())."adminpanel/Page-createPage"}}" class="btn btn-outline-info btn-sm ms-auto">أنشئ</a>
                               </div>
                            </div>
                            <div class="card-body">
                                <table id="buttons-datatables" class="display table table-bordered text-center" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>صف</th>
                                        <th>عنوان</th>
                                        <th>شرح موجز</th>
                                        <th>المحتوى</th>
                                        <th>تفاصيل</th>
                                        <th>SEO</th>
                                        <th>عرض الوضع</th>
                                        <th>تاريخ الخلق</th>
                                        <th>أجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pages as $page)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$page['title']}}</td>
                                        <td><button type="button"  data-id="{{$page['id']}}"  data-bs-toggle="modal" data-bs-target="#staticBackdrop1" class="btn btn-info btn-sm showBriefdescription">رأي</button></td>
                                        <td><button type="button"  data-id="{{$page['id']}}"  data-bs-toggle="modal" data-bs-target="#staticBackdrop2" class="btn btn-success btn-sm showDescription">رأي</button></td>
                                        <td><button type="button"  data-id="{{$page['id']}}"  data-bs-toggle="modal" data-bs-target="#staticBackdrop3" class="btn btn-warning btn-sm showPageDetails">رأي</button></td>


                                        <td>
                                            <button type="button" data-id="{{$page['id']}}"
                                                    class="btn btn-danger btn-sm getSEOData" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                تفاصيل
                                            </button>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-success mb-3">
                                                <input data-id="{{$page['id']}}"
                                                       class="form-check-input mx-auto form-control isShow"
                                                       {{$page['is_show']==1?'checked':''}} type="checkbox"
                                                       role="switch" id="SwitchCheck3">
                                            </div>
                                        </td>

                                        <td>{{$page['created_at']}}</td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="/adminpanel/Page-pageEdit-{{$page['id']}}" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> يحرر</a></li>
                                                    <li>
                                                        <a href="" data-id="{{$page['id']}}"  class="dropdown-item remove-item-btn delItem">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> حذف
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
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
                    <h5 class="modal-title" id="staticBackdropLabel">شرح موجز</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="resultIdModal1">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلق</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">محتوى</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="resultIdModal2">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلق</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">تفاصيل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="resultIdModal3">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلق</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"> page SEO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="resultIdModal">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">أغلق</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("script")

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

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/datatables.init.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>
    <script>

        $(".getSEOData").click(function () {

            let page_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Page-getPageSeoInfo",
                data: {page_id: page_id},
                success: function (response) {

                    $("#resultIdModal").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showDescription").click(function () {

            let page_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Page-getPageDescription",
                data: {page_id: page_id},
                success: function (response) {
                    $("#resultIdModal2").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showBriefdescription").click(function () {

            let page_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Page-getPageBriefdescription",
                data: {page_id: page_id},
                success: function (response) {
                    $("#resultIdModal1").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showPageDetails").click(function () {

            let page_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Page-getPageDetails",
                data: {page_id: page_id},
                success: function (response) {
                    $("#resultIdModal3").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        @if($_REQUEST['success'])
        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                'style="width:120px;height:120px">' +
                '</lord-icon>' +
                '<div class="mt-4 pt-2 fs-15"><h4>تم إكمال طلبك بنجاح!</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "فهمت",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then(function (t) {
            window.location.href = "{{baseUrl(httpCheck()).substr($_SERVER['REQUEST_URI'],1,strpos($_SERVER['REQUEST_URI'],"?")-1)}}";
        })

        @endif


        $(".delItem").click(function (e) {
            e.preventDefault();
            let item_id = $(this).data('id');
            let chk =confirm('هل أنت متأكد من حذف الخيار المطلوب؟');
            if (chk) {
                window.location.href = "/adminpanel/Page-pageDelete-" + item_id;
            }
        });

        $(".isShow").click(function () {

            let situation;
            if (!$(this).is(":checked")) {
                situation = 0;
            } else {
                situation = 1;
            }
            let page_id = $(this).data("id");
            let chk = confirm("هل أنت متأكد من إظهار المحتوى؟");

            if (chk) {
                $.ajax({
                    type: 'post',
                    url: '/adminpanel/Page-pageIsShow',
                    data: {situation: situation, page_id: page_id},
                    success: function (response) {

                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                                'style="width:120px;height:120px">' +
                                '</lord-icon>' +
                                '<div class="mt-4 pt-2 fs-15"><h4>تم إكمال طلبك بنجاح!</h4>' +
                                '</div>' +
                                '</div>',
                            showCancelButton: !1,
                            showConfirmButton: 1,
                            confirmButtonClass: "btn btn-success w-xs mb-1",
                            confirmButtonText: "فهمت",
                            buttonsStyling: !1,
                            showCloseButton: !0
                        }).then(function (t) {
                            window.location.href = "/adminpanel/Page-pageList";
                        })
                    },
                    error: function () {
                        alert("ooos")
                    }
                });

            }
        });
    </script>
@endsection
