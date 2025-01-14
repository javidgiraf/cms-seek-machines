    <aside id="leftsidebar" class="sidebar">
        <div class="navbar-brand">
            <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
            <a href="{{route('home')}}"><img src="{{asset('frontend/assets/images/signin.png')}}" alt="Seek" width="50%"></a>
        </div>
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info">
                        <a class="image" href="{{route('home')}}"><img src="{{asset('frontend/assets/images/female.png')}}" alt="User"></a>
                        <div class="detail">
                            <h4>{{Auth::user()->name}}</h4>
                            <small>Super Admin</small>
                        </div>
                    </div>
                </li>
                <li class="{{ (\Request::route()->getName() == 'home') ? 'active open' : '' }}"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                <li class="{{ Route::is('customers.*')?'active open' : '' }}"><a href="{{route('customers.index')}}"><i class="zmdi zmdi-account"></i><span>Customers</span></a>
                <li class="{{ Route::is('sellmachines.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Selling Machines Ads</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('sellmachines.create')}}">Create New Ads</a></li>
                        <li><a href="{{route('sellmachines.pending')}}">Pending For Reviews</a></li>
                        <li><a href="{{route('sellmachines.active')}}">Active Machine Ads</a></li>
                        <li><a href="{{route('sellmachines.inactive')}}">Inactive Machine Ads</a></li>
                        <li><a href="{{route('sellmachines.index')}}">List All Machine Ads</a></li>
                    </ul>
                </li>
                <li class="{{ Route::is('banners.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-collection-folder-image"></i><span>Boosted Banner Ads</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('banners.active')}}">Active Banner Ads</a></li>
                        <li><a href="{{route('banners.inactive')}}">Inactive Banner Ads</a></li>
                        <li><a href="{{route('banners.onreview')}}">On Review Banner Ads</a></li>
                        <li><a href="{{route('banners.index')}}">List all Banner Ads</a></li>
                    </ul>
                </li>
                <li class="{{ Route::is('adverifications.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shield-check"></i><span>Paid Ad Verfications</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('adverifications.success')}}">Verification Success</a></li>
                        <li><a href="{{route('adverifications.failed')}}">Verification Failed</a></li>
                        <li><a href="{{route('adverifications.verification-pending')}}">Verification Pending</a></li>

                    </ul>
                </li>
                <li class="{{ Route::is('subscriptions.*')?'active open' : '' }}"><a href="{{route('subscriptions.index')}}"><i class="zmdi zmdi-balance-wallet"></i><span>Subscriptions</span></a>
                </li>
                <li class="{{ Route::is('boost-ad-packages.*')?'active open' : '' }}"><a href="{{route('boost-ad-packages.index')}}"><i class="zmdi zmdi-balance-wallet"></i><span>Boost Ad Packages</span></a>
                </li>
                  <li class="{{ Route::is('boost-ad-list.*')?'active open' : '' }}"><a href="{{route('boost-ad-list')}}"><i class="zmdi zmdi-balance-wallet"></i><span>Boost Ad List</span></a>
                </li>
                <li class="{{ Route::is('seekagent.*')?'active open' : '' }}"><a href="{{route('seekagent.index')}}"><i class="zmdi zmdi-balance-wallet"></i><span>Seek Agent</span></a>
                </li>
                <li class="{{ Route::is('quoterequest.*')?'active open' : '' }}"><a href="{{route('quoterequests.index')}}"><i class="zmdi zmdi-balance-wallet"></i><span>Service Request</span></a>
                </li>
                <!-- <li class="{{ Route::is('transactions.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-money"></i><span>Transactions</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('transactions.verify')}}">Verify Machine Ads </a></li>
                        <li><a href="{{route('transactions.boostads')}}">Boosted Banner Ads </a></li>
                        <li><a href="{{route('transactions.subscriptions')}}">Subscriptions </a></li>

                    </ul>
                </li> -->
                <li class="{{ Route::is('buyerrequests.*')?'active open' : '' }}"><a href="{{route('buyerrequests.index')}}"><i class="zmdi zmdi-quote"></i><span>Buyer Requests</span></a>
                </li>
                <li class="{{ Route::is('brands.*')?'active open' : '' }}"><a href="{{route('brands.index')}}"><i class="zmdi zmdi-apps"></i><span>Brands</span></a>
                <li class="{{ Route::is('countries.*')?'active open' : '' }}"><a href="{{route('countries.index')}}"><i class="zmdi zmdi-globe"></i><span>Countries</span></a></li>
                <li class="{{ Route::is('categories.*')?'active open' : '' }}"><a href="{{route('categories.index')}}"><i class="zmdi zmdi-layers"></i><span>Industries</span></a></li>
                <li class="{{ Route::is('memberships.*')?'active open' : '' }}"><a href="{{route('memberships.index')}}"><i class="zmdi zmdi-money-box"></i><span>Membership Plans</span></a>
                </li>
                <!-- <li class="{{ Route::is('blogs.*')?'active open' : '' }}"><a href="{{route('blogs.index')}}"><i class="zmdi zmdi-book"></i><span>Blogs</span></a>

                </li> -->
                <li class="{{ Route::is('banners.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Reports</span></a>
                    <ul class="ml-menu">
                       <li><a href="{{ route('reports.machine') }}">Monthly Report</a></li>
                        <li><a href="{{route('package-report')}}">Package Count Report</a></li>
                        <li><a href="{{route('verification-report')}}">Verified Ads Report</a></li>
                        <li><a href="{{ route('buyers-report') }}">Paid Visitors Report</a></li>
                        <li><a href="{{ route('hot-deals') }}">Hot Deals Report</a></li>
                        <li><a href="{{ route('machine-report') }}">Machines Report</a></li>



                    </ul>

                </li>

                <li class="{{ Route::is('admins.*')||Route::is('customers.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-box-o"></i><span>Users</span></a>
                    <ul class="ml-menu">
                        <!-- <li><a href="{{route('customers.index')}}">Customers</a></li> -->
                        <li><a href="{{route('admins.index')}}">Admin Users</a></li>
                    </ul>
                </li>
                <li class="{{ Route::is('permissions.*')||Route::is('roles.*')?'active open' : '' }}"> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-pin-account"></i><span>User Controls</span></a>
                    <ul class="ml-menu">
                        <li><a href="{{route('roles.index')}}">Assign Roles</a></li>
                        <li><a href="{{route('permissions.index')}}">Permissions</a></li>

                    </ul>
                </li>
                <li class="{{ Route::is('settings.*')?'active open' : '' }}"><a href="{{route('settings.index')}}"><i class="zmdi zmdi-settings"></i><span>Settings</span></a>
                </li>

            </ul>
        </div>
    </aside>
