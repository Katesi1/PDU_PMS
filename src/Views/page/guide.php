<?php
// Sử dụng đường dẫn tuyệt đối để tránh lỗi
$title = 'Hướng dẫn sử dụng';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
?>

<style>
/* Custom tab styling */
.nav-tabs .nav-item .nav-link {
    color: #495057; /* Darker text color for better visibility */
    font-weight: 500;
    border: none;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.nav-tabs .nav-item .nav-link:hover {
    color: #0d6efd;
    border-bottom-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.05);
}

.nav-tabs .nav-item .nav-link.active {
    color: #0d6efd;
    background-color: #fff;
    border-bottom: 3px solid #0d6efd;
    font-weight: 600;
}

/* Explicit styling fix for tab buttons */
#guideTabs button.nav-link {
    color: #495057 !important; /* Force text color */
}

#guideTabs button.nav-link:hover {
    color: #0d6efd !important;
}

#guideTabs button.nav-link.active {
    color: #0d6efd !important;
}

/* Card enhancements */
.feature-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.125);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.feature-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,0.125);
    padding: 1rem;
}

.feature-card .card-header i {
    font-size: 1.5rem;
}

/* Section styling */
.guide-section {
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #0d6efd;
}

.guide-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e7f1ff;
    border-radius: 50%;
    color: #0d6efd;
    font-size: 1.25rem;
    margin-right: 1rem;
}

/* Timeline styling */
.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline:before {
    content: "";
    position: absolute;
    left: 0.75rem;
    top: 0;
    height: 100%;
    width: 4px;
    background: #e9ecef;
    border-radius: 2px;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -2.25rem;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #0d6efd;
    top: 0.25rem;
}

/* FAQ styling */
.faq-item {
    margin-bottom: 1rem;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.125);
}

.faq-question {
    background-color: #f8f9fa;
    padding: 1rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.faq-answer {
    padding: 1rem;
    border-top: 1px solid rgba(0,0,0,0.125);
}
</style>

<div class="container-fluid px-4 py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/pdu_pms_project/public" class="text-primary">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hướng dẫn sử dụng</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-primary bg-gradient rounded shadow-sm mb-4 p-4 text-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">Hướng dẫn sử dụng PDU-PMS</h1>
                <p class="opacity-75">Tài liệu hướng dẫn chi tiết cho hệ thống quản lý phòng học</p>
            </div>
            <div class="d-none d-md-block">
                <i class="fas fa-book-reader display-4 text-white opacity-25"></i>
            </div>
        </div>
    </div>

    <!-- Guide Content -->
    <div class="card shadow-sm mb-4">
        <!-- Navigation Tabs -->
        <div class="card-header bg-white p-0">
            <ul class="nav nav-tabs nav-fill" id="guideTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active px-4 py-3" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-selected="true">
                        <i class="fas fa-home me-2"></i>Tổng quan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin" type="button" role="tab" aria-selected="false">
                        <i class="fas fa-user-shield me-2"></i>Quản trị viên
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3" id="teacher-tab" data-bs-toggle="tab" data-bs-target="#teacher" type="button" role="tab" aria-selected="false">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Giảng viên
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-selected="false">
                        <i class="fas fa-user-graduate me-2"></i>Sinh viên
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" type="button" role="tab" aria-selected="false">
                        <i class="fas fa-question-circle me-2"></i>Câu hỏi thường gặp
                    </button>
                </li>
            </ul>
        </div>
        
        <!-- Tab Contents -->
        <div class="card-body">
            <div class="tab-content" id="guideTabsContent">
                <!-- General Guide -->
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="d-flex align-items-center mb-4">
                        <div class="guide-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h2 class="h4 mb-0">Giới thiệu về PDU-PMS</h2>
                    </div>

                    <div class="guide-section mb-4">
                        <h3 class="h5 mb-3">Về hệ thống</h3>
                        <p class="mb-3">
                            PDU-PMS (Phuong Dong University - Phòng Management System) là hệ thống quản lý phòng học hiện đại được phát triển nhằm tối ưu hóa việc sử dụng tài nguyên phòng học và thiết bị của trường đại học. Hệ thống cho phép quản lý toàn diện về phòng học, lịch dạy, và quản lý người dùng.
                        </p>
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h4 class="h6 fw-bold text-primary mb-2">Tính năng chính:</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="ps-4 mb-0">
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Quản lý thông tin phòng học và trang thiết bị</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Đặt phòng trực tuyến và xem lịch sử đặt phòng</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Theo dõi lịch sử sử dụng phòng học</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Quản lý bảo trì và báo cáo sự cố</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Phân tích hiệu suất sử dụng phòng học</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="ps-4 mb-0">
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Xếp lịch tự động cho các lớp học</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Quản lý người dùng (Admin, Giảng viên, Sinh viên)</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Thông báo và nhắc nhở về lịch học</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Thống kê và báo cáo sử dụng phòng học</li>
                                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Tích hợp với hệ thống học vụ</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="guide-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-sign-in-alt fs-3 text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Hướng dẫn đăng nhập</h3>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="bg-white p-3 rounded shadow-sm h-100">
                                    <h4 class="h6 fw-bold mb-3">Quy trình đăng nhập:</h4>
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Bước 1:</strong> Truy cập vào trang đăng nhập</p>
                                            <p class="small text-muted ms-2">Mở trình duyệt và nhập địa chỉ: pdu-pms.edu.vn/login</p>
                                        </div>
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Bước 2:</strong> Nhập tên đăng nhập (mã số cá nhân) và mật khẩu</p>
                                            <p class="small text-muted ms-2">Mã số sinh viên/giảng viên là tên đăng nhập mặc định</p>
                                        </div>
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Bước 3:</strong> Nhấn nút "Đăng nhập"</p>
                                        </div>
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Bước 4:</strong> Đối với lần đăng nhập đầu tiên, bạn sẽ được yêu cầu đổi mật khẩu</p>
                                            <p class="small text-muted ms-2">Mật khẩu mới cần có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số</p>
                                        </div>
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Bước 5:</strong> Thiết lập câu hỏi bảo mật</p>
                                            <p class="small text-muted ms-2">Dùng để khôi phục mật khẩu khi cần thiết</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h4 class="h6 mb-0">Thông tin đăng nhập mẫu</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-user-shield text-primary me-2"></i>
                                                <p class="small text-muted mb-0">Quản trị viên:</p>
                                            </div>
                                            <div class="bg-light p-2 rounded small">
                                                <code>
                                                    Tài khoản: admin<br>
                                                    Mật khẩu: password
                                                </code>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                                                <p class="small text-muted mb-0">Giảng viên:</p>
                                            </div>
                                            <div class="bg-light p-2 rounded small">
                                                <code>
                                                    Tài khoản: teacher<br>
                                                    Mật khẩu: password
                                                </code>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-user-graduate text-primary me-2"></i>
                                                <p class="small text-muted mb-0">Sinh viên:</p>
                                            </div>
                                            <div class="bg-light p-2 rounded small">
                                                <code>
                                                    Tài khoản: student<br>
                                                    Mật khẩu: password
                                                </code>
                                            </div>
                                        </div>
                                        <div class="alert alert-danger small mt-3 mb-0">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            Thông tin này chỉ dùng cho mục đích demo. Vui lòng đổi mật khẩu ngay sau khi đăng nhập thành công.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="guide-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-desktop fs-3 text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Giao diện hệ thống</h3>
                        </div>
                        <p class="mb-3">
                            Giao diện PDU-PMS được thiết kế trực quan, dễ sử dụng với các thành phần chính sau:
                        </p>
                        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                            <div class="col">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-bars text-primary"></i>
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title h6 mb-2">Thanh điều hướng</h4>
                                        <p class="card-text small">
                                            Nằm bên trái màn hình, cho phép truy cập nhanh đến các chức năng chính của hệ thống.
                                        </p>
                                        <ul class="text-start small ps-4 mb-0">
                                            <li>Dashboard</li>
                                            <li>Quản lý phòng học</li>
                                            <li>Quản lý lịch giảng dạy</li>
                                            <li>Đặt phòng tự học</li>
                                            <li>Báo cáo sự cố</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-tachometer-alt text-primary"></i>
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title h6 mb-2">Dashboard</h4>
                                        <p class="card-text small">
                                            Hiển thị tổng quan về thông tin quan trọng, thống kê và hoạt động gần đây.
                                        </p>
                                        <ul class="text-start small ps-4 mb-0">
                                            <li>Thông báo mới</li>
                                            <li>Lịch học/giảng dạy hôm nay</li>
                                            <li>Thống kê tình trạng phòng</li>
                                            <li>Phòng đang sử dụng/trống</li>
                                            <li>Sự kiện sắp diễn ra</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-user-circle text-primary"></i>
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title h6 mb-2">Quản lý tài khoản</h4>
                                        <p class="card-text small">
                                            Truy cập từ góc trên bên phải, cho phép quản lý thông tin cá nhân và đăng xuất.
                                        </p>
                                        <ul class="text-start small ps-4 mb-0">
                                            <li>Thông tin cá nhân</li>
                                            <li>Đổi mật khẩu</li>
                                            <li>Thiết lập thông báo</li>
                                            <li>Xem lịch sử hoạt động</li>
                                            <li>Đăng xuất</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning d-flex">
                            <div class="me-3">
                                <i class="fas fa-lightbulb text-warning fs-4"></i>
                            </div>
                            <div>
                                <h4 class="h6 text-warning mb-1">Mẹo sử dụng:</h4>
                                <p class="small mb-0">
                                    Bạn có thể thu gọn thanh điều hướng bằng cách nhấn vào biểu tượng mũi tên ở phía trên để có không gian làm việc rộng hơn. Các tính năng vẫn có thể được truy cập thông qua các biểu tượng.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="guide-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-mobile-alt fs-3 text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Phiên bản di động</h3>
                        </div>
                        <p class="mb-3">
                            PDU-PMS có giao diện tối ưu cho thiết bị di động, giúp người dùng dễ dàng truy cập mọi lúc, mọi nơi.
                        </p>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="bg-white p-3 rounded shadow-sm">
                                    <h4 class="h6 fw-bold text-primary mb-3">Tính năng trên di động:</h4>
                                    <div class="d-flex mb-2">
                                        <div class="me-3 text-primary">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <div>
                                            <p class="fw-medium mb-1">Xem lịch học/giảng dạy</p>
                                            <p class="small text-muted mb-0">Truy cập nhanh lịch học hoặc lịch giảng dạy của bạn</p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="me-3 text-primary">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <div>
                                            <p class="fw-medium mb-1">Nhận thông báo</p>
                                            <p class="small text-muted mb-0">Thông báo về thay đổi lịch học, đặt phòng thành công, v.v.</p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="me-3 text-primary">
                                            <i class="fas fa-qrcode"></i>
                                        </div>
                                        <div>
                                            <p class="fw-medium mb-1">Quét mã QR</p>
                                            <p class="small text-muted mb-0">Điểm danh hoặc xác nhận sử dụng phòng học</p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="me-3 text-primary">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div>
                                            <p class="fw-medium mb-1">Báo cáo sự cố</p>
                                            <p class="small text-muted mb-0">Báo cáo nhanh các vấn đề về trang thiết bị trong phòng học</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white p-3 rounded shadow-sm">
                                    <h4 class="h6 fw-bold text-primary mb-3">Cách truy cập:</h4>
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Phương pháp 1:</strong> Truy cập qua trình duyệt di động</p>
                                            <p class="small text-muted ms-2">Mở trình duyệt trên thiết bị di động và truy cập vào địa chỉ pdu-pms.edu.vn</p>
                                        </div>
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Phương pháp 2:</strong> Cài đặt ứng dụng di động</p>
                                            <p class="small text-muted ms-2">Tải ứng dụng PDU-PMS từ App Store (iOS) hoặc Google Play Store (Android)</p>
                                        </div>
                                        <div class="timeline-item">
                                            <span class="timeline-marker"></span>
                                            <p class="mb-1"><strong>Phương pháp 3:</strong> Thêm vào màn hình chính</p>
                                            <p class="small text-muted ms-2">Khi truy cập qua trình duyệt, bạn có thể thêm trang web vào màn hình chính để truy cập nhanh hơn</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <span></span>
                        <button class="btn btn-primary" onclick="document.getElementById('admin-tab').click()">
                            Hướng dẫn cho Quản trị viên
                            <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Admin Guide -->
                <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                    <div class="d-flex align-items-center mb-4">
                        <div class="guide-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h2 class="h4 mb-0">Hướng dẫn cho Quản trị viên</h2>
                    </div>
                    <p class="mb-4">
                        Phần này cung cấp hướng dẫn chi tiết về các chức năng dành cho quản trị viên, bao gồm quản lý người dùng, quản lý phòng, quản lý lịch dạy và xếp lịch tự động.
                    </p>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="feature-card h-100">
                                <div class="card-header text-center">
                                    <i class="fas fa-users text-primary"></i>
                                </div>
                                <div class="card-body">
                                    <h3 class="h5 mb-3 text-center">Quản lý người dùng</h3>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2 d-flex">
                                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                            <span>Thêm, sửa, xóa tài khoản người dùng</span>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                            <span>Phân quyền và quản lý vai trò</span>
                                        </li>
                                        <li class="d-flex">
                                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                            <span>Đặt lại mật khẩu khi cần thiết</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="feature-card h-100">
                                <div class="card-header text-center">
                                    <i class="fas fa-building text-primary"></i>
                                </div>
                                <div class="card-body">
                                    <h3 class="h5 mb-3 text-center">Quản lý phòng</h3>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2 d-flex">
                                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                            <span>Thêm mới và cập nhật thông tin phòng</span>
                                        </li>
                                        <li class="mb-2 d-flex">
                                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                            <span>Quản lý trang thiết bị</span>
                                        </li>
                                        <li class="d-flex">
                                            <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                            <span>Giám sát tình trạng sử dụng</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="guide-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-users-cog fs-3 text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Quản lý người dùng chi tiết</h3>
                        </div>
                        
                        <div class="bg-white p-4 rounded shadow-sm mb-3">
                            <h4 class="h6 text-primary mb-3">Thêm người dùng mới</h4>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Truy cập vào menu <span class="fw-bold">Quản lý người dùng</span> từ thanh điều hướng.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Nhấp vào nút <span class="fw-bold text-primary">+ Thêm người dùng</span> ở góc trên bên phải.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Điền đầy đủ thông tin vào biểu mẫu, bao gồm tên, email, số điện thoại, vai trò, v.v.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Chọn loại tài khoản phù hợp (Admin, Giảng viên, Sinh viên).</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Nhấp vào <span class="fw-bold">Lưu</span> để tạo tài khoản mới.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex">
                        <div class="me-3">
                            <i class="fas fa-info-circle text-info fs-4"></i>
                        </div>
                        <div>
                            <h4 class="h6 text-info mb-1">Lưu ý quan trọng:</h4>
                            <p class="small mb-0">
                                Khi tạo tài khoản mới, hệ thống sẽ tự động gửi email thông báo với mật khẩu tạm thời cho người dùng. Người dùng sẽ được yêu cầu đổi mật khẩu khi đăng nhập lần đầu tiên. Nếu người dùng không nhận được email, quản trị viên có thể tạo lại mật khẩu tạm thời.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button class="btn btn-primary" onclick="document.getElementById('general-tab').click()">
                            <i class="fas fa-arrow-left me-1"></i>
                            Tổng quan
                        </button>
                        <button class="btn btn-primary" onclick="document.getElementById('teacher-tab').click()">
                            Hướng dẫn cho Giảng viên
                            <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Teacher Guide -->
                <div class="tab-pane fade" id="teacher" role="tabpanel" aria-labelledby="teacher-tab">
                    <div class="d-flex align-items-center mb-4">
                        <div class="guide-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h2 class="h4 mb-0">Hướng dẫn cho Giảng viên</h2>
                    </div>
                    <p class="mb-4">
                        Hướng dẫn này cung cấp thông tin chi tiết về cách giảng viên có thể sử dụng hệ thống PDU-PMS để quản lý phòng học, lịch dạy và các tài nguyên giảng dạy khác.
                    </p>

                    <div class="guide-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-calendar-day fs-3 text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Xem lịch giảng dạy</h3>
                        </div>
                        
                        <div class="bg-white p-4 rounded shadow-sm mb-3">
                            <h4 class="h6 text-primary mb-3">Truy cập lịch giảng dạy</h4>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Đăng nhập vào hệ thống với tài khoản giảng viên.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Trên trang Dashboard, bạn sẽ thấy lịch giảng dạy của tuần hiện tại.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Sử dụng các điều khiển để chuyển đổi giữa chế độ xem ngày, tuần hoặc tháng.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Nhấp vào mũi tên điều hướng để xem lịch của các tuần khác.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-sliders-h text-primary"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="h6 text-center mb-3">Cá nhân hóa chế độ xem lịch</h4>
                                        <ul class="ps-4">
                                            <li class="mb-2">Lọc theo loại lớp học hoặc môn học.</li>
                                            <li class="mb-2">Đánh dấu màu cho các loại lớp học khác nhau.</li>
                                            <li class="mb-2">Hiển thị/ẩn thông tin chi tiết (sĩ số, phòng học, v.v.).</li>
                                            <li>Xuất lịch ra file Excel hoặc PDF để sử dụng ngoại tuyến.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-sync-alt text-primary"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="h6 text-center mb-3">Tích hợp với ứng dụng lịch cá nhân</h4>
                                        <ul class="ps-4">
                                            <li class="mb-2">Tạo URL đồng bộ iCal để thêm vào Google Calendar, Outlook, v.v.</li>
                                            <li class="mb-2">Nhận thông báo tự động về thay đổi lịch.</li>
                                            <li>Thiết lập nhắc nhở trước khi bắt đầu lớp học.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success d-flex">
                        <div class="me-3">
                            <i class="fas fa-leaf text-success fs-4"></i>
                        </div>
                        <div>
                            <h4 class="h6 text-success mb-1">Thực hành tốt:</h4>
                            <p class="small mb-0">
                                Để đảm bảo hiệu quả sử dụng tài nguyên phòng học, hãy đặt phòng với sức chứa phù hợp với số lượng người tham dự, hủy đặt phòng càng sớm càng tốt nếu không sử dụng, và tuân thủ thời gian bắt đầu và kết thúc để không ảnh hưởng đến người sử dụng tiếp theo.
                            </p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button class="btn btn-primary" onclick="document.getElementById('admin-tab').click()">
                            <i class="fas fa-arrow-left me-1"></i>
                            Hướng dẫn cho Quản trị viên
                        </button>
                        <button class="btn btn-primary" onclick="document.getElementById('student-tab').click()">
                            Hướng dẫn cho Sinh viên
                            <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                <!-- Student Guide -->
                <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                    <div class="d-flex align-items-center mb-4">
                        <div class="guide-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h2 class="h4 mb-0">Hướng dẫn cho Sinh viên</h2>
                    </div>
                    <p class="mb-4">
                        Phần này hướng dẫn sinh viên cách sử dụng hệ thống PDU-PMS để xem lịch học, đặt phòng tự học và các tính năng khác dành cho sinh viên.
                    </p>

                    <div class="guide-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-clock fs-3 text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Xem lịch học</h3>
                        </div>
                        
                        <div class="bg-white p-4 rounded shadow-sm mb-3">
                            <h4 class="h6 text-primary mb-3">Truy cập lịch học</h4>
                            <p class="mb-2">Để xem lịch học của bạn:</p>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Đăng nhập vào hệ thống với tài khoản sinh viên.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Trên trang Dashboard, bạn sẽ thấy lịch học của tuần hiện tại.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Sử dụng các điều khiển để chuyển đổi giữa chế độ xem ngày, tuần hoặc tháng.</p>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-marker"></span>
                                    <p class="mb-1">Lọc lịch học theo môn học hoặc giảng viên nếu cần.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="guide-section mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-book-reader fs-3 text-primary"></i>
                            </div>
                            <h3 class="h5 mb-0">Đặt phòng tự học</h3>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-tasks text-primary"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="h6 text-center mb-3">Quy trình đặt phòng tự học</h4>
                                        <ol class="ps-4">
                                            <li class="mb-2">Truy cập vào chức năng <span class="fw-bold">Đặt phòng tự học</span>.</li>
                                            <li class="mb-2">Chọn ngày và khung giờ mong muốn.</li>
                                            <li class="mb-2">Xem danh sách các phòng khả dụng trong thời gian đã chọn.</li>
                                            <li class="mb-2">Lọc theo nhu cầu (phòng yên tĩnh, phòng làm việc nhóm, v.v.).</li>
                                            <li>Chọn phòng và xác nhận đặt phòng.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-clipboard-list text-primary"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="h6 text-center mb-3">Các loại phòng tự học</h4>
                                        <ul class="ps-4 mb-0">
                                            <li class="mb-2"><span class="fw-bold">Phòng yên tĩnh:</span> Dành cho học tập cá nhân, không gian yên tĩnh</li>
                                            <li class="mb-2"><span class="fw-bold">Phòng thảo luận:</span> Dành cho nhóm nhỏ làm việc cùng nhau</li>
                                            <li class="mb-2"><span class="fw-bold">Phòng dự án:</span> Trang bị bảng lớn và thiết bị hỗ trợ làm việc nhóm</li>
                                            <li><span class="fw-bold">Phòng máy tính:</span> Có máy tính và phần mềm chuyên dụng</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                        </div>
                        <div>
                            <h4 class="h6 text-warning mb-1">Quy định đặt phòng:</h4>
                            <ul class="mb-0 ps-4 small">
                                <li>Mỗi sinh viên được đặt tối đa 2 giờ mỗi ngày cho phòng tự học.</li>
                                <li>Đặt phòng nhóm yêu cầu có ít nhất 3 sinh viên tham gia.</li>
                                <li>Không sử dụng phòng sẽ bị ghi nhận và có thể bị hạn chế quyền đặt phòng.</li>
                                <li>Không được mang thức ăn vào phòng học (chỉ được mang đồ uống có nắp).</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button class="btn btn-primary" onclick="document.getElementById('teacher-tab').click()">
                            <i class="fas fa-arrow-left me-1"></i>
                            Hướng dẫn cho Giảng viên
                        </button>
                        <button class="btn btn-primary" onclick="document.getElementById('faq-tab').click()">
                            Câu hỏi thường gặp
                            <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                    <div class="d-flex align-items-center mb-4">
                        <div class="guide-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h2 class="h4 mb-0">Câu hỏi thường gặp</h2>
                    </div>
                    <p class="mb-4">
                        Dưới đây là những câu hỏi thường gặp về hệ thống PDU-PMS. Nếu bạn không tìm thấy câu trả lời cho câu hỏi của mình, vui lòng liên hệ với bộ phận hỗ trợ.
                    </p>

                    <div class="accordion mb-4" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Làm thế nào để đặt lại mật khẩu khi quên?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Để đặt lại mật khẩu, nhấp vào liên kết "Quên mật khẩu" trên trang đăng nhập. Nhập email đã đăng ký của bạn, và hệ thống sẽ gửi hướng dẫn đặt lại mật khẩu qua email. Nếu bạn không nhận được email, hãy kiểm tra thư mục spam hoặc liên hệ với quản trị viên hệ thống thông qua Phòng Đào tạo theo số điện thoại 024-3784-8513.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Tôi có thể truy cập hệ thống từ thiết bị di động không?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, PDU-PMS được thiết kế để hoạt động trên tất cả các thiết bị, bao gồm điện thoại thông minh và máy tính bảng. Bạn có thể truy cập hệ thống thông qua trình duyệt web trên thiết bị di động hoặc tải xuống ứng dụng PDU-PMS từ App Store hoặc Google Play Store. Giao diện được tối ưu hóa để hiển thị tốt trên màn hình nhỏ và hỗ trợ các tính năng như quét mã QR để điểm danh hoặc xác nhận sử dụng phòng học.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Tôi có thể đặt phòng trước bao lâu?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Giảng viên có thể đặt phòng trước tối đa 3 tháng. Sinh viên có thể đặt phòng tự học trước tối đa 2 tuần. Việc đặt phòng cho các sự kiện đặc biệt (hội thảo, hội nghị) có thể được thực hiện trước tối đa 6 tháng, nhưng cần có sự phê duyệt của quản trị viên. Lưu ý rằng các đơn đặt phòng gần nhất (trong vòng 48 giờ) sẽ được ưu tiên xử lý trước.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Làm thế nào để báo cáo sự cố kỹ thuật trong phòng học?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Để báo cáo sự cố kỹ thuật hoặc hư hỏng thiết bị trong phòng học, bạn có thể sử dụng chức năng "Báo cáo sự cố" trong hệ thống PDU-PMS. Truy cập vào phần "Báo cáo sự cố" từ thanh điều hướng, chọn phòng học gặp vấn đề, mô tả chi tiết sự cố và gửi báo cáo. Bạn cũng có thể đính kèm hình ảnh để giúp nhân viên kỹ thuật hiểu rõ hơn về vấn đề. Ngoài ra, bạn có thể liên hệ trực tiếp với Phòng Cơ sở vật chất theo số điện thoại 024-3784-8513 (nhánh 16) để được hỗ trợ ngay lập tức.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Làm thế nào để kiểm tra lịch sử đặt phòng của tôi?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Để xem lịch sử đặt phòng, đăng nhập vào hệ thống và truy cập vào trang "Lịch sử đặt phòng" trong mục "Quản lý tài khoản". Tại đây, bạn có thể xem danh sách tất cả các đặt phòng trước đây, bao gồm thông tin về phòng, thời gian, trạng thái (đã sử dụng, đã hủy, v.v.). Bạn cũng có thể lọc lịch sử theo khoảng thời gian, trạng thái hoặc loại phòng. Chức năng này giúp bạn theo dõi việc sử dụng phòng học của mình và có thể xuất dữ liệu ra file Excel nếu cần.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Hệ thống có tích hợp với lịch học của trường không?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, PDU-PMS được tích hợp đầy đủ với hệ thống quản lý học vụ của Trường Đại học Phương Đông. Lịch học chính thức từ phòng Đào tạo sẽ tự động được cập nhật vào hệ thống PDU-PMS. Điều này đảm bảo không có xung đột giữa lịch học chính thức và các đặt phòng khác. Giảng viên và sinh viên có thể xem lịch học của mình trên hệ thống và đồng bộ với các ứng dụng lịch cá nhân như Google Calendar hoặc Microsoft Outlook thông qua tính năng xuất lịch iCal.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Có quy định nào về việc sử dụng phòng học ngoài giờ không?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, việc sử dụng phòng học ngoài giờ cần tuân thủ một số quy định:
                                    <ul class="mb-0 mt-2">
                                        <li>Thời gian mở cửa của các tòa nhà: 6:00 - 22:00 các ngày trong tuần và 7:00 - 17:00 vào thứ Bảy, Chủ nhật.</li>
                                        <li>Việc sử dụng phòng học sau 18:00 và vào cuối tuần cần có sự phê duyệt từ Phòng Cơ sở vật chất.</li>
                                        <li>Người đặt phòng phải chịu trách nhiệm về tình trạng của phòng và thiết bị sau khi sử dụng.</li>
                                        <li>Các hoạt động sử dụng phòng ngoài giờ phải đúng mục đích học tập, nghiên cứu hoặc hoạt động ngoại khóa đã được phê duyệt.</li>
                                        <li>Nếu cần hỗ trợ kỹ thuật ngoài giờ, cần đăng ký trước ít nhất 24 giờ.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Làm thế nào để đặt thiết bị cho một sự kiện đặc biệt?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Để đặt thiết bị đặc biệt cho sự kiện (như micro không dây, máy chiếu HD, thiết bị hội nghị trực tuyến), hãy thực hiện các bước sau:
                                    <ol class="mb-0 mt-2">
                                        <li>Đăng nhập vào hệ thống PDU-PMS và tạo đơn đặt phòng cho sự kiện của bạn.</li>
                                        <li>Trong phần "Yêu cầu thiết bị", chọn các thiết bị bạn cần cho sự kiện.</li>
                                        <li>Nếu cần thiết bị không có trong danh sách, hãy chọn "Thiết bị khác" và mô tả chi tiết.</li>
                                        <li>Gửi yêu cầu ít nhất 3 ngày trước ngày diễn ra sự kiện.</li>
                                        <li>Phòng Cơ sở vật chất sẽ xem xét yêu cầu và phản hồi trong vòng 24 giờ.</li>
                                    </ol>
                                    <p class="mt-2 mb-0">Để được hỗ trợ thêm, vui lòng liên hệ trực tiếp với Phòng Cơ sở vật chất qua email: csvc@phuongdong.edu.vn hoặc điện thoại: 024-3784-8513 (nhánh 16).</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingNine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Làm cách nào để xin cấp quyền truy cập đặc biệt vào hệ thống?
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Để được cấp quyền truy cập đặc biệt (như quản lý sự kiện lớn, quản lý nhiều phòng cùng lúc, hoặc quyền phê duyệt đặt phòng), bạn cần gửi yêu cầu chính thức đến quản trị viên hệ thống. Quy trình bao gồm:
                                    <ul class="mb-0 mt-2">
                                        <li>Gửi email chính thức từ địa chỉ email trường (@phuongdong.edu.vn) đến phòng Đào tạo (daotao@phuongdong.edu.vn).</li>
                                        <li>Nêu rõ lý do cần quyền truy cập đặc biệt và thời gian cần thiết.</li>
                                        <li>Đính kèm xác nhận từ trưởng đơn vị hoặc người quản lý (nếu có).</li>
                                        <li>Quyền truy cập đặc biệt thường được cấp có thời hạn và sẽ được đánh giá lại sau khi hết hạn.</li>
                                    </ul>
                                    <p class="small text-muted mt-2 mb-0">Lưu ý: Mọi hoạt động với quyền truy cập đặc biệt sẽ được ghi lại và theo dõi để đảm bảo an toàn hệ thống.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Hệ thống có hỗ trợ đặt phòng định kỳ không?
                                </button>
                            </h2>
                            <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Có, PDU-PMS hỗ trợ đặt phòng định kỳ cho các hoạt động diễn ra thường xuyên như câu lạc bộ, nhóm học tập, hoặc các buổi họp định kỳ. Để sử dụng tính năng này:
                                    <ol class="mb-0 mt-2">
                                        <li>Khi đặt phòng, chọn tùy chọn "Đặt phòng định kỳ".</li>
                                        <li>Chọn tần suất lặp lại (hàng ngày, hàng tuần, hàng tháng).</li>
                                        <li>Chọn ngày kết thúc của chuỗi đặt phòng (tối đa 3 tháng cho giảng viên và 1 tháng cho sinh viên).</li>
                                        <li>Hệ thống sẽ tự động tạo các đặt phòng cho toàn bộ chuỗi và kiểm tra xung đột.</li>
                                        <li>Bạn có thể chỉnh sửa hoặc hủy một hoặc tất cả các đặt phòng trong chuỗi nếu cần.</li>
                                    </ol>
                                    <p class="small text-muted mt-2 mb-0">Lưu ý: Đặt phòng định kỳ có thể bị ghi đè bởi các sự kiện học tập chính thức của trường. Trong trường hợp đó, bạn sẽ nhận được thông báo và đề xuất phòng thay thế.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="guide-section mb-4">
                        <h3 class="h5 mb-3">Cần thêm trợ giúp?</h3>
                        <p class="mb-3">
                            Nếu bạn không tìm thấy câu trả lời cho câu hỏi của mình, hãy liên hệ với chúng tôi qua các kênh sau:
                        </p>
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <div class="col">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="h6 mb-2">Email Hỗ trợ</h4>
                                        <p class="small mb-0">
                                            support@pdu-pms.edu.vn<br>
                                            Thời gian phản hồi: 24 giờ
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-phone-alt text-primary"></i>
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="h6 mb-2">Hỗ trợ Điện thoại</h4>
                                        <p class="small mb-0">
                                            024-3784-8513 (14/15/16)<br>
                                            Thứ Hai - Thứ Sáu: 8:00 - 17:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="feature-card h-100">
                                    <div class="card-header text-center">
                                        <i class="fas fa-comment-dots text-primary"></i>
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="h6 mb-2">Trò chuyện Trực tuyến</h4>
                                        <p class="small mb-0">
                                            Có sẵn trong hệ thống<br>
                                            Thứ Hai - Thứ Bảy: 8:00 - 20:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button class="btn btn-primary" onclick="document.getElementById('student-tab').click()">
                            <i class="fas fa-arrow-left me-1"></i>
                            Hướng dẫn cho Sinh viên
                        </button>
                        <button class="btn btn-primary" onclick="document.getElementById('general-tab').click()">
                            Quay lại Tổng quan
                            <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Note -->
    <div class="text-center text-muted small">
        <p>© 2025 PDU - PMS | Phát triển bởi Trường Đại Học Phương Đông</p>
        <p class="mt-1">Phiên bản hướng dẫn: 1.0 | Cập nhật lần cuối: 22/03/2025</p>
    </div>
</div>

<script>
// Add hover effects to feature cards
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#guideTabs button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?> 