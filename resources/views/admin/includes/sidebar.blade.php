<!-- Sidebar -->
<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li>
            <a href="{{url('admin/dashboard')}}"><i class="fa fa-tachometer"></i> Dashboard</a>
        </li>
        <li>
            <a href="{{url('admin/users')}}"><i class="fa fa-user"></i> User Management</a>
        </li>
        <li>
            <a href="javascript:;" data-toggle="collapse" data-target="#layout" class="collapsed" aria-expanded="false"><i class="fa fa-question"></i> Quiz Layouts <i class="fa fa-fw fa-caret-down"></i></a>
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
            <a href="javascript:;" data-toggle="collapse" data-target="#quiz" class="collapsed" aria-expanded="false"><i class="fa fa-question-circle"></i> Quizzes <i class="fa fa-fw fa-caret-down"></i></a>
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
            <a href="{{url('admin/widget')}}"><i class="fa fa-font"></i> Widgets</a>
        </li>
        <li>
            <a href="{{url('admin/language')}}"><i class="fa fa-font"></i> Languages</a>
        </li>
        
    </ul>
</div>
<!-- /#sidebar-wrapper -->