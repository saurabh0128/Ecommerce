<!-- menu -->
<div class="menu">
    <div class="menu-header">
        <a href="index.html" class="menu-header-logo">
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
                    <div class="fw-bold">Timotheus Bendan</div>
                    <small class="text-muted">Sales Manager</small>
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
                <a href="" class="dropdown-item d-flex align-items-center text-danger"
                   target="_blank">
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
                <a href="{{route('admin.sellerpayment.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-receipt"></i>
                    </span>
                    <span>Seller Payment</span>
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
                        <i class="bi bi-heart"></i>
                    </span>
                    <span>Rating & Review</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.state.index')}}">
                    <span class="nav-link-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </span>
                    <span>State</span>
                </a>
            </li>
            <li>
                <a href="customers.html">
                    <span class="nav-link-icon">
                       <i class="bi bi-geo-alt-fill"></i>
                    </span>
                    <span>City</span>
                </a>
            </li>
           
        </ul>
    </div>
</div>
<!-- ./  menu -->