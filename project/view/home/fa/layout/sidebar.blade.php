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
            <i class="ri-server-fill"></i> <span>خدمات</span>
        </a>

        <div class="collapse menu-dropdown show" id="servicesCat">
            <ul class="nav nav-sm flex-column">
                @foreach($serviceCategories as $ke=>$cat)
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="#" class="nav-link"> {{$cat['title']}} </a>--}}
                    {{--                    </li>--}}



                    <li class="nav-item">
                        <a href="#sidebarAccount{{$ke}}" class="nav-link" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarAccount"
                           data-key="t-level-1.2"> {{$cat['title']}}
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAccount{{$ke}}">
                            <ul class="nav nav-sm flex-column">
                                @foreach($services as $service)
                                    @if($service['category_id']==$cat['id'])
                                        <li class="nav-item">
                                            <a href="/{{$service['page_url']??$service['id']}}" class="nav-link"
                                               data-key="t-level-2.1">{{$service['title']}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#servicesSample" data-bs-toggle="collapse" role="button"
           aria-expanded="true"
           aria-controls="services">
            <i class="ri-file-2-fill"></i> <span>نمونه کار</span>
        </a>

        <div class="collapse menu-dropdown " id="servicesSample">
            <ul class="nav nav-sm flex-column">
                @foreach($serviceCategories as $keu=>$catt)
                    <li class="nav-item">
                        <a href="#sidebarAccountt{{$keu}}" class="nav-link" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="sidebarAccount"
                           data-key="t-level-1.2"> {{$catt['title']}}
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAccountt{{$keu}}">
                            <ul class="nav nav-sm flex-column">
                                @foreach($services as $servicee)
                                    @if($servicee['category_id']==$catt['id'])
                                        @foreach($serviceSamples as $sample)
                                            @if($sample['service_id']==$servicee['id'])
                                                @php $serviceLink=$servicee['page_url']; @endphp
                                                <li class="nav-item">
                                                    <a href="/{{$serviceLink."/".$sample['page_url']}}" class="nav-link"
                                                       data-key="t-level-2.1">{{$sample['title']}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                    </li>
                @endforeach

            </ul>
        </div>
    </li>


</ul>