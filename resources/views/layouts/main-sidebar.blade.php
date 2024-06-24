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
                            <li><a href="{{ route('bookcategories.index') }}">معالجة بيانات اقسام الكتب</a></li>
                            <li><a href="{{ route('consultationsCategories.index') }}">معالجة بيانات اقسام الإستشارات</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#categories">
                            <div class="pull-left"><i class="ti-harddrives"></i><span
                                    class="right-nav-text">الكتب</span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="categories" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('book.index') }}">معالجة بيانات الكتب</a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#brands">
                            <div class="pull-left"><i class="ti-harddrives"></i><span
                                    class="right-nav-text">الإستشارات </span>
                            </div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="brands" class="collapse" data-parent="#sidebarnav">
                            <li><a href="{{ route('consultations.index') }}">معالجة بيانات الإستشارات </a></li>
                            
                        </ul>
                    </li>
                    <!-- menu item calendar-->
                  
                  
                    
                    <!-- menu item mailbox-->
                   




                    
                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================-->
