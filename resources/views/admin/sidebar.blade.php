<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-mug-hot"></i>
        </div>
        <div class="sidebar-brand-text fs-16 mx-3">Harper 7</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="fa-solid fa-house"></i>
            <span>Trang chủ</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Thao tác
    </div>
    <!-- Role -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRole" aria-expanded="true" aria-controls="collapseRole">
            <i class="fa-solid fa-briefcase"></i>
            <span>Chức vụ</span>
        </a>
        <div id="collapseRole" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('role.list')}}">Danh sách chức vụ</a>
            </div>
        </div>
    </li>
    <!-- Account -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccount" aria-expanded="true" aria-controls="collapseAccount">
            <i class="fa-solid fa-user"></i>
            <span>Tài khoản</span>
        </a>
        <div id="collapseAccount" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('account.list')}}">Danh sách tài khoản</a>
            </div>
        </div>
    </li>
    <!-- Category -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
            <i class="fa-solid fa-shop"></i>
            <span>Danh mục</span>
        </a>
        <div id="collapseCategory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('category.list')}}">Danh sách danh mục</a>
            </div>
        </div>
    </li>

    <!--  Units -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="true" aria-controls="collapseUnit">
            <i class="fa-solid fa-weight-scale"></i>
            <span>Đơn vị tính</span>
        </a>
        <div id="collapseUnit" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('units.list')}}">Danh sách đơn vị</a>
            </div>
        </div>
    </li>

    <!-- Product -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
            <i class="fa-solid fa-cake-candles"></i>
            <span>Sản phẩm</span>
        </a>
        <div id="collapseProduct" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('product.list')}}">Danh sách sản phẩm</a>
            </div>
        </div>
    </li>

    <!-- Ingredients -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIngredients" aria-expanded="true" aria-controls="collapseIngredients">
            <i class="fa-solid fa-seedling"></i>
            <span>Nguyên liệu</span>
        </a>
        <div id="collapseIngredients" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('ingredients.list')}}">Danh sách nguyên liệu</a>
            </div>
        </div>
    </li>

    <!-- Recipe -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecipe" aria-expanded="true" aria-controls="collapseRecipe">
            <i class="fa-solid fa-gear"></i>
            <span>Công thức</span>
        </a>
        <div id="collapseRecipe" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('recipe.list')}}">Danh sách công thức</a>
            </div>
        </div>
    </li>

    <!-- Slide -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSlide" aria-expanded="true" aria-controls="collapseSlide">
            <i class="fa-brands fa-adversal"></i>
            <span>Quảng cáo</span>
        </a>
        <div id="collapseSlide" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('slide.list')}}">Danh sách quảng cáo</a>
            </div>
        </div>
    </li>

    <!-- Fee -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment" aria-expanded="true" aria-controls="collapsePayment">
            <i class="fa-solid fa-motorcycle"></i>
            <span>Vận chuyển</span>
        </a>
        <div id="collapsePayment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('fee.list')}}">Danh sách phí vận chuyển</a>
            </div>
        </div>
    </li>

    <!-- Supplier -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-truck-field"></i>
            <span>Nhà cung cấp</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('supplier.list')}}">Danh sách nhà cung cấp</a>
            </div>
        </div>
    </li>

    <!-- Customers -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseCustomer">
            <i class="fa-solid fa-user-tie"></i>
            <span>Khách hàng</span>
        </a>
        <div id="collapseCustomer" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('customer.list')}}">Danh sách khách hàng</a>
            </div>
        </div>
    </li>

    <!-- Import Note -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNote" aria-expanded="true" aria-controls="collapseNote">
            <i class="fa-regular fa-clipboard"></i>
            <span>Phiếu hàng</span>
        </a>
        <div id="collapseNote" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Các thao tác:</h6>
                <a class="collapse-item" href="{{route('notes.list')}}">Danh sách phiếu hàng</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>