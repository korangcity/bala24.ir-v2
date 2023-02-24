
@php

    $service_obj=new \App\controller\home\Service();

    $services=$service_obj->getServices();
    $serviceCategories=$service_obj->getServiceCategories();
    $serviceSamples=$service_obj->getServiceSamples();
$set_obj=new \App\controller\home\Setting();
    $setting=$set_obj->settingInfo()[0];

@endphp

<footer class="custom-footer bg-dark py-5 position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mt-4">
                <div>
                    <div>
                        <img src="{{baseUrl(httpCheck()).$setting['large_logo_light']}}" alt="{{$setting['large_logo_light_alt']}}" height="17">
                    </div>
                    <div class="mt-4 fs-13">
                        <p>بالا24 در خدمت شماست</p>
                        <p>برای کسب اطلاعات بیشتر، در سایت ثبت نام نمایید</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 ms-lg-auto">
                <div class="row">
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">دسته بندی سرویس ها</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled  footer-list fs-14">
                                @foreach($serviceCategories as $cat)
                                    <li><a href="#">{{$cat['title']}}</a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">سرویس ها</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled  footer-list fs-14">
                                @foreach($services as $service)
                                    <li><a href="{{baseUrl(httpCheck()).$service['page_url']}}">{{$service['title']}}</a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">نمونه کارها</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled  footer-list fs-14">
                                @foreach($serviceSamples as $sample)
                                    @php
                                        $serviceLink='';
                                            foreach($services as $service):
                                            if($service['id']==$sample['service_id']):
                                       $serviceLink=$service['page_url'];
                                           endif;
                                            endforeach;

                                    @endphp
                                    <li><a href="{{baseUrl(httpCheck()).$serviceLink."/".$sample['page_url']}}">{{$sample['title']}}</a></li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row text-center text-sm-start align-items-center mt-5">
            <div class="col-sm-6">

                <div>
                    <p class="copy-rights mb-0">
                        {{\Morilog\Jalali\CalendarUtils::strftime("Y")}}
                        © تمامی حقوق برای بالا24 محفوظ است.
                    </p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end mt-3 mt-sm-0">
                    <ul class="list-inline mb-0 footer-social-link">
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="avatar-xs d-block">
                                <div class="avatar-title rounded-circle">
                                    <i class="ri-facebook-fill"></i>
                                </div>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="avatar-xs d-block">
                                <div class="avatar-title rounded-circle">
                                    <i class="ri-github-fill"></i>
                                </div>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="avatar-xs d-block">
                                <div class="avatar-title rounded-circle">
                                    <i class="ri-linkedin-fill"></i>
                                </div>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="avatar-xs d-block">
                                <div class="avatar-title rounded-circle">
                                    <i class="ri-google-fill"></i>
                                </div>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="avatar-xs d-block">
                                <div class="avatar-title rounded-circle">
                                    <i class="ri-dribbble-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
