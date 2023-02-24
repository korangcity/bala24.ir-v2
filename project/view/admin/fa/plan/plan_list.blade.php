@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | پلن ها")


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
                                    <h5 class="card-title mb-0"> پلن ها</h5>
                                    <a href="{{baseUrl(httpCheck())."adminpanel/Plan-createPlan"}}"
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
                                        <th>دوره زمانی ها</th>
                                        <th>جایگاه</th>
                                        <th>صفحه</th>

                                        <th>اقدامات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($plans as $plan)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td>{{$plan['title']}}</td>
                                            <td>{{$plan['brief_description']}}</td>
                                            <td>
                                                @php
                                                    $timess=json_decode($plan['time_period']);

                                                    foreach ($timess as $vall) {
                                                        foreach ($time_periods as $period) {
                                                            if($vall==$period['id']){
                                                                echo $period['title']."<br>";
                                                            }
                                                        }
                                                    }
                                                @endphp

                                            </td>
                                            <td>
                                                @php
                                                    foreach (json_decode($plan['planable_type']) as $j=>$planable_type) {

                                                        echo ($j+1)."-".match ($planable_type){
                                                        "blog"=>"وبلاگ",
                                                        "service"=>"سرویس",
                                                        "service_sample"=>"نمونه سرویس",
                                                        "news"=>"اخبار",
                                                        "page"=>"صفحات",
                                                        "index"=>"صفحه اصلی",
                                                        "services"=>"صفحه سرویس ها",
                                                        "blogs"=>"صفحه وبلاگ ها",
                                                        "news"=>"صفحه خبر ها",
                                                        "sampleServices"=>"صفحه نمونه سرویس ها",
                                                        }."<br>";
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    foreach (json_decode($plan['planable_id']) as $k=>$planable_idd) {
                                                        $planable_id=explode("*",$planable_idd)[0];
                                                        $planable_type_id=explode("*",$planable_idd)[1];
                                                         if ($planable_type_id == 1) {
                                                                $planable_type = "blog";
                                                            } elseif ($planable_type_id == 2) {
                                                                $planable_type = "service";
                                                            } elseif ($planable_type_id == 3) {
                                                                $planable_type = "service_sample";
                                                             } elseif ($planable_type_id == 4) {
                                                                $planable_type= "news";
                                                             } elseif ($planable_type_id == 5) {
                                                                 $planable_type = "page";
                                                               }elseif ($planable_type_id == 6) {
                                                                 $planable_type = "index";
                                                               }elseif ($planable_type_id == 7) {
                                                                 $planable_type = "services";
                                                               }elseif ($planable_type_id == 8) {
                                                                 $planable_type = "blogs";
                                                               }elseif ($planable_type_id == 9) {
                                                                 $planable_type = "news";
                                                               }elseif ($planable_type_id == 10) {
                                                                 $planable_type = "sampleServices";
                                                               }


                                                    if($planable_type=="blog"){
                                                         $blog=new \App\controller\admin\Blog();
                                                         echo ($k+1)."-".($blog->getBlog($planable_id))[0]['title']."<br>";
                                                     }elseif($planable_type=="service"){
                                                         $service=new \App\controller\admin\Service();
                                                         echo ($k+1)."-".($service->getService($planable_id))[0]['title']."<br>";
                                                     }elseif($planable_type=="service_sample"){
                                                         $service=new \App\controller\admin\Service();
                                                         echo ($k+1)."-".($service->getSampleService($planable_id))[0]['title']."<br>";
                                                     }elseif($planable_type=="news"){
                                                         $news=new \App\controller\admin\News();
                                                         echo ($k+1)."-".($news->getSingleNews($planable_id))[0]['title']."<br>";
                                                     }elseif($planable_type=="page"){
                                                         $page=new \App\controller\admin\Page();
                                                         echo ($k+1)."-".($page->getPage($planable_id))[0]['title']."<br>";
                                                     }elseif($planable_type=="index"){
                                                         echo ($k+1)."-صفحه اصلی<br>";
                                                     }elseif($planable_type=="services"){
                                                         echo ($k+1)."-صفحه سرویس ها<br>";
                                                     }elseif($planable_type=="blogs"){
                                                         echo ($k+1)."-صفحه وبلاگ ها<br>";
                                                     }elseif($planable_type=="news"){
                                                         echo ($k+1)."-صفحه خبر ها<br>";
                                                     }elseif($planable_type=="sampleServices"){
                                                         echo ($k+1)."-صفحه نمونه سرویس ها<br>";
                                                     }



                                                    }


                                                @endphp
                                            </td>

                                            <td>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a href="/adminpanel/Plan-editPlan-{{$plan['id']}}"
                                                               class="dropdown-item edit-item-btn"><i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                ویرایش</a></li>
                                                        <li>
                                                            <a href="" data-id="{{$plan['id']}}"
                                                               class="dropdown-item remove-item-btn delItem">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                حذف
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
                window.location.href = "/adminpanel/Plan-planDelete-" + item_id;
            }
        });

    </script>
@endsection
