    <aside id="leftsidebar" class="sidebar">
        <div class="navbar-brand">
            <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
            <a href="{{route('home')}}"><img src="{{asset('frontend/assets/images/logo.png')}}" width="25" alt="Aero"><span class="m-l-10">Seek</span></a>
        </div>
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info">
                        <a class="image" href="{{route('home')}}"><img src="{{asset('frontend/assets/images/logo.png')}}" alt="User"></a>
                        <div class="detail">

                        </div>
                    </div>
                </li>
                <li class="{{ (\Request::route()->getName() == 'home') ? 'active open' : '' }}"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                <li class="{{ Route::is('brands.*')?'active open' : '' }}"><a href="{{route('brands.index')}}"><i class="zmdi zmdi-apps"></i><span>Brands</span></a>

                <li class="{{ Route::is('countries.*')?'active open' : '' }}"><a href="{{route('countries.index')}}"><i class="zmdi zmdi-globe"></i><span>Countries</span></a>

                </li>
                <li class="{{ Route::is('blogs.*')?'active open' : '' }}"><a href="{{route('blogs.index')}}"><i class="zmdi zmdi-book"></i><span>Blogs</span></a>

                </li>
                <li class="{{ Route::is('banners.*')?'active open' : '' }}"><a href="{{route('banners.index')}}"><i class="zmdi zmdi-laptop"></i><span>Banners</span></a>

                </li>
                <li class="{{ Route::is('categories.*')?'active open' : '' }}"><a href="{{route('categories.index')}}"><i class="zmdi zmdi-layers"></i><span>Categories</span></a>

                </li>
                <li class="{{ Route::is('permissions.*')||Route::is('roles.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-pin-account"></i><span>User Controls</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('roles.index')}}">Assign Roles</a></li>
                        <li><a href="{{route('permissions.index')}}">Permissions</a></li>

                    </ul>
                </li>
                <!-- <li class="{{ Route::is('admins.*')||Route::is('customers.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-box-o"></i><span>Users</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('admins.index')}}">Admins</a></li>
                        <li><a href="{{route('customers.index')}}">Customers</a></li>

                    </ul>
                </li> -->
                <li class="{{ Route::is('sellmachines.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-box-o"></i><span>Selling Machines Ads</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('sellmachines.active')}}">Active Selling Machines Ads</a></li>
                        <li><a href="{{route('sellmachines.inactive')}}">In Active Selling Machines Ads</a></li>
                        <li><a href="{{route('sellmachines.pending')}}">Pending Selling Machines Ads</a></li>
                        <li><a href="{{route('sellmachines.index')}}">Selling Machines Ads</a></li>


                    </ul>
                </li>
                <!-- <li class="{{ Route::is('sellmachines.*')?'active open' : '' }}"><a href="{{route('sellmachines.index')}}"><i class="zmdi zmdi-shopping-cart"></i><span>Selling Machines Ads</span></a>

                </li> -->

                <li class="{{ Route::is('buyerrequests.*')?'active open' : '' }}"><a href="{{route('buyerrequests.index')}}"><i class="zmdi zmdi-quote"></i><span>Quote Requests</span></a>

                </li>
                <li class="{{ Route::is('memberships.*')?'active open' : '' }}"><a href="{{route('memberships.index')}}"><i class="zmdi zmdi-money-box"></i><span>Membership Plans</span></a>

                </li>

                <li class="{{ Route::is('subscriptions.*')?'active open' : '' }}"><a href="{{route('subscriptions.index')}}"><i class="zmdi zmdi-money-box"></i><span>Subscriptions</span></a>

                </li>


            </ul>
        </div>
    </aside>