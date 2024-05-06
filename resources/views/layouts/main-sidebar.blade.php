<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">

                <ul class="nav navbar-nav side-menu" id="sidebarnav">
                    <!-- menu item Dashboard-->
                    <li>
                        <a href="{{ route('home') }}"><i class="ti-home"></i><span class="right-nav-text">
                                الرئيسية</span> </a>
                    </li>
                    <!-- menu title -->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">المعالجة</li>
                    <!-- menu item Elements-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#elements">
                            <div class="pull-left"><i class="ti-user"></i><span class="right-nav-text">المسؤولين</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="elements" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('admins.index') }}">معالجة بيانات المسؤولين</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#elements1">
                            <div class="pull-left"><i class="ti-user"></i><span class="right-nav-text">المستخدمين</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="elements1" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('users.index') }}">معالجة بيانات المستخدمين</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#elements2">
                            <div class="pull-left"><i class="ti-user"></i><span class="right-nav-text">المندوبين</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="elements2" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('mans.index') }}">معالجة بيانات المندوبين</a></li>

                        </ul>
                    </li>
                    <!-- menu title -->
                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">المتجر</li>
                    <!-- menu item Elements-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#element">
                            <div class="pull-left"><i class="ti-harddrives"></i><span
                                    class="right-nav-text">الاقسام</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="element" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('sections.index') }}">معالجة بيانات الاقسام</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#categories">
                            <div class="pull-left"><i class="ti-harddrives"></i><span
                                    class="right-nav-text">الفئات</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="categories" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('categories.index') }}">معالجة بيانات الفئات</a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#brands">
                            <div class="pull-left"><i class="ti-harddrives"></i><span
                                    class="right-nav-text">العلامات التجارية</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="brands" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('brands.index') }}">معالجة بيانات العلامات التجارية</a></li>
                            
                        </ul>
                    </li>
                    <!-- menu item calendar-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#calendar-menu">
                            <div class="pull-left"><i class="ti-crown"></i><span class="right-nav-text">المدن
                                    والمناطق</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="calendar-menu" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{ route('cities.index') }}">معالجة بيانات المدن</a> </li>
                            <li> <a href="{{ route('areas.index') }}">معالجة بيانات المناطق </a> </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#elements3">
                            <div class="pull-left"><i class="fa fa-puzzle-piece"></i><span
                                    class="right-nav-text">المنتجات</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="elements3" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('products.index') }}">معالجة بيانات المنتجات</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#elements4">
                            <div class="pull-left"><i class="ti-shopping-cart-full "></i><span
                                    class="right-nav-text ">الطلبيات</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="elements4" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('orders.index') }}">معالجة بيانات الطلبيات</a></li>
                            <li><a href="{{ route('orderDelivery.index') }}">ارسال الطلبية لمندوب التوصيل</a></li>
                        </ul>
                    </li>
                    <!-- menu item mailbox-->
                    <li>
                        <a href="{{ route('opinions.index') }}"><i class="ti-comments"></i><span
                                class="right-nav-text">الآراء
                            </span> </a>
                    </li>
                    <li>
                        <a href="{{ route('coupons.index') }}"><i class="ti-credit-card"></i><span
                                class="right-nav-text">الكوبونات
                            </span> </a>
                    </li>




                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">تحذيرات </li>
                    <!-- menu item Custom pages-->
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#chart">
                            <div class="pull-left"><i class="ti-alert"></i><span
                                    class="right-nav-text">البلاغـات</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="chart" class="collapse" data-parent="#sidebarnav">
                            <li> <a href="{{ route('UserReports.index') }}"> بلاغ المستخدم </a> </li>
                            <li> <a href="{{ route('ManReports.index') }}">بلاغ المندوب</a> </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================-->
