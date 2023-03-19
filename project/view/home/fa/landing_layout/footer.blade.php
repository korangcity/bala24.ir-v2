@php

    $service_obj=new \App\controller\home\Service();

    $services=$service_obj->getServices();
    $serviceCategories=$service_obj->getServiceCategories();
    $serviceSamples=$service_obj->getServiceSamples();
$set_obj=new \App\controller\home\Setting();
    $setting=$set_obj->settingInfo()[0];
 $pg=new \App\controller\home\Page();
        $pages=$pg->getPages();
@endphp

<footer class="custom-footer bg-dark py-5 position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mt-4">
                <div>
                    <div>
                        <img src="{{baseUrl(httpCheck()).$setting['large_logo_light']}}"
                             alt="{{$setting['large_logo_light_alt']}}" height="17">
                    </div>
                    <div class="mt-4 fs-13">
                        <p>{{$setting['footer_aboutus_title']}}</p>
                        <p>{{$setting['footer_aboutus']}}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 ms-lg-auto">
                <div class="row">
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">دسترسی سریع</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled  footer-list fs-14">
                                @foreach($pages as $page)
                                    <li><a href="{{$page['page_url']}}">{{$page['title']}}</a></li>
                                @endforeach

                                <li><a href="/faq">سوالات متداول</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">خدمات</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled  footer-list fs-14">
                                @php $random_services=array_rand($services,4);  @endphp
                                @for($i=0;$i<count($services);$i++)
                                    <li>
                                        <a href="{{baseUrl(httpCheck()).$services[$random_services[$i]]['page_url']}}">{{$services[$random_services[$i]]['title']}}</a>
                                    </li>
                                @endfor

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 mt-4">
                        <h5 class="text-white mb-0">نمونه کار</h5>
                        <div class="text-muted mt-3">
                            <ul class="list-unstyled  footer-list fs-14">
                                @php $random_sample_services=array_rand($serviceSamples,4);  @endphp
                                @for($j=0;$j<count($random_sample_services);$j++)
                                    @php
                                        $serviceLink='';
                                            foreach($services as $service):
                                            if($service['id']==$serviceSamples[$random_sample_services[$j]]['service_id']):
                                       $serviceLink=$service['page_url'];
                                           endif;
                                            endforeach;

                                    @endphp
                                    <li>
                                        <a href="{{baseUrl(httpCheck()).$serviceLink."/".$serviceSamples[$random_sample_services[$j]]['page_url']}}">{{$serviceSamples[$random_sample_services[$j]]['title']}}</a>
                                    </li>

                                @endfor
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
                        @if($setting['telegram'])
                            <li class="list-inline-item">
                                <a href="{{$setting['telegram']}}" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-telegram-fill"></i>
                                    </div>
                                </a>
                            </li>

                        @endif

                        @if($setting['instagram'])
                            <li class="list-inline-item">
                                <a href="{{$setting['instagram']}}" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-instagram-fill"></i>
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if($setting['linkedin'])
                            <li class="list-inline-item">
                                <a href="{{$setting['linkedin']}}" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-linkedin-fill"></i>
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if($setting['whatsapp'])
                            <li class="list-inline-item">
                                <a href="{{$setting['whatsapp']}}" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-whatsapp-fill"></i>
                                    </div>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
