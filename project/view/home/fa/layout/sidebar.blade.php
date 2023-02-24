@php

    $service_obj=new \App\controller\home\Service();

    $services=$service_obj->getServices();
    $serviceCategories=$service_obj->getServiceCategories();
    $serviceSamples=$service_obj->getServiceSamples();


@endphp

<ul class="navbar-nav" id="navbar-nav">
    <li class="menu-title"><span>منو</span></li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#servicesCat" data-bs-toggle="collapse" role="button" aria-expanded="true"
           aria-controls="services">
            <i class="ri-instagram-fill"></i> <span>دسته بندی سرویس ها</span>
        </a>

        <div class="collapse menu-dropdown show" id="servicesCat">
            <ul class="nav nav-sm flex-column">
                @foreach($serviceCategories as $cat)
                    <li class="nav-item">
                        <a href="#" class="nav-link"> {{$cat['title']}} </a>
                    </li>

                @endforeach

            </ul>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link menu-link" href="#services" data-bs-toggle="collapse" role="button" aria-expanded="true"
           aria-controls="services">
            <i class="ri-instagram-fill"></i> <span>سرویس ها</span>
        </a>
        @php
            foreach($services as $service):
        $serviceLinkarray[]=$service['page_url'];
            endforeach;

        @endphp
        <div class="collapse menu-dropdown {{isActive2($serviceLinkarray)=="active"?"show":""}}" id="services">
            <ul class="nav nav-sm flex-column">
                @foreach($services as $service)

                    <li class="nav-item">
                        <a href="/{{$service['page_url']??$service['id']}}"
                           class="nav-link {{isActive2(($service['page_url']??$service['id']))}}"> {{$service['title']}} </a>
                    </li>

                @endforeach

            </ul>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link menu-link" href="#servicesSample" data-bs-toggle="collapse" role="button"
           aria-expanded="true"
           aria-controls="services">
            <i class="ri-instagram-fill"></i> <span>نمونه کارها</span>
        </a>

        <div class="collapse menu-dropdown show" id="servicesSample">
            <ul class="nav nav-sm flex-column">
                @foreach($serviceSamples as $sample)
                    @php
                        $serviceLink='';
                            foreach($services as $service):
                            if($service['id']==$sample['service_id']):
                       $serviceLink=$service['page_url'];
                           endif;
                            endforeach;

                    @endphp
                    <li class="nav-item">
                        <a href="{{baseUrl(httpCheck()).$serviceLink."/".$sample['page_url']}}" class="nav-link "> {{$sample['title']}} </a>
                    </li>

                @endforeach

            </ul>
        </div>
    </li>


</ul>