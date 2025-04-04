<?php
// Đảm bảo chỉ cho teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Lấy trang hiện tại để highlight menu
$request_uri = $_SERVER['REQUEST_URI'];
$current_page = '';

// Trích xuất trang hiện tại từ URI
if (strpos($request_uri, '/teacher/') !== false) {
    $path = parse_url($request_uri, PHP_URL_PATH);
    $path_parts = explode('/', $path);
    
    // Tìm vị trí teacher trong path
    $teacher_index = array_search('teacher', $path_parts);
    
    // Lấy phần tiếp theo sau 'teacher' nếu có
    if ($teacher_index !== false && isset($path_parts[$teacher_index + 1]) && !empty($path_parts[$teacher_index + 1])) {
        $current_page = $path_parts[$teacher_index + 1];
    }
}

// Mặc định là 'index' nếu đang ở trang chính của teacher
if (empty($current_page) || $current_page === 'teacher') {
    $current_page = 'index';
}
?>

<style>
    /* Teacher Sidebar Styles */
    body {
        overflow-x: hidden; /* Ngăn thanh cuộn ngang */
    }

    .teacher-sidebar {
        height: calc(100vh - 56px); /* Trừ chiều cao header */
        background: linear-gradient(180deg, #20c997, #198754);
        color: white;
        width: 280px;
        position: fixed;
        top: 56px; /* Bắt đầu từ dưới header */
        left: 0;
        z-index: 99;
        transition: all 0.3s ease;
        overflow-y: auto;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.2) transparent;
    }

    /* Webkit scrollbar customization */
    .teacher-sidebar::-webkit-scrollbar {
        width: 6px;
    }
    
    .teacher-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .teacher-sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.2);
        border-radius: 20px;
    }

    .teacher-sidebar.collapsed {
        width: 70px;
        overflow-y: hidden;
    }

    .teacher-sidebar .nav-item {
        margin-bottom: 5px;
    }

    .teacher-sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 0.5rem;
        padding: 0.8rem 1.2rem;
        margin: 0 0.5rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .teacher-sidebar .nav-link:hover {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateX(5px);
    }

    .teacher-sidebar .nav-link.active {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: 600;
    }

    .teacher-sidebar .nav-link i {
        min-width: 25px;
        margin-right: 10px;
        font-size: 1.1rem;
    }

    .teacher-sidebar.collapsed .nav-link span {
        display: none;
    }

    .teacher-sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 0.8rem;
    }

    .teacher-sidebar.collapsed .nav-link i {
        margin-right: 0;
    }

    .content-wrapper {
        margin-left: 280px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .content-wrapper.expanded {
        margin-left: 70px;
    }

    @media (max-width: 768px) {
        .teacher-sidebar {
            width: 70px;
        }
        
        .teacher-sidebar .nav-link span {
            display: none;
        }
        
        .teacher-sidebar .nav-link {
            justify-content: center;
            padding: 0.8rem;
        }
        
        .teacher-sidebar .nav-link i {
            margin-right: 0;
        }
        
        .content-wrapper {
            margin-left: 70px;
        }
    }

    /* Dropdown styles */
    .teacher-sidebar .dropdown-menu {
        margin-top: 0;
        width: 90%;
        margin-left: 5%;
        border: none;
    }

    .teacher-sidebar .dropdown-toggle::after {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    .teacher-sidebar .dropdown-item {
        padding: 0.7rem 1.2rem 0.7rem 2.2rem;
        transition: all 0.3s ease;
    }

    .teacher-sidebar .dropdown-item:hover {
        transform: translateX(5px);
    }

    .teacher-sidebar .dropdown-item.active {
        font-weight: 600;
    }

    .teacher-sidebar .dropdown-menu {
        background: rgba(25, 135, 84, 0.9);
    }

    .teacher-sidebar.collapsed .dropdown-toggle::after {
        display: none;
    }

    .teacher-sidebar.collapsed .dropdown-menu {
        width: 180px;
        left: 70px;
        position: absolute;
        margin-top: -45px;
    }

    .teacher-sidebar.collapsed .nav-link span {
        display: none;
    }
</style>

<!-- Sidebar Toggle -->
<button class="btn btn-link text-white d-md-none" id="sidebarToggle" style="position: fixed; top: 60px; left: 10px; z-index: 100; font-size: 1.5rem;">
    <i class="fas fa-bars"></i>
</button>

<!-- Teacher Sidebar -->
<div class="teacher-sidebar">
    <!-- Teacher Info -->
    <div class="d-flex align-items-center px-3 py-3 mb-3 border-bottom border-light">
        <div class="me-3 position-relative" style="background-color: #20c997; width: 50px; height: 50px; border-radius: 4px;">
            <div class="position-absolute" style="top: 6px; text-align: center; width: 100%;">
                <i class="fas fa-dove text-white" style="font-size: 14px;"></i>
            </div>
            <div class="position-absolute" style="top: 20px; text-align: center; width: 100%;">
                <span class="fw-bold text-white" style="font-size: 16px;">Teach</span>
            </div>
        </div>
        <div class="text-white">
            <h6 class="mb-0"><?= $_SESSION['username'] ?? 'Giảng Viên' ?></h6>
            <small class="text-light">Giảng Viên</small>
        </div>
    </div>

    <!-- Navigation -->
    <ul class="nav flex-column">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link <?= $current_page === 'index' ? 'active' : '' ?>" href="/pdu_pms_project/public/teacher">
                <i class="fas fa-tachometer-alt"></i>
                <span>Bảng Điều Khiển</span>
            </a>
        </li>

        <!-- Đặt Phòng -->
        <li class="nav-item">
            <a class="nav-link <?= ($current_page === 'book_room' || $current_page === 'search_rooms' || $current_page === 'room_detail' || $current_page === 'suggest_rooms') ? 'active' : '' ?>" href="/pdu_pms_project/public/teacher/book_room">
                <i class="fas fa-bookmark"></i>
                <span>Đặt Phòng</span>
            </a>
        </li>
    </ul>
    
    <!-- Sidebar Footer -->
    <div class="mt-auto pt-3 px-3 pb-3 border-top border-light d-flex justify-content-between align-items-center">
        <small><i class="fas fa-cog"></i> Cài đặt</small>
        <a href="/pdu_pms_project/public/logout" class="text-white" title="Đăng xuất">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
</div>

<!-- Main Content Wrapper -->
<div class="content-wrapper" id="contentWrapper">
    <div class="container-fluid">
        <!-- Page content goes here -->

<script>
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.teacher-sidebar');
        const contentWrapper = document.getElementById('contentWrapper');
        
        // Check for saved state
        const sidebarCollapsed = localStorage.getItem('teacherSidebarCollapsed') === 'true';
        
        // Apply saved state on load
        if (sidebarCollapsed || window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
            contentWrapper.classList.add('expanded');
        }
        
        // Toggle sidebar on button click
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            contentWrapper.classList.toggle('expanded');
            
            // Save state to localStorage
            localStorage.setItem('teacherSidebarCollapsed', sidebar.classList.contains('collapsed'));
        });
        
        // Auto-collapse on small screens
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
                contentWrapper.classList.add('expanded');
            } else if (!sidebarCollapsed) {
                sidebar.classList.remove('collapsed');
                contentWrapper.classList.remove('expanded');
            }
        });
    });
    
    // Handle dropdowns in sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownToggles = document.querySelectorAll('.teacher-sidebar .dropdown-toggle');
        
        dropdownToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const dropdownMenu = this.nextElementSibling;
                const isSidebarCollapsed = document.querySelector('.teacher-sidebar').classList.contains('collapsed');
                
                // On mobile or when sidebar is collapsed, show dropdown to the right
                if (isSidebarCollapsed) {
                    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
                } else {
                    // Toggle dropdown
                    $(this).dropdown('toggle');
                }
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.querySelector('.teacher-sidebar');
            const isSidebarCollapsed = sidebar.classList.contains('collapsed');
            
            if (isSidebarCollapsed) {
                const dropdownMenus = document.querySelectorAll('.teacher-sidebar .dropdown-menu');
                const dropdownToggles = document.querySelectorAll('.teacher-sidebar .dropdown-toggle');
                
                let clickedOnToggle = false;
                dropdownToggles.forEach(function(toggle) {
                    if (toggle.contains(e.target)) {
                        clickedOnToggle = true;
                    }
                });
                
                if (!clickedOnToggle) {
                    dropdownMenus.forEach(function(menu) {
                        menu.style.display = 'none';
                    });
                }
            }
        });
    });
</script> 