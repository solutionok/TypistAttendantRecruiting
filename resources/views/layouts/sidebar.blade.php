 <aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
<!--                    <li class="{{($pageName=='dashboard') ? 'nav-active' : '' }}" {{auth()->user()->isadmin!=1?'style=display:none;':''}}>
                        <a href="{{url('admin/dashboard')}}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>-->
                    
                    <li class="{{($pageName=='job') ? 'nav-active' : '' }}">
                        <a href="{{url('admin/job')}}/">
                            <i class="fa fa-tasks" aria-hidden="true"></i>
                            <span>Jobs</span>
                        </a>
                    </li>
                    
<!--                    <li class="{{($pageName=='review') ? 'nav-active' : '' }}">
                        <a href="{{url('admin/review')}}/">
                            <img src="{{url('public')}}/assets/images/review.png" aria-hidden="true">
                            <span>Reviews</span>
                        </a>
                    </li>-->
                    
                    <li class="{{($pageName=='assessor') ? 'nav-active' : '' }}" {{auth()->user()->isadmin!=1?'style=display:none;':''}}>
                        <a href="{{url('admin/assessor')}}/">
                            <i class="fa fa-user-secret" aria-hidden="true"></i>
                            <span>Assessors</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='applicant') ? 'nav-active' : '' }}">
                        <a href="{{url('admin/applicant')}}/">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span>Applicants</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='settings') ? 'nav-active' : '' }}">
                        <a href="{{url('admin/settings')}}/">
                            <i class="fa fa-asterisk" aria-hidden="true"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    
                </ul>
            </nav>

        </div>

    </div>

</aside>