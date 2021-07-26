<!-- menu -->
<div class="menu">
    <div class="menu-header">
        <a href="{{route('admin.dashboard.index')}}" class="menu-header-logo">
            <img src="https://vetra.laborasyon.com/assets/images/logo.svg" alt="logo">
        </a>
        <a href="index.html" class="btn btn-sm menu-close-btn">
            <i class="bi bi-x"></i>
        </a>
    </div>
    <div class="menu-body">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                <div class="avatar me-3">
                    <img src="{{URL::asset('backend_asset/images/user/man_avatar3.jpg')}}"
                         class="rounded-circle" alt="image">
                </div>
                <div>
                    <div class="fw-bold">{{auth()->user()->user_name}}</div>
                   
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a href="#" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-person dropdown-item-icon"></i> Profile
                </a>
                <a href="#" class="dropdown-item d-flex align-items-center">
                    <i class="bi bi-envelope dropdown-item-icon"></i> Inbox
                </a>
                <a href="#" class="dropdown-item d-flex align-items-center" data-sidebar-target="#settings">
                    <i class="bi bi-gear dropdown-item-icon"></i> Settings
                </a>
                <a href="{{route('admin.logout')}}" class="dropdown-item d-flex align-items-center text-danger">
                   <i class="bi bi-box-arrow-right dropdown-item-icon"></i> Logout
                </a>
            </div>
        </div>
        <ul>
            <li class="menu-divider">E-Commerce</li>
            <li>
                <a 
                    href="{{route('admin.dashboard.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-bar-chart"></i>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.order.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-receipt"></i>
                    </span>
                    <span>Orders</span>
                </a>
                
            </li>
            <li>
                <a href="{{route('admin.product.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-truck"></i>
                    </span>
                    <span>Products</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.user.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <span>Users</span>
                </a>   
            </li>
            <li>
                <a href="{{route('admin.seller.index')}}">
                    <span class="nav-link-icon">
                       <i class="bi bi-shop-window"></i>
                    </span>
                    <span>Seller</span>
                </a>   
            </li>
            <li>
                <a href="{{route('admin.category.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </span>
                    <span>Category</span>
                </a>
            </li>
            
            <li>
                <a href="{{route('admin.role.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-person-badge"></i>
                    </span>
                    <span>Role</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.coupon.index')}}">
                    <span class="nav-link-icon">
                    <i class="bi bi-layout-sidebar-inset"></i>
                    </span>
                    <span>Coupon</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.permission.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-lock"></i>
                    </span>
                    <span>Permission</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.rating.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-star-half"></i>
                    </span>
                    <span>Rating & Review</span>
                </a>
            </li>
           
           
            <li>
                <a href="#">
                    <span class="nav-link-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </span>
                    <span>Location</span>
                </a>
                <ul>
                    <li>
                        <a href="{{route('admin.state.index')}}">
                            <span>State</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.city.index')}}">
                            <span>City</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- ./  menu -->