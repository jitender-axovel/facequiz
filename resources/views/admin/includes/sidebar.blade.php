<!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                Kickstarter Admin
            </a>
        </li>
        <li>
            <a href="{{'admin/dashboard'}}">Dashboard</a>
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
        
    </ul>
</div>
<!-- /#sidebar-wrapper -->