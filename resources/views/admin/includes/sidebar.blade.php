<!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                FaceQuiz Admin
            </a>
        </li>
        <li>
            <a href="{{url('admin/dashboard')}}">Dashboard</a>
        </li>
        <li>
            <a href="{{url('admin/users')}}">User Management</a>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#category" class="collapsed" aria-expanded="false">Category Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="category" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/category/create')}}">Create New Category</a>
                </li>
                <li>
                    <a href="{{url('admin/category')}}">List Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#sub-category" class="collapsed" aria-expanded="false">Sub-Category Management <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="sub-category" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/sub-category/create')}}">Create New Sub-Category</a>
                </li>
                <li>
                    <a href="{{url('admin/sub-category')}}">List Sub-Categories</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#layout" class="collapsed" aria-expanded="false">Quiz Layouts <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="layout" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/layout/create')}}">Create New Layout</a>
                </li>
                <li>
                    <a href="{{url('admin/layout')}}">List Layouts</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#quiz" class="collapsed" aria-expanded="false">Quizzes <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="quiz" class="collapse" aria-expanded="false">
                <li>
                    <a href="{{url('admin/quiz/create')}}">Create</a>
                </li>
                <li>
                    <a href="{{url('admin/quiz')}}">List Quizzes</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{url('admin/language')}}">Languages</a>
        </li>
        
    </ul>
</div>
<!-- /#sidebar-wrapper -->