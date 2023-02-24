@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | سابپلن ها")


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
                                    <h5 class="card-title mb-0"> سابپلن ها</h5>
                                    <a href="{{baseUrl(httpCheck())."adminpanel/Plan-createPlanFeature"}}"
                                       class="btn btn-outline-info btn-sm ms-auto">ایجاد </a>
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
                                        <th>دوره زمانی</th>
                                        <th>پلن</th>
                                        <th>آیکن</th>
                                        <th>قیمت</th>
                                        <th>ویژه بودن</th>
                                        <th>ویژگی های مثبت</th>
                                        <th>ویژگی های منفی</th>

                                        <th>اقدامات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($plan_feature_prices as $ke=>$priceItem)
                                        @foreach($plan_features as $feature)
                                            @if($feature['id']==$priceItem['plan_feature_id'])
                                                <tr>
                                                    <td>{{$loop->index+1}}</td>
                                                    <td>{{$feature['title']}}</td>
                                                    <td>{{$feature['brief_description']}}</td>
                                                    <td>
                                                        <span class="badge bg-success">
                                                        @php
                                                            foreach ($time_periods as $item) {
                                                                if($item['id']==$priceItem['time_period_id'])
                                                                    echo $item['title'];
                                                            }

                                                        @endphp
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            foreach ($plans as $plan) {
                                                                if($plan['id']==$feature['plan_id'])
                                                                    echo $plan['title'];
                                                            }

                                                        @endphp
                                                    </td>
                                                    <td>
                                                        <i class="{{$feature['icon']}} fs-36 text-success"></i>
                                                    </td>
                                                    <td >
                                                        <input type="number" name="" id="" value="{{$priceItem['price']}}" data-planfeaturepriceid="{{$priceItem['id']}}" placeholder="مثال : 200" class="form-control">
                                                        <button class="btn btn-info btn-sm addPrice">آپدیت</button>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch form-switch-success mb-3">
                                                            <input data-id="{{$priceItem['id']}}"
                                                                   class="form-check-input mx-auto form-control isParticular"
                                                                   {{$priceItem['particular']==1?'checked':''}} type="checkbox"
                                                                   role="switch" id="">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button data-id="{{$feature['id']}}" data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop3"
                                                                class="btn btn-info btn-sm showPositiveFeatures">مشاهده
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button data-id="{{$feature['id']}}" data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop4"
                                                                class="btn btn-danger btn-sm showNegativeFeatures">
                                                            مشاهده
                                                        </button>
                                                    </td>

                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown"
                                                                    type="button"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a href="/adminpanel/Plan-editPlanFeature-{{$feature['id']}}"
                                                                       class="dropdown-item edit-item-btn"><i
                                                                                class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                        ویرایش</a></li>
                                                                <li>
                                                                    <a href="" data-id="{{$priceItem['id']}}"
                                                                       class="dropdown-item remove-item-btn delItem">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                        حذف
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                        @endif
                                    @endforeach
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">ویژگی های مثبت</h5>
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

    <div class="modal fade" id="staticBackdrop4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="staticBackdropLabel">ویژگی های منفی</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table" id="resultIdModal4">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("script")

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

    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/pages/datatables.init.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>
    <script>


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
            let chk = confirm('از حذف گزینه مورد نظر مطمئن هستید؟');
            if (chk) {
                window.location.href = "/adminpanel/Plan-planFeaturePriceDelete-" + item_id;
            }
        });



        $(".isParticular").click(function () {

            let situation;
            if (!$(this).is(":checked")) {
                situation = 0;
            } else {
                situation = 1;
            }
            let plan_feature_price_id = $(this).data("id");
            let chk = confirm("از تغییرات مطمئن هستید؟");

            if (chk) {
                $.ajax({
                    type: 'post',
                    url: '/adminpanel/Plan-planFeaturePriceIsParticular',
                    data: {situation: situation, plan_feature_price_id: plan_feature_price_id},
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
                            window.location.href = "/adminpanel/Plan-planFeatureList";
                        })
                    },
                    error: function () {
                        alert("ooos")
                    }
                });

            }
        });

        $(".showPositiveFeatures").click(function () {

            let feature_id = $(this).data('id');
            $.ajax({
                type: 'post',
                url: "/adminpanel/Plan-getPlanFeaturePositive",
                data: {feature_id: feature_id},
                success: function (response) {
                    $("#resultIdModal3").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".showNegativeFeatures").click(function () {

            let feature_id = $(this).data('id');
            $.ajax({
                type: 'post',
                url: "/adminpanel/Plan-getPlanFeatureNegative",
                data: {feature_id: feature_id},
                success: function (response) {
                    $("#resultIdModal4").html(response);
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".addPrice").click(function(){
            let id=$(this).siblings().data('planfeaturepriceid');
            let price=$(this).siblings().val();
            $.ajax({
                type: 'post',
                url: "/adminpanel/Plan-updatePlanFeaturePrice",
                data: {id: id,price:price},
                success: function (response) {
                    window.location.reload();
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

    </script>
@endsection
