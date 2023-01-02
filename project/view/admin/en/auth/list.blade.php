@extends("admin.en.layout.app")

@section("title","website management | admin list")


@section("head")
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
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
                                    <h5 class="card-title mb-0"> Admin list</h5>

                                </div>
                            </div>
                            <div class="card-body">
                                <table id="buttons-datatables" class="display table table-bordered text-center"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>mobile</th>
                                        <th>situation</th>
                                        <th>ban</th>
                                        <th>details</th>
                                        <th>action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$user['name']??'---'}}</td>
                                            <td>{{$user['email']??'---'}}</td>
                                            <td>{{$user['mobile']??'---'}}</td>
                                            <td>
                                                <div class="form-check form-switch form-switch-success mb-3">
                                                    <input data-id="{{$user['id']}}"
                                                           class="form-check-input mx-auto form-control changeSituation"
                                                           {{$user['is_verified']==1?'checked':''}} type="checkbox"
                                                           role="switch" id="SwitchCheck3">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch form-switch-success mb-3">
                                                    <input data-id="{{$user['id']}}"
                                                           class="form-check-input mx-auto form-control banUser"
                                                           {{$user['is_ban']==1?'checked':''}} type="checkbox"
                                                           role="switch" id="SwitchCheck3">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" data-id="{{$user['id']}}" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop1"
                                                        class="btn btn-info btn-sm showUserDetails">show
                                                </button>
                                            </td>
                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="/adminpanel/Auth-applyAccessLevel-{{$user['id']}}"
                                                               class="dropdown-item edit-item-btn"><i
                                                                        class="ri-admin-fill align-bottom me-2 text-muted"></i>
                                                                access</a>
                                                        </li>
                                                        <li>
                                                            <a href="/adminpanel/Auth-adminEdit-{{$user['id']}}"
                                                               class="dropdown-item edit-item-btn"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                edit</a></li>
                                                        <li>
                                                            <a href="" class="dropdown-item remove-item-btn delItem" data-id="{{$user['id']}}">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                delete
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
                    <h5 class="modal-title" id="staticBackdropLabel">details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="resultIdModal1">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("script")

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/datatables.init.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>

    <script>

        $(".showUserDetails").click(function () {

            let user_id = $(this).data("id");
            $.ajax({
                type: 'post',
                url: "/adminpanel/Auth-getUserInfoEn",
                data: {user_id: user_id},
                success: function (response) {
                    $("#resultIdModal1").html(response);
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
                '<div class="mt-4 pt-2 fs-15"><h4>Your request has been successfully completed.!</h4>' +
                '</div>' +
                '</div>',
            showCancelButton: !1,
            showConfirmButton: 1,
            confirmButtonClass: "btn btn-success w-xs mb-1",
            confirmButtonText: "OK",
            buttonsStyling: !1,
            showCloseButton: !0
        }).then(function (t) {
            window.location.href = "{{baseUrl(httpCheck()).substr($_SERVER['REQUEST_URI'],1,strpos($_SERVER['REQUEST_URI'],"?")-1)}}";
        })

        @endif

        $(".changeSituation").click(function () {

            let situation;
            if (!$(this).is(":checked")) {
                situation = 0;
            } else {
                situation = 1;
            }
            let user_id = $(this).data("id");
            let chk = confirm("Are you sure to change user situation?");
            if (chk) {
                $.ajax({
                    type: 'post',
                    url: '/adminpanel/Auth-changeUserSituation',
                    data: {situation: situation, user_id: user_id},
                    success: function (response) {
                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                                'style="width:120px;height:120px">' +
                                '</lord-icon>' +
                                '<div class="mt-4 pt-2 fs-15"><h4>Your request has been successfully completed.!</h4>' +
                                '</div>' +
                                '</div>',
                            showCancelButton: !1,
                            showConfirmButton: 1,
                            confirmButtonClass: "btn btn-success w-xs mb-1",
                            confirmButtonText: "OK",
                            buttonsStyling: !1,
                            showCloseButton: !0
                        }).then(function (t) {
                            window.location.reload();
                        })
                    },
                    error: function () {
                        alert("ooos")
                    }
                });

            }
        });

        $(".banUser").click(function () {

            let situation;
            if (!$(this).is(":checked")) {
                situation = 0;
            } else {
                situation = 1;
            }
            let user_id = $(this).data("id");
            let chk = confirm("Are you sure to ban user?");

            if (chk) {
                $.ajax({
                    type: 'post',
                    url: '/adminpanel/Auth-banUser',
                    data: {situation: situation, user_id: user_id},
                    success: function (response) {
                        Swal.fire({
                            html: '<div class="mt-3">' +
                                '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" ' +
                                'trigger="loop" colors="primary:#0ab39c,secondary:#405189" ' +
                                'style="width:120px;height:120px">' +
                                '</lord-icon>' +
                                '<div class="mt-4 pt-2 fs-15"><h4>Your request has been successfully completed.!</h4>' +
                                '</div>' +
                                '</div>',
                            showCancelButton: !1,
                            showConfirmButton: 1,
                            confirmButtonClass: "btn btn-success w-xs mb-1",
                            confirmButtonText: "OK",
                            buttonsStyling: !1,
                            showCloseButton: !0
                        }).then(function (t) {
                            window.location.href="/adminpanel/Auth-adminList";
                        })
                    },
                    error: function () {
                        alert("ooos")
                    }
                });

            }
        });

        $(".delItem").click(function (e) {
            e.preventDefault();
            let user_id=$(this).data('id');
            let chk=confirm('Are you sure to delete item?');
            if(chk){
                window.location.href="Auth-deleteAdmin-"+user_id;
            }
        });
    </script>
@endsection
