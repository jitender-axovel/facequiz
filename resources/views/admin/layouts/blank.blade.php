<!DOCTYPE html>
<html lang="en">
    @include('admin.includes.head')
    <body id="app-layout">
        <div id="content" class="rows">@yield('content')</div>
        <!-- JavaScripts -->
        @yield('admin-scripts')
    </body>
</html>
