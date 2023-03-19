@extends("admin.fa.layout.app")

@section("title","مدیریت سایت | ویرایش خدمات")


@section("head")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">خدمات</h4>
                            </div>

                            <div class="card-body">
                                <div class="live-preview">
                                    @if (!empty(getErrors()))
                                        <div class="alert alert-danger col-md-6 col-sm-12">
                                            <ul>
                                                @foreach (getErrors() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="/adminpanel/Service-editKhadamatProcess" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="token" value="{{$token}}">
                                        <input type="hidden" name="khadamat_id" value="{{$khadamat['id']}}">
                                        <input type="hidden" name="khadamat_subject_id" value="{{$khadamat['khadamat_subject_id']}}">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">عنوان  (حداقل 3 کاراکتر) <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" value="{{$khadamat['title']??''}}" class="form-control"
                                                           placeholder="عنوان " id="title">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="brief_description" class="form-label">توضیح مختصر</label>
                                                    <textarea name="brief_description" class="form-control" id="brief_description" cols="30" rows="10">{{$khadamat['brief_description']??''}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="link" class="form-label">لینک</label>
                                                    <input type="text" name="link" value="{{$khadamat['link']??''}}" class="form-control"
                                                           placeholder="لینک " id="link">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="icon" class="form-label">آیکن</label>
                                                    <input type="text" name="icon" value="{{$khadamat['icon']??''}}" class="form-control"
                                                           placeholder="آیکن " id="icon">
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

@endsection

@section("script")
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{baseUrl(httpCheck())}}assets/js/pages/select2.init.js"></script>


    <script src="{{baseUrl(httpCheck())}}assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/libs/prismjs/prism.js"></script>

    <script src="{{baseUrl(httpCheck())}}assets/js/app.js"></script>


    <script>
        var selected = [];
        @php
            $positionss=["blog"=>1,"service"=>2,"service_sample"=>3,"news"=>4,"page"=>5,"index"=>6,"services"=>7,"blogs"=>8,"news"=>9,"sampleServices"=>10];
            $desiredPositions=[];
            $pageIddds=[];
            foreach (json_decode($khadamat['pageable_type']) as $itemPT){
                $desiredPositions[]=$positionss[$itemPT];
            }

            foreach (json_decode($khadamat["pageable_id"]) as $itemPTId){
                $pageIddds[]=(explode("*",$itemPTId)[0])."#".(explode("*",$itemPTId)[1]);
            }
        @endphp

        $(document).ready(function () {
            let page_id = {{json_encode($desiredPositions)}};
            let pagee_id = [];
            @php
                foreach ($pageIddds as $it) {
            @endphp
            pagee_id.push("{{$it}}");

            @php
                }

            @endphp


            $.ajax({
                type: 'post',
                url: "/adminpanel/Plan-getPageChildren",
                data: {page_id: page_id, pagee_id: pagee_id},
                success: function (response) {
                    $("#page_children").html(response);
                    for (var option of document.getElementById('page_children').options)
                    {
                        if (option.selected) {
                            selected.push(option.value);
                        }
                    }
                    $(".js-example-disabled-multi").select2()
                },
                error: function () {
                    alert("ooops");
                }
            })
        });


        @if($_REQUEST['error'])
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

        @endif

        $("#pagee").change(function(){

            let page_id=$(this).val();

            $.ajax({
                type: 'post',
                url: "/adminpanel/Plan-getPageChildren",
                data: {page_id: page_id},
                success: function (response) {
                    $("#page_children").html(response);
                    for (var option of document.getElementById('page_children').options)
                    {
                        if (option.selected && !selected.includes(option.value)) {
                            selected.push(option.value);
                        }
                    }


                    for(let index of selected){
                        $('#page_children').find('option').each(function(i,e){
                            if($(e).val() == index){
                                $(this).prop('selected',i);
                            }
                        });
                    }
                    $("#page_children").change(function(){
                        for (var option of document.getElementById('page_children').options)
                        {
                            if (option.selected && !selected.includes(option.value)) {
                                selected.push(option.value);
                            }
                        }

                        for(let index of selected){
                            $('#page_children').find('option').each(function(i,e){
                                if($(e).val() == index){
                                    $(this).prop('selected',i);
                                }
                            });
                        }

                    });
                    $(".js-example-disabled-multi").select2()
                },
                error: function () {
                    alert("ooops");
                }
            })
        });

        $(".js-example-disabled-multi").select2()
    </script>
@endsection
