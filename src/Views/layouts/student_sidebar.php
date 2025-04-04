<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/pdu_pms_project/public/student">
        <div class="sidebar-brand-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PDU PMS <sup>SV</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/pdu_pms_project/public/student">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng Điều Khiển</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Đặt Phòng
    </div>

    <!-- Nav Item - Đặt phòng -->
    <li class="nav-item">
        <a class="nav-link" href="/pdu_pms_project/public/student/book_room">
            <i class="fas fa-fw fa-calendar-plus"></i>
            <span>Đặt Phòng Mới</span>
        </a>
    </li>

    <!-- Nav Item - Lịch sử đặt phòng -->
    <li class="nav-item">
        <a class="nav-link" href="/pdu_pms_project/public/student/my_bookings">
            <i class="fas fa-fw fa-history"></i>
            <span>Lịch Sử Đặt Phòng</span>
        </a>
    </li>

    <!-- Nav Item - Tìm kiếm phòng -->
    <li class="nav-item">
        <a class="nav-link" href="/pdu_pms_project/public/student/search_rooms">
            <i class="fas fa-fw fa-search"></i>
            <span>Tìm Kiếm Phòng</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Lịch Trình
    </div>

    <!-- Nav Item - Lịch học -->
    <li class="nav-item">
        <a class="nav-link" href="/pdu_pms_project/public/student/schedule">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Lịch Học</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Tài Khoản
    </div>

    <!-- Nav Item - Hồ sơ cá nhân -->
    <li class="nav-item">
        <a class="nav-link" href="/pdu_pms_project/public/student/profile">
            <i class="fas fa-fw fa-user"></i>
            <span>Hồ Sơ Cá Nhân</span>
        </a>
    </li>

    <!-- Nav Item - Đổi mật khẩu -->
    <li class="nav-item">
        <a class="nav-link" href="/pdu_pms_project/public/student/change_password">
            <i class="fas fa-fw fa-key"></i>
            <span>Đổi Mật Khẩu</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="/pdu_pms_project/public/assets/img/undraw_rocket.svg" alt="Rocket illustration">
        <p class="text-center mb-2"><strong>PDU PMS</strong> giúp sinh viên dễ dàng đặt và quản lý phòng học</p>
        <a class="btn btn-success btn-sm" href="/pdu_pms_project/public/page/guide">Hướng Dẫn</a>
    </div>

</ul>
<!-- End of Sidebar -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy URL hiện tại
    const currentUrl = window.location.pathname;
    
    // Lấy tất cả các nav-item trong sidebar
    const navItems = document.querySelectorAll('#accordionSidebar .nav-item');
    
    // Xóa active class từ tất cả các item
    navItems.forEach(item => {
        item.classList.remove('active');
    });
    
    // Đặt active class dựa trên URL hiện tại
    navItems.forEach(item => {
        const link = item.querySelector('a.nav-link');
        if (link) {
            const href = link.getAttribute('href');
            if (currentUrl === href || currentUrl.includes(href) && href !== '/pdu_pms_project/public/student') {
                item.classList.add('active');
            } else if (currentUrl === '/pdu_pms_project/public/student' && href === '/pdu_pms_project/public/student') {
                item.classList.add('active');
            }
        }
    });
    
    // Đánh dấu sidebar collapse
    const sidebarToggleTop = document.querySelector('#sidebarToggleTop');
    const sidebarToggle = document.querySelector('#sidebarToggle');
    
    if (sidebarToggleTop) {
        sidebarToggleTop.addEventListener('click', function() {
            document.querySelector('body').classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.querySelector('body').classList.toggle('sidebar-toggled');
            document.querySelector('.sidebar').classList.toggle('toggled');
        });
    }
    
    // Tự động collapse sidebar khi màn hình nhỏ
    function checkScreenSize() {
        if (window.innerWidth < 768) {
            document.querySelector('.sidebar').classList.add('toggled');
        } else {
            document.querySelector('.sidebar').classList.remove('toggled');
        }
    }
    
    // Kiểm tra khi trang tải xong
    checkScreenSize();
    
    // Kiểm tra khi thay đổi kích thước cửa sổ
    window.addEventListener('resize', checkScreenSize);
});
</script> 