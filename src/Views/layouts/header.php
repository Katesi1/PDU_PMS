<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'PDU - PMS'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding-top: 70px; /* Adjust this to match your navbar height */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar-gradient {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
        }
        
        .nav-link {
            color: white !important;
            margin-right: 15px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }
        
        .btn-register {
            color: white !important;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
        }
        
        .user-dropdown {
            background-color: rgba(255,255,255,0.15);
            border-radius: 50px;
            padding: 8px 20px;
        }
        
        /* Styles for main navigation links */
        .main-links .nav-link {
            font-weight: 500;
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
        }
        
        .main-links .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: white;
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }
        
        .main-links .nav-link:hover::after {
            width: 70%;
        }

        /* Add main content wrapper styles */
        .main-content {
            flex: 1 0 auto;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        /* Auth links styling */
        .auth-link {
            color: white !important;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .auth-link:hover {
            transform: translateY(-2px);
        }
        
        /* Register button with border */
        .auth-link-register {
            border: 1px solid white;
        }
        
        .auth-link-register:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .py-5{
            padding-top: 5rem !important;
        }
        
        /* Avatar và Dropdown Menu Styles */
        .avatar-circle {
            width: 35px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
        
        .user-dropdown {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 50px;
            padding: 6px 12px;
            transition: all 0.3s;
        }
        
        .user-dropdown:hover, .user-dropdown:focus {
            background-color: rgba(255, 255, 255, 0.25);
        }
        
        .user-menu {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            animation: fadeIn 0.2s ease-in-out;
            min-width: 220px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .user-menu-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
        }
        
        .user-menu .dropdown-item {
            padding: 8px 16px;
            transition: all 0.2s;
        }
        
        .user-menu .dropdown-item:hover {
            background-color: #f1f5ff;
            transform: translateX(5px);
        }
        
        .user-menu .dropdown-item i {
            width: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-gradient navbar-dark fixed-top shadow">
        <div class="container">
            <!-- Logo and Main Nav -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center fw-bold" href="/pdu_pms_project/public/">
                    <i class="fas fa-school me-2"></i>
                    <span>PDU - PMS</span>
                </a>
                
                <!-- Main Navigation Links -->
                <div class="main-links d-none d-lg-flex ms-4">
                    <a class="nav-link px-3" href="/pdu_pms_project/public/page/about">
                        <i class="fas fa-info-circle me-1"></i>Giới thiệu
                    </a>
                    <a class="nav-link px-3" href="/pdu_pms_project/public/page/guide">
                        <i class="fas fa-book me-1"></i>Hướng dẫn
                    </a>
                    <a class="nav-link px-3" href="/pdu_pms_project/public/page/contact">
                        <i class="fas fa-envelope me-1"></i>Liên hệ
                    </a>
                </div>
            </div>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <!-- Mobile-only navigation links -->
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/pdu_pms_project/public/page/about">
                            <i class="fas fa-info-circle me-1"></i>Giới thiệu
                        </a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/pdu_pms_project/public/page/guide">
                            <i class="fas fa-book me-1"></i>Hướng dẫn
                        </a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="/pdu_pms_project/public/page/contact">
                            <i class="fas fa-envelope me-1"></i>Liên hệ
                        </a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <hr class="dropdown-divider my-2">
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- User Info & Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="avatar-circle me-2">
                                    <?php echo substr($_SESSION['full_name'] ?? 'U', 0, 1); ?>
                                </div>
                                <span class="fw-medium text-capitalize d-none d-md-inline"><?php echo $_SESSION['full_name']; ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow user-menu">
                                <!-- <li class="px-3 py-2 user-menu-header">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold mb-1"><?php echo $_SESSION['full_name']; ?></span>
                                        <span class="text-muted small"><?php echo ucfirst($_SESSION['role']); ?></span>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider m-0"></li> -->
                                <li>
                                    <a class="dropdown-item py-2" href="/pdu_pms_project/public/profile">
                                        <i class="fas fa-user me-2 text-primary"></i>Hồ sơ
                                    </a>
                                </li>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item py-2" href="/pdu_pms_project/public/admin">
                                        <i class="fas fa-tachometer-alt me-2 text-success"></i>Bảng điều khiển
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider m-0"></li>
                                <li>
                                    <a class="dropdown-item py-2" href="/pdu_pms_project/public/logout">
                                        <i class="fas fa-sign-out-alt me-2 text-danger"></i>Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link auth-link" href="/pdu_pms_project/public/login">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link auth-link" href="/pdu_pms_project/public/register">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="main-content">
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Charts.js nếu cần -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Enable dropdown on hover -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownElementList = document.querySelectorAll('.nav-item.dropdown');
            
            dropdownElementList.forEach(function(dropdownElement) {
                dropdownElement.addEventListener('mouseenter', function() {
                    let dropdown = new bootstrap.Dropdown(dropdownElement.querySelector('.dropdown-toggle'));
                    dropdown.show();
                });
                
                dropdownElement.addEventListener('mouseleave', function() {
                    let dropdown = bootstrap.Dropdown.getInstance(dropdownElement.querySelector('.dropdown-toggle'));
                    if (dropdown) {
                        dropdown.hide();
                    }
                });
            });
        });
    </script>
</body>
</html>