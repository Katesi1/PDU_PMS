<?php
// Đảm bảo chỉ cho admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

include __DIR__ . '/../layouts/admin_layout.php'; ?>

<style>
/* Cải thiện dropdown no-arrow */
.dropdown.no-arrow .dropdown-toggle::after {
    display: none;
}

.dropdown.no-arrow .dropdown-toggle {
    background: transparent;
    border: none;
    color: #6c757d;
    padding: 0.25rem 0.5rem;
    border-radius: 50%;
    transition: all 0.2s;
}

.dropdown.no-arrow .dropdown-toggle:hover {
    color: #000;
    background-color: rgba(0, 0, 0, 0.05);
}

/* Nâng cấp avatar người dùng */
.avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

/* Card và các phần tử khác */
.card {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    margin-bottom: 1.5rem;
}

.card .card-header {
    background-color: white;
    border-bottom: 1px solid #e3e6f0;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card .card-body {
    padding: 1.25rem;
}
</style>

<!-- Content inside container-fluid -->
<!-- Page Title -->
<div class="page-title d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold">Bảng điều khiển</h1>
        <p class="text-muted mb-0">Tổng quan về hệ thống Quản lý Phòng Đào tạo</p>
    </div>
    <div>
        <a href="/pdu_pms_project/public/admin/reports" class="btn btn-primary">
            <i class="fas fa-download me-1"></i> Xuất báo cáo
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Tổng số phòng</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= $data['total_rooms'] ?? 42 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-door-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Lượt đặt phòng hôm nay</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= $data['today_bookings'] ?? 128 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Tổng số người dùng</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= $data['total_users'] ?? 256 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">Yêu cầu chờ duyệt</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?= $data['pending_bookings'] ?? 15 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Recent Activities -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">Hoạt động gần đây</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Tất cả hoạt động</a></li>
                        <li><a class="dropdown-item" href="#">Chỉ đặt phòng</a></li>
                        <li><a class="dropdown-item" href="#">Chỉ người dùng</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Xuất dữ liệu</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>THỜI GIAN</th>
                                <th>NGƯỜI DÙNG</th>
                                <th>HOẠT ĐỘNG</th>
                                <th>TRẠNG THÁI</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>01/04/2025 09:45</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2" style="background-color: #4CAF50;">N</div>
                                        Nguyễn Văn A
                                    </div>
                                </td>
                                <td>Đặt phòng B401</td>
                                <td><span class="badge bg-success">Thành công</span></td>
                                <td><button class="btn btn-sm btn-link"><i class="fas fa-eye"></i></button></td>
                            </tr>
                            <tr>
                                <td>01/04/2025 09:30</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2" style="background-color: #2196F3;">L</div>
                                        Lê Thị B
                                    </div>
                                </td>
                                <td>Hủy đặt phòng A302</td>
                                <td><span class="badge bg-warning text-dark">Đã hủy</span></td>
                                <td><button class="btn btn-sm btn-link"><i class="fas fa-eye"></i></button></td>
                            </tr>
                            <tr>
                                <td>01/04/2025 09:15</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2" style="background-color: #9C27B0;">T</div>
                                        Trần Văn C
                                    </div>
                                </td>
                                <td>Yêu cầu đặt phòng C201</td>
                                <td><span class="badge bg-primary">Chờ duyệt</span></td>
                                <td><button class="btn btn-sm btn-link"><i class="fas fa-eye"></i></button></td>
                            </tr>
                            <tr>
                                <td>01/04/2025 09:00</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2" style="background-color: #F44336;">P</div>
                                        Phạm Thị D
                                    </div>
                                </td>
                                <td>Báo cáo hỏng thiết bị phòng D105</td>
                                <td><span class="badge bg-danger">Sự cố</span></td>
                                <td><button class="btn btn-sm btn-link"><i class="fas fa-eye"></i></button></td>
                            </tr>
                            <tr>
                                <td>01/04/2025 08:45</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2" style="background-color: #FF9800;">V</div>
                                        Vũ Văn E
                                    </div>
                                </td>
                                <td>Đăng ký lịch dạy phòng E402</td>
                                <td><span class="badge bg-success">Thành công</span></td>
                                <td><button class="btn btn-sm btn-link"><i class="fas fa-eye"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="/pdu_pms_project/public/admin/manage_bookings" class="btn btn-primary btn-sm">
                        Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Room Usage Chart -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="m-0 fw-bold text-primary">Sử dụng phòng</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="roomUsageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="roomUsageDropdown">
                        <li><a class="dropdown-item" href="#">Tuần này</a></li>
                        <li><a class="dropdown-item" href="#">Tháng này</a></li>
                        <li><a class="dropdown-item" href="#">Năm nay</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Xuất dữ liệu</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie mb-3">
                    <canvas id="roomUsageChart" height="300"></canvas>
                </div>
                <div class="mt-3">
                    <div class="mb-1">
                        <i class="fas fa-circle text-primary me-1"></i> Phòng học <span class="float-end">75%</span>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-circle text-success me-1"></i> Phòng thực hành <span class="float-end">60%</span>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-circle text-info me-1"></i> Phòng hội thảo <span class="float-end">45%</span>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-circle text-warning me-1"></i> Phòng thí nghiệm <span class="float-end">80%</span>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <i class="fas fa-circle text-danger me-1"></i> Phòng họp <span class="float-end">30%</span>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <!-- Close admin-content div from admin_sidebar.php -->

<!-- Add Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
// Room Usage Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('roomUsageChart').getContext('2d');
    const roomUsageChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Phòng học', 'Phòng thực hành', 'Phòng hội thảo', 'Phòng thí nghiệm', 'Phòng họp'],
            datasets: [{
                data: [75, 60, 45, 80, 30],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(220, 53, 69, 0.8)'
                ],
                borderColor: 'transparent',
                hoverOffset: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
});
</script>

<?php // Removed footer include as it's handled in admin_layout ?>