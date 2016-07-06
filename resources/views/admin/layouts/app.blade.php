<!DOCTYPE html>
<html lang="en">
    @include('admin.includes.head')
    <body id="app-layout">
        @include('admin.includes.header')
        <div id="wrapper">
            @include('admin.includes.sidebar')
            <div id="page-content-wrapper" class="admin-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <!-- JavaScripts -->
            @yield('admin-scripts')
        </div>
    </body>
</html>
