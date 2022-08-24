<!DOCTYPE html>
<html lang="en">
    @include('templates.partials.head')

    <body class="loading" data-layout-color="light" data-layout="detached" data-rightbar-onstart="true">

        <!-- Topbar Start -->
        @include('templates.partials.navbar')
        <!-- end Topbar -->
        
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- Begin page -->
            <div class="wrapper">

                <!-- ========== Left Sidebar Start ========== -->
                @include('templates.partials.sidebar')
                <!-- Left Sidebar End -->

                <div class="content-page">
                    <div class="content">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">@yield('pwd')</a></li>
                                            <li class="breadcrumb-item active">@yield('sub-pwd')</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">@yield('page-title')</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title --> 
                        
                        @yield('content')

                    </div> <!-- End Content -->

                    <!-- Footer Start -->
                    @include('templates.partials.footer')
                    <!-- end Footer -->

                </div> <!-- content-page -->

            </div> <!-- end wrapper-->
        </div>
        <!-- END Container -->


        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>
        
    </body>

<!-- Mirrored from coderthemes.com/hyper/modern/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 21 Aug 2022 09:17:24 GMT -->
</html>
