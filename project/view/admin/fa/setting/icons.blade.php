@extends("admin.fa.layout.app")

@section("title","مدیریت سایت |آیکن ها")


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
                                    <h5 class="card-title mb-0"> آیکن ها</h5>

                                </div>
                            </div>
                            <div class="card-body">
                                <table id="buttons-datatables" class="display table table-bordered text-center" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام</th>
                                        <th>آیکن</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>

                                        <td>
                                            <span class="badge badge-soft-success fs-20">1</span>
                                        </td>

                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-line</span>
                                        </td>


                                        <td>
                                            <i class="ri-home-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">2</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-home-fill </span>
                                        </td>


                                        <td>
                                            <i class=" ri-home-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">3</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-2-line  </span>
                                        </td>


                                        <td>
                                            <i class="ri-home-2-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">4</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-2-fill </span>
                                        </td>


                                        <td>
                                            <i class="ri-home-2-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">5</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-3-line </span>
                                        </td>


                                        <td>
                                            <i class="ri-home-3-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">6</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-home-3-fill</span>
                                        </td>


                                        <td>
                                            <i class=" ri-home-3-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">7</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-4-line </span>
                                        </td>


                                        <td>
                                            <i class="ri-home-4-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">8</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-4-fill </span>
                                        </td>


                                        <td>
                                            <i class="ri-home-4-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">9</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-home-5-line  </span>
                                        </td>


                                        <td>
                                            <i class=" ri-home-5-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">10</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-home-5-fill </span>
                                        </td>


                                        <td>
                                            <i class=" ri-home-5-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">11</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-6-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-6-line  fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">12</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-6-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-home-6-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">13</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-7-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-7-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">14</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-7-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-7-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">15</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-8-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-8-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">16</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-8-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-8-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">17</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-gear-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-gear-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">18</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-gear-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-gear-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">19</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-wifi-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-wifi-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">20</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-wifi-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-wifi-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">21</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-home-smile-line </span>
                                        </td>

                                        <td>
                                            <i class=" ri-home-smile-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">22</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-smile-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-home-smile-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">23</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-smile-2-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-home-smile-2-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">24</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-smile-2-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-smile-2-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">25</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-heart-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-home-heart-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">26</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-home-heart-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-home-heart-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">27</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-building-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-building-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">28</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-building-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-building-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">29</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-building-2-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-building-2-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">30</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-building-2-fill</span>
                                        </td>

                                        <td>
                                            <i class=" ri-building-2-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">31</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-building-3-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-building-3-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">32</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-building-3-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-building-3-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">33</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-building-4-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-building-4-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">34</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-building-4-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-building-4-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">35</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-hotel-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-hotel-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">36</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-hotel-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-hotel-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">37</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-community-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-community-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">38</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-community-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-community-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">39</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-government-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-government-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">40</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-government-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-government-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">41</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-bank-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-bank-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">42</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-bank-fill  </span>
                                        </td>

                                        <td>
                                            <i class="ri-bank-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">43</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-store-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-store-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">44</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-store-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-store-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">45</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-store-2-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-store-2-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">46</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-store-2-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-store-2-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">47</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-store-3-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-store-3-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">48</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-store-3-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-store-3-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">49</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-hospital-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-hospital-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">50</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-hospital-fill </span>
                                        </td>

                                        <td>
                                            <i class=" ri-hospital-fill  fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">51</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-ancient-gate-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-ancient-gate-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">52</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-ancient-gate-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-ancient-gate-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">53</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-ancient-pavilion-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-ancient-pavilion-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">54</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-ancient-pavilion-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-ancient-pavilion-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">55</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-line </span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">56</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20"> ri-mail-fill </span>
                                        </td>

                                        <td>
                                            <i class=" ri-mail-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">57</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-open-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-open-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">58</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-open-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-open-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">59</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-send-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-send-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">60</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-send-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-send-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">61</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-unread-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-unread-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">62</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-unread-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-unread-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">63</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-add-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-add-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">64</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-add-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-add-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">65</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-check-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-check-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">66</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-check-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-check-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">67</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-close-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-close-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">68</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-close-fill</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-close-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">69</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-download-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-download-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">70</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-download-fill </span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-download-fill fs-20 text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-soft-success fs-20">71</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info fs-20">ri-mail-forbid-line</span>
                                        </td>

                                        <td>
                                            <i class="ri-mail-forbid-line fs-20 text-danger"></i>
                                        </td>
                                    </tr>

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
                    <h5 class="modal-title" id="staticBackdropLabel">جزییات صفحه</h5>
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


        $(".showPageDetails").click(function () {

            $.ajax({
                type: 'post',
                url: "/adminpanel/Setting-getSettingDetails",
                data: {},
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

    </script>
@endsection
