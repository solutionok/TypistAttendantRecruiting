 <header class="header">
    <div class="logo-container">
        <a href="../" class="logo mt-xs">
            <img src="{{url('public')}}/assets/images/logo.png?190104" height="45" alt="Porto Admin" />
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: search & user box -->
    <div class="header-right">
        @if(isset($searchFormAction))
        <form action="{{$searchFormAction}}" class="search nav-form">
            <div class="input-group input-search" style="float:right;width: 250px;margin-left: 20px;">
                <input type="text" class="form-control" name="search-what" id="search-what" value="{{$searchWhat}}" placeholder="{{$searchPlaceholder}}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
            @if(isset($searchSelect))
            <?php echo $searchSelect; ?>
            @endif
        </form>
        @endif
        <span class="separator"></span>
        
        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    <i class="fa fa-user fa-2x"></i>
                </figure>
                <div class="profile-info" data-lock-name="{{auth()->user()->name}}" data-lock-email="{{auth()->user()->email}}">
                    <span class="name">{{auth()->user()->name}}</span>
                    <span class="role">{{auth()->user()->isadmin==1 ? 'administrator' : (auth()->user()->isadmin==2 ? 'assessor' : 'candidate')}}</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>
            
            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{url(auth()->user()->isadmin>0?'/admin/settings':'/home/mypage')}}"><i class="fa fa-user"></i> {{auth()->user()->isadmin>0?'Settings':'Profile'}}</a>
                    </li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{url('/logout')}}"><i class="fa fa-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>