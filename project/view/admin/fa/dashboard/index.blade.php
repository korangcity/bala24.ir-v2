@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | داشبورد")


@section("head")

@endsection


@section("content")

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="row h-100">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="alert alert-success border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                       <h3>خوش آمدید</h3>
                                    </div>

                                    <div class="row align-items-end">

                                        <div class="col-sm-4">
                                            <div class="px-3">
                                                <img src="{{baseUrl(httpCheck())}}assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
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

            let news_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/News-getNewsSeoInfo",
                data: {news_id: news_id},
                success: function (response) {

                    $("#resultIdModal").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showDescription").click(function () {

            let news_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/News-getNewsDescription",
                data: {news_id: news_id},
                success: function (response) {
                    $("#resultIdModal2").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showBriefdescription").click(function () {

            let news_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/News-getNewsBriefdescription",
                data: {news_id: news_id},
                success: function (response) {
                    $("#resultIdModal1").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showNewsDetails").click(function () {

            let news_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/News-getNewsDetails",
                data: {news_id: news_id},
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
            window.location.href = "{{baseUrl(httpCheck()).substr($_SERVER['REQUEST_URI'],1,strpos($_SERVER['REQUEST_URI'],"?")-1)}}";
        })

        @endif

        $(".delItem").click(function (e) {
            e.preventDefault();
            let item_id = $(this).data('id');
            let chk =confirm('از حذف گزینه مورد نظر مطمئن هستید؟');
            if (chk) {
                window.location.href = "/adminpanel/News-newsDelete-" + item_id;
            }
        });

        $(".isShow").click(function () {

            let situation;
            if (!$(this).is(":checked")) {
                situation = 0;
            } else {
                situation = 1;
            }
            let news_id = $(this).data("id");
            let chk = confirm("از نمایش دادن محتوا مطمئن هستید؟");

            if (chk) {
                $.ajax({
                    type: 'post',
                    url: '/adminpanel/News-newsIsShow',
                    data: {situation: situation, news_id: news_id},
                    success: function (response) {

                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                                'style="width:120px;height:120px">' +
                                '</lord-icon>' +
                                '<div class="mt-4 pt-2 fs-15"><h4>درخواست شما با موفقیت انجام شد!</h4>' +
                                '</div>' +
                                '</div>',
                            showCancelButton: !1,
                            showConfirmButton: 1,
                            confirmButtonClass: "btn btn-success w-xs mb-1",
                            confirmButtonText: "فهمیدم",
                            buttonsStyling: !1,
                            showCloseButton: !0
                        }).then(function (t) {
                            window.location.href = "/adminpanel/News-newsList";
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
