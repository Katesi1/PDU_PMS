<?php
// Ensure this is only for admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Get current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<style>
    /* Admin Sidebar Styles */
    body {
        overflow-x: hidden; /* Prevent horizontal scrollbar */
    }

    .admin-sidebar {
        height: calc(100vh - 56px); /* Subtract header height */
        background: linear-gradient(180deg, #0d6efd, #6610f2);
        color: white;
        width: 280px;
        position: fixed;
        top: 56px; /* Start below header */
        left: 0;
        z-index: 99; /* Just below header z-index */
        transition: all 0.3s ease;
        overflow-y: auto; /* Allow scrolling if menu is too long */
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        /* Customize scrollbar for sidebar */
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.2) transparent;
    }
    
    /* Theme color classes */
    .theme-blue-purple {
        background: linear-gradient(180deg, #0d6efd, #6610f2) !important;
    }
    
    .theme-green-teal {
        background: linear-gradient(180deg, #20c997, #198754) !important;
    }
    
    .theme-orange-red {
        background: linear-gradient(180deg, #fd7e14, #dc3545) !important;
    }
    
    .theme-indigo-purple {
        background: linear-gradient(180deg, #6610f2, #d63384) !important;
    }
    
    .theme-dark {
        background: linear-gradient(180deg, #212529, #343a40) !important;
    }
    
    /* Theme switcher styles */
    .theme-switcher {
        position: relative;
        width: 100%;
        padding: 0.5rem 1rem;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        background: transparent;
    }
    
    .theme-option {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .theme-option:hover, .theme-option.active {
        transform: scale(1.1);
        border-color: white;
    }
    
    .theme-option.blue-purple {
        background: linear-gradient(180deg, #0d6efd, #6610f2);
    }
    
    .theme-option.green-teal {
        background: linear-gradient(180deg, #20c997, #198754);
    }
    
    .theme-option.orange-red {
        background: linear-gradient(180deg, #fd7e14, #dc3545);
    }
    
    .theme-option.indigo-purple {
        background: linear-gradient(180deg, #6610f2, #d63384);
    }
    
    .theme-option.dark {
        background: linear-gradient(180deg, #212529, #343a40);
    }
    
    /* Hide theme switcher when sidebar is collapsed */
    .admin-sidebar.collapsed .theme-switcher {
        display: none;
    }

    /* Webkit scrollbar customization */
    .admin-sidebar::-webkit-scrollbar {
        width: 6px;
    }
    
    .admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .admin-sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.2);
        border-radius: 20px;
    }

    .admin-sidebar.collapsed {
        width: 70px;
        overflow-y: hidden; /* Hide scrollbar when collapsed */
    }

    .admin-sidebar .nav-item {
        margin-bottom: 5px;
    }

    .admin-sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 0.5rem;
        padding: 0.8rem 1.2rem;
        margin: 0 0.5rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .admin-sidebar .nav-link:hover {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateX(5px);
    }

    .admin-sidebar .nav-link.active {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: 600;
    }

    .admin-sidebar .nav-link i {
        min-width: 25px;
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .admin-sidebar.collapsed .nav-link span {
        display: none;
    }

    .admin-sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 0.8rem;
    }

    .admin-sidebar.collapsed .nav-link i {
        margin-right: 0;
    }

    .admin-sidebar .sidebar-footer {
        position: sticky;
        bottom: 0;
        width: 100%;
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: inherit;
    }

    .admin-sidebar .sidebar-toggler {
        cursor: pointer;
        text-align: right;
        padding: 10px 20px;
        position: sticky;
        top: 0;
        background: transparent;
        z-index: 1;
    }

    .admin-sidebar .sidebar-toggler i {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.2rem;
    }

    .admin-sidebar .sidebar-toggler:hover i {
        color: white;
    }

    /* Collapse button styles */
    .admin-sidebar.collapsed .sidebar-toggler {
        text-align: center;
        padding: 10px 0;
    }

    /* Admin content area */
    .admin-content {
        margin-left: 280px;
        padding: 20px 25px;
        padding-top: 76px; /* Give extra space for header (56px + 20px) */
        min-height: 100vh;
        transition: all 0.3s ease;
        background-color: #f8f9fc;
        position: relative;
        z-index: 1; /* Lower than sidebar */
    }

    .admin-content.expanded {
        margin-left: 70px;
    }

    /* Category headers */
    .sidebar-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1rem;
        color: rgba(255, 255, 255, 0.5);
        padding: 0.8rem 1.5rem;
        margin-top: 1rem;
    }

    /* Hide category names when collapsed */
    .admin-sidebar.collapsed .sidebar-category {
        text-align: center;
        padding: 0.8rem 0;
    }

    .admin-sidebar.collapsed .sidebar-category span {
        display: none;
    }
    
    /* Hide text in sidebar footer when collapsed */
    .admin-sidebar.collapsed .sidebar-footer span {
        display: none;
    }
    
    .admin-sidebar.collapsed .sidebar-footer .btn {
        justify-content: center;
        padding: 0.375rem;
        border: none;
        background: transparent;
    }
    
    .admin-sidebar.collapsed .sidebar-footer .btn i {
        margin-right: 0;
        font-size: 1.2rem;
    }
</style>

<div class="admin-sidebar" id="adminSidebar">
    <!-- Sidebar toggle -->
    <div class="sidebar-toggler" id="sidebarToggler">
        <i class="fas fa-chevron-left"></i>
    </div>
    
    <!-- Theme Switcher -->
    <div class="theme-switcher">
        <div class="theme-option blue-purple active" data-theme="theme-blue-purple" title="Xanh dương - Tím"></div>
        <div class="theme-option green-teal" data-theme="theme-green-teal" title="Xanh lá - Xanh ngọc"></div>
        <div class="theme-option orange-red" data-theme="theme-orange-red" title="Cam - Đỏ"></div>
        <div class="theme-option indigo-purple" data-theme="theme-indigo-purple" title="Chàm - Tím"></div>
        <div class="theme-option dark" data-theme="theme-dark" title="Tối"></div>
    </div>

    <!-- Admin Menu -->
    <ul class="nav flex-column">
        <div class="sidebar-category"><span>Tổng quan</span></div>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'dashboard' || $current_page == 'index') ? 'active' : '' ?>" href="/pdu_pms_project/public/admin">
                <i class="fas fa-tachometer-alt"></i>
                <span>Bảng điều khiển</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'reports' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/reports">
                <i class="fas fa-chart-bar"></i>
                <span>Báo cáo & Thống kê</span>
            </a>
        </li>

        <div class="sidebar-category"><span>Quản lý phòng</span></div>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'manage_rooms' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/manage_rooms">
                <i class="fas fa-door-open"></i>
                <span>Quản lý phòng học</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'manage_room_types' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/manage_room_types">
                <i class="fas fa-th-large"></i>
                <span>Loại phòng</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'room_types' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/room_types">
                <i class="fas fa-cog"></i>
                <span>Cấu hình phòng</span>
            </a>
        </li>

        <div class="sidebar-category"><span>Đặt phòng & Lịch</span></div>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'manage_bookings' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/manage_bookings">
                <i class="fas fa-calendar-check"></i>
                <span>Quản lý đặt phòng</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'manage_timetable' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/manage_timetable">
                <i class="fas fa-calendar-alt"></i>
                <span>Quản lý lịch dạy</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'auto_schedule' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/auto_schedule">
                <i class="fas fa-magic"></i>
                <span>Xếp lịch tự động</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'search_rooms' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/search_rooms">
                <i class="fas fa-search"></i>
                <span>Tìm kiếm phòng</span>
            </a>
        </li>

        <div class="sidebar-category"><span>Hệ thống</span></div>
        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'manage_users' ? 'active' : '' ?>" href="/pdu_pms_project/public/admin/manage_users">
                <i class="fas fa-users"></i>
                <span>Quản lý người dùng</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/pdu_pms_project/public/admin/settings">
                <i class="fas fa-cogs"></i>
                <span>Cài đặt hệ thống</span>
            </a>
        </li>
    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="/pdu_pms_project/public" class="btn btn-outline-light btn-sm w-100 d-flex align-items-center justify-content-center">
            <i class="fas fa-home me-2"></i>
            <span>Về trang chủ</span>
        </a>
    </div>
</div>

<div class="admin-content" id="adminContent">
    <!-- Content will go here -->

<script>
    // Toggle sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const content = document.getElementById('adminContent');
        const toggler = document.getElementById('sidebarToggler');
        
        // Check for saved state
        const sidebarState = localStorage.getItem('adminSidebarState');
        if (sidebarState === 'collapsed') {
            sidebar.classList.add('collapsed');
            content.classList.add('expanded');
            toggler.innerHTML = '<i class="fas fa-chevron-right"></i>';
        }
        
        toggler.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                toggler.innerHTML = '<i class="fas fa-chevron-right"></i>';
                localStorage.setItem('adminSidebarState', 'collapsed');
            } else {
                toggler.innerHTML = '<i class="fas fa-chevron-left"></i>';
                localStorage.setItem('adminSidebarState', 'expanded');
            }
        });
        
        // Theme switcher
        const themeOptions = document.querySelectorAll('.theme-option');
        const savedTheme = localStorage.getItem('adminSidebarTheme');
        
        // Apply saved theme if exists
        if (savedTheme) {
            sidebar.classList.remove('theme-blue-purple', 'theme-green-teal', 'theme-orange-red', 'theme-indigo-purple', 'theme-dark');
            sidebar.classList.add(savedTheme);
            
            // Update active state
            themeOptions.forEach(option => {
                if (option.dataset.theme === savedTheme) {
                    option.classList.add('active');
                } else {
                    option.classList.remove('active');
                }
            });
        } else {
            // Add default theme class
            sidebar.classList.add('theme-blue-purple');
        }
        
        // Theme option click handler
        themeOptions.forEach(option => {
            option.addEventListener('click', function() {
                const theme = this.dataset.theme;
                
                // Remove all theme classes
                sidebar.classList.remove('theme-blue-purple', 'theme-green-teal', 'theme-orange-red', 'theme-indigo-purple', 'theme-dark');
                
                // Add selected theme
                sidebar.classList.add(theme);
                
                // Save to localStorage
                localStorage.setItem('adminSidebarTheme', theme);
                
                // Update active state
                themeOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script> 