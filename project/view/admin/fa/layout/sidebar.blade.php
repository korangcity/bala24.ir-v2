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
                <a class="nav-link menu-link {{isActive(['Service-createKhadamat','Service-khadamatList','Service-editKhadamat','Service-ServicePartList','Service-createServicePart','Service-serviceCategoryList','Service-createServiceCategory','Service-editServiceCategory','Service-serviceList','Service-createService','Service-editService'])}}" href="#service"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-product-hunt-fill"></i> <span data-key="t-service">سرویس ها</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Service-createKhadamat','Service-khadamatList','Service-editKhadamat','Service-ServicePartList','Service-createServicePart','Service-guideServiceList','Service-createGuide','Service-editGuideService','Service-serviceCategoryList','Service-createServiceCategory','Service-editServiceCategory','Service-serviceList','Service-createService','Service-editService'])=='active')?'show':''}}" id="service">
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
                        <li class="nav-item">
                            <a href="/adminpanel/Service-sampleServiceList" class="nav-link {{isActive(['Service-sampleServiceList','Service-createSampleService','Service-editSampleService'])}}"
                               data-key="t-crm"> نمونه سرویس ها </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Service-guideServiceList" class="nav-link {{isActive(['Service-guideServiceList','Service-createGuide','Service-editGuideService'])}}"
                               data-key="t-crm"> راهنمای سرویس ها </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Service-ServicePartList" class="nav-link {{isActive(['Service-ServicePartList','Service-createServicePart'])}}"
                               data-key="t-crm"> قسمت های سرویس </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Service-khadamatList" class="nav-link {{isActive(['Service-createKhadamat','Service-khadamatList','Service-editKhadamat'])}}"
                               data-key="t-crm"> خدمات </a>
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
                <a class="nav-link menu-link {{isActive(['Program-editProgram','Program-programList','Program-createProgram'])}}" href="#programs"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-app-store-fill"></i> <span data-key="t-service">برنامه ها</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Program-editProgram','Program-programList','Program-createProgram'])=='active')?'show':''}}" id="programs">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Program-programList" class="nav-link {{isActive(['Program-editProgram','Program-programList','Program-createProgram'])}}"
                               data-key="t-crm"> برنامه ها </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Redirect-createRedirect','Redirect-redirectList','Redirect-editRedirect'])}}" href="#redirect"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-apps-line"></i> <span data-key="t-service">ریدایرکت</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Redirect-createRedirect','Redirect-redirectList','Redirect-editRedirect'])=='active')?'show':''}}" id="redirect">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Redirect-redirectList" class="nav-link {{isActive(['Redirect-createRedirect','Redirect-redirectList','Redirect-editRedirect'])}}"
                               data-key="t-crm"> ریدایرکت </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Plan-createStickFooter','Plan-stickFooterList','Plan-editStickFooter','Plan-createPlanTime','Plan-planTimeList','Plan-editPlanTime','Plan-createPlan','Plan-planList','Plan-editPlan','Plan-createPlanFeature','Plan-planFeatureList','Plan-editPlanFeature'])}}" href="#plan"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-projector-2-fill"></i> <span data-key="t-plan">پلن ها</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Plan-createStickFooter','Plan-stickFooterList','Plan-editStickFooter','Plan-createPlanTime','Plan-planTimeList','Plan-editPlanTime','Plan-createPlan','Plan-planList','Plan-editPlan','Plan-createPlanFeature','Plan-planFeatureList','Plan-editPlanFeature'])=='active')?'show':''}}" id="plan">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Plan-planTimeList" class="nav-link {{isActive(['Plan-createPlanTime','Plan-planTimeList','Plan-editPlanTime'])}}"
                               data-key="t-crm"> دوره های زمانی </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Plan-planList" class="nav-link {{isActive(['Plan-createPlan','Plan-planList','Plan-editPlan'])}}"
                               data-key="t-crm"> پلن ها </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Plan-planFeatureList" class="nav-link {{isActive(['Plan-createPlanFeature','Plan-planFeatureList','Plan-editPlanFeature'])}}"
                               data-key="t-crm"> سابپلن ها </a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminpanel/Plan-stickFooterList" class="nav-link {{isActive(['Plan-createStickFooter','Plan-stickFooterList','Plan-editStickFooter'])}}"
                               data-key="t-crm"> قسمت چسبیده به فوتر </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Company-createCompany','Company-companyList','Company-editCompany'])}}" href="#company"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class=" ri-mist-line "></i> <span data-key="t-plan">شرکت ها</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Company-createCompany','Company-companyList','Company-editCompany'])=='active')?'show':''}}" id="company">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Company-companyList" class="nav-link {{isActive(['Company-createCompany','Company-companyList','Company-editCompany'])}}"
                               data-key="t-crm"> شرکت ها </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Contactus-showMessages'])}}" href="#messages"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-message-2-fill "></i> <span data-key="t-plan">پیام های کاربران</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(["Contactus-showMessages"])=='active')?'show':''}}" id="messages">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Contactus-showMessages" class="nav-link {{isActive(['Contactus-showMessages'])}}"
                               data-key="t-crm"> پیام ها</a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link {{isActive(['Setting-createGeneralInformation','Setting-GeneralInformationList','Setting-editGeneralInformation'])}}" href="#setting"
                   data-bs-toggle="collapse"
                   role="button" aria-expanded="false" aria-controls="service">
                    <i class="ri-settings-6-fill"></i> <span data-key="t-service">تنظیمات</span>
                </a>
                <div class="collapse menu-dropdown {{(isActive(['Setting-createGeneralInformation','Setting-GeneralInformationList','Setting-editGeneralInformation'])=='active')?'show':''}}" id="setting">
                    <ul class="nav nav-sm flex-column">

                        <li class="nav-item">
                            <a href="/adminpanel/Setting-GeneralInformationList" class="nav-link {{isActive(['Setting-createGeneralInformation','Setting-GeneralInformationList','Setting-editGeneralInformation'])}}"
                               data-key="t-crm"> تنظیمات </a>
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