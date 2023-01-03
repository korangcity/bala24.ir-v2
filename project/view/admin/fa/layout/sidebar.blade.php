<div id="scrollbar">
    <div class="container-fluid">

        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="nav-item">
                <a class="nav-link menu-link" href="/adminpanel/Dashboard-dashboard">
                    <i class="las la-tachometer-alt"></i> <span data-key="t-dashboards">داشبورد</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Auth-adminList','Auth-adminEdit'])}}" href="#admin"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                    <i class="ri-user-2-fill"></i> <span data-key="t-admin">کاربران</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Auth-adminList','Auth-adminEdit'])=='active')?'show':''}}" id="admin">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Auth-adminList" class="nav-link {{isActive(['Auth-adminList','Auth-adminEdit'])}}"
                               data-key="t-crm"> ادمین ها </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Blog-blogCategoryList','Blog-createBlogCategory','Blog-editBlogCategory','Blog-blogList','Blog-createBlog','Blog-editBlog'])}}" href="#blog"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                    <i class="ri-file-paper-2-fill"></i> <span data-key="t-blog">وبلاگ ها</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Blog-blogCategoryList','Blog-createBlogCategory','Blog-editBlogCategory','Blog-blogList','Blog-createBlog','Blog-editBlog'])=='active')?'show':''}}" id="blog">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="/adminpanel/Blog-blogCategoryList"
                               class="nav-link {{isActive(['Blog-blogCategoryList','Blog-createBlogCategory','Blog-editBlogCategory'])}}" data-key="t-analytics">
                                دسته بندی وبلاگ ها </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Blog-blogList" class="nav-link {{isActive(['Blog-blogList','Blog-createBlog','Blog-editBlog'])}}"
                               data-key="t-crm"> وبلاگ ها </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Service-serviceCategoryList','Service-createServiceCategory','Service-editServiceCategory','Service-serviceList','Service-createService','Service-editService'])}}" href="#service"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-product-hunt-fill"></i> <span data-key="t-service">سرویس ها</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Service-serviceCategoryList','Service-createServiceCategory','Service-editServiceCategory','Service-serviceList','Service-createService','Service-editService'])=='active')?'show':''}}" id="service">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="/adminpanel/Service-serviceCategoryList"
                               class="nav-link {{isActive(['Service-serviceCategoryList','Service-createServiceCategory','Service-editServiceCategory'])}}" data-key="t-analytics">
                                دسته بندی سرویس ها </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Service-serviceList" class="nav-link {{isActive(['Service-serviceList','Service-createService','Service-editService'])}}"
                               data-key="t-crm"> سرویس ها </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['News-newsCategoryList','News-createNewsCategory','News-editNewsCategory','News-newsList','News-createNews','News-editNews'])}}" href="#news"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-newspaper-fill"></i> <span data-key="t-service">اخبار</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['News-newsCategoryList','News-createNewsCategory','News-editNewsCategory','News-newsList','News-createNews','News-editNews'])=='active')?'show':''}}" id="news">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="/adminpanel/News-newsCategoryList"
                               class="nav-link {{isActive(['News-newsCategoryList','News-createNewsCategory','News-editNewsCategory'])}}" data-key="t-news">
                                دسته بندی اخبار </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/News-newsList" class="nav-link {{isActive(['News-newsList','News-createNews','News-editNews'])}}"
                               data-key="t-crm"> اخبار </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Page-pageList','Page-createPage','Page-editPage'])}}" href="#page"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-pages-fill"></i> <span data-key="t-service">صفحات</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Page-pageList','Page-createPage','Page-editPage'])=='active')?'show':''}}" id="page">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Page-pageList" class="nav-link {{isActive(['Page-pageList','Page-createPage','Page-editPage'])}}"
                               data-key="t-crm"> صفحات </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Metatag-metatagList','Metatag-createMetatag','Metatag-editMetatag'])}}" href="#metatag"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-settings-3-line"></i> <span data-key="t-service">متاتگ ها</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Metatag-metatagList','Metatag-createMetatag','Metatag-editMetatag'])=='active')?'show':''}}" id="metatag">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Metatag-metatagList" class="nav-link {{isActive(['Metatag-metatagList','Metatag-createMetatag','Metatag-editMetatag'])}}"
                               data-key="t-crm"> متاتگ </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link menu-link" href="/adminpanel/Auth-signout">
                    <i class="ri-logout-box-fill"></i> <span data-key="t-dashboards">خروج</span>
                </a>
            </li>

        </ul>
    </div>
    <!-- Sidebar -->
</div>

<div class="sidebar-background"></div>