<?php
// Sử dụng đường dẫn tuyệt đối để tránh lỗi
$title = 'Giới thiệu hệ thống';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
?>

<style>
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
.about-section {
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #0d6efd;
}

.section-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e7f1ff;
    border-radius: 50%;
    color: #0d6efd;
    font-size: 1.5rem;
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

/* Team member styling */
.team-member {
    text-align: center;
    transition: transform 0.3s ease;
}

.team-member:hover {
    transform: translateY(-10px);
}

.team-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin: 0 auto 1rem auto;
    overflow: hidden;
    border: 4px solid #e7f1ff;
}

.team-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.team-member .team-role {
    color: #6c757d;
    font-size: 0.875rem;
}

.team-social {
    margin-top: 1rem;
}

.team-social a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background-color: #f8f9fa;
    border-radius: 50%;
    color: #6c757d;
    margin: 0 0.25rem;
    transition: all 0.3s ease;
}

.team-social a:hover {
    background-color: #0d6efd;
    color: white;
}
</style>

<div class="container-fluid px-4 py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/pdu_pms_project/public" class="text-primary">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Giới thiệu hệ thống</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-primary bg-gradient rounded shadow-sm mb-4 p-4 text-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">Giới thiệu về hệ thống PDU-PMS</h1>
                <p class="opacity-75">Hệ thống quản lý phòng học thông minh dành cho Trường Đại Học Phương Đông tại Trung Kính</p>
            </div>
            <div class="d-none d-md-block">
                <i class="fas fa-info-circle display-4 text-white opacity-25"></i>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-md-8">
            <!-- About The System -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="section-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h2 class="h4 mb-0">Về Hệ Thống PDU-PMS</h2>
                    </div>

                    <div class="about-section mb-4">
                        <h3 class="h5 mb-3">Tổng quan</h3>
                        <p>
                            PDU-PMS (Phuong Dong University - Phòng Management System) là một hệ thống quản lý phòng học thông minh được phát triển nhằm tối ưu hóa việc sử dụng tài nguyên phòng học và cải thiện trải nghiệm của giảng viên và sinh viên tại Trường Đại Học Phương Đông.
                        </p>
                        <p>
                            Hệ thống được thiết kế với giao diện người dùng thân thiện, tích hợp các tính năng hiện đại giúp quản lý hiệu quả các phòng học, trang thiết bị, và lịch sử sử dụng.
                        </p>
                    </div>

                    <div class="about-section mb-4">
                        <h3 class="h5 mb-3">Mục tiêu phát triển</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-primary">
                                                <i class="fas fa-chart-line fs-3"></i>
                                            </div>
                                            <h4 class="h6 mb-0">Tối ưu hóa tài nguyên</h4>
                                        </div>
                                        <p class="card-text small">
                                            Nâng cao hiệu quả sử dụng phòng học và trang thiết bị, 
                                            giảm thiểu tình trạng trùng lịch và giảm chi phí vận hành.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-primary">
                                                <i class="fas fa-tasks fs-3"></i>
                                            </div>
                                            <h4 class="h6 mb-0">Tự động hóa quy trình</h4>
                                        </div>
                                        <p class="card-text small">
                                            Tự động hóa quy trình đặt phòng, xét duyệt, và thông báo 
                                            giúp tiết kiệm thời gian và giảm thiểu sai sót.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-primary">
                                                <i class="fas fa-user-graduate fs-3"></i>
                                            </div>
                                            <h4 class="h6 mb-0">Nâng cao trải nghiệm</h4>
                                        </div>
                                        <p class="card-text small">
                                            Cải thiện trải nghiệm học tập và giảng dạy thông qua việc 
                                            cung cấp thông tin chính xác, kịp thời về phòng học.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3 text-primary">
                                                <i class="fas fa-chart-pie fs-3"></i>
                                            </div>
                                            <h4 class="h6 mb-0">Dữ liệu phân tích</h4>
                                        </div>
                                        <p class="card-text small">
                                            Thu thập và phân tích dữ liệu về việc sử dụng phòng học 
                                            giúp đưa ra quyết định dựa trên dữ liệu thực tế.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-md-4">
            <!-- Quick Facts -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="h5 mb-3">Thống kê nhanh</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Số phòng học</span>
                            <span class="badge bg-primary rounded-pill">50+</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Số thiết bị quản lý</span>
                            <span class="badge bg-primary rounded-pill">200+</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Đặt phòng hàng tháng</span>
                            <span class="badge bg-primary rounded-pill">500+</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Người dùng hoạt động</span>
                            <span class="badge bg-primary rounded-pill">1,000+</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- System Requirements -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="h5 mb-3">Yêu cầu hệ thống</h3>
                    <div class="mb-3">
                        <div class="fw-bold small mb-1">Trình duyệt hỗ trợ:</div>
                        <div class="d-flex flex-wrap">
                            <span class="badge bg-secondary m-1"><i class="fab fa-chrome me-1"></i> Chrome</span>
                            <span class="badge bg-secondary m-1"><i class="fab fa-firefox me-1"></i> Firefox</span>
                            <span class="badge bg-secondary m-1"><i class="fab fa-edge me-1"></i> Edge</span>
                            <span class="badge bg-secondary m-1"><i class="fab fa-safari me-1"></i> Safari</span>
                        </div>
                    </div>
                    <div>
                        <div class="fw-bold small mb-1">Thiết bị:</div>
                        <div class="d-flex flex-wrap">
                            <span class="badge bg-secondary m-1"><i class="fas fa-desktop me-1"></i> Desktop</span>
                            <span class="badge bg-secondary m-1"><i class="fas fa-laptop me-1"></i> Laptop</span>
                            <span class="badge bg-secondary m-1"><i class="fas fa-tablet-alt me-1"></i> Tablet</span>
                            <span class="badge bg-secondary m-1"><i class="fas fa-mobile-alt me-1"></i> Mobile</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Team Members -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 mb-3">Đội ngũ phát triển</h3>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="team-member">
                                <div class="team-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Nguyen+Minh&background=0D8ABC&color=fff" alt="Nguyễn Minh">
                                </div>
                                <h4 class="h6 mb-1">Nguyễn Minh</h4>
                                <p class="team-role mb-2">Team Leader</p>
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-github"></i></a>
                                    <a href="#"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="team-member">
                                <div class="team-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Tran+Hang&background=47A248&color=fff" alt="Trần Hằng">
                                </div>
                                <h4 class="h6 mb-1">Trần Hằng</h4>
                                <p class="team-role mb-2">UX Designer</p>
                                <div class="team-social">
                                    <a href="#"><i class="fab fa-github"></i></a>
                                    <a href="#"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?> 