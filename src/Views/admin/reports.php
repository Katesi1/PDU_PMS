<?php
// Đảm bảo người dùng đã đăng nhập với vai trò admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Lấy các tham số báo cáo
$reportType = $data['reportType'] ?? 'bookings';
$timeRange = $data['timeRange'] ?? 'month';
$reportData = $data['reportData'] ?? [];

// Include header layout
include(dirname(__DIR__) . '/layouts/header.php');
?>

<!-- Nội dung trang báo cáo -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Báo Cáo & Thống Kê</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-8">
                <form id="reportForm" method="get" action="/pdu_pms_project/public/admin/reports" class="d-flex flex-wrap gap-2">
                    <select name="type" class="form-select me-2" style="width: auto;">
                        <option value="bookings" <?= $reportType == 'bookings' ? 'selected' : '' ?>>Báo cáo đặt phòng</option>
                        <option value="rooms" <?= $reportType == 'rooms' ? 'selected' : '' ?>>Báo cáo sử dụng phòng</option>
                        <option value="users" <?= $reportType == 'users' ? 'selected' : '' ?>>Báo cáo hoạt động người dùng</option>
                        <option value="maintenance" <?= $reportType == 'maintenance' ? 'selected' : '' ?>>Báo cáo bảo trì</option>
                    </select>
                    <select name="timeRange" class="form-select me-2" style="width: auto;">
                        <option value="week" <?= $timeRange == 'week' ? 'selected' : '' ?>>Tuần này</option>
                        <option value="month" <?= $timeRange == 'month' ? 'selected' : '' ?>>Tháng này</option>
                        <option value="quarter" <?= $timeRange == 'quarter' ? 'selected' : '' ?>>Quý này</option>
                        <option value="year" <?= $timeRange == 'year' ? 'selected' : '' ?>>Năm nay</option>
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Lọc
                    </button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <a href="/pdu_pms_project/public/admin/export_report?type=<?= $reportType ?>&format=pdf" class="btn btn-success me-2">
                    <i class="fas fa-file-pdf me-1"></i> Xuất PDF
                </a>
                <a href="/pdu_pms_project/public/admin/export_report?type=<?= $reportType ?>&format=excel" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Xuất Excel
                </a>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="chart-container" style="height: 400px; margin-bottom: 30px;">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>
        </div>
        
        <?php if ($reportType == 'bookings'): ?>
            <h5>Chi tiết báo cáo đặt phòng</h5>
            <table class="table table-striped table-hover" id="bookingsTable">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Tổng số đặt phòng</th>
                        <th>Đã duyệt</th>
                        <th>Đang chờ</th>
                        <th>Đã từ chối</th>
                        <th>Tỷ lệ chấp nhận</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu mẫu cho bảng báo cáo đặt phòng -->
                    <tr>
                        <td>Thứ 2</td>
                        <td>12</td>
                        <td>10</td>
                        <td>1</td>
                        <td>1</td>
                        <td>83%</td>
                    </tr>
                    <tr>
                        <td>Thứ 3</td>
                        <td>19</td>
                        <td>15</td>
                        <td>2</td>
                        <td>2</td>
                        <td>79%</td>
                    </tr>
                    <tr>
                        <td>Thứ 4</td>
                        <td>3</td>
                        <td>3</td>
                        <td>0</td>
                        <td>0</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td>Thứ 5</td>
                        <td>5</td>
                        <td>4</td>
                        <td>1</td>
                        <td>0</td>
                        <td>80%</td>
                    </tr>
                    <tr>
                        <td>Thứ 6</td>
                        <td>2</td>
                        <td>2</td>
                        <td>0</td>
                        <td>0</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td>Thứ 7</td>
                        <td>3</td>
                        <td>2</td>
                        <td>1</td>
                        <td>0</td>
                        <td>67%</td>
                    </tr>
                    <tr>
                        <td>Chủ nhật</td>
                        <td>7</td>
                        <td>5</td>
                        <td>1</td>
                        <td>1</td>
                        <td>71%</td>
                    </tr>
                </tbody>
            </table>
        <?php elseif ($reportType == 'rooms'): ?>
            <h5>Chi tiết báo cáo sử dụng phòng</h5>
            <table class="table table-striped table-hover" id="roomsTable">
                <thead>
                    <tr>
                        <th>Mã phòng</th>
                        <th>Tên phòng</th>
                        <th>Sức chứa</th>
                        <th>Số lần sử dụng</th>
                        <th>Tổng giờ sử dụng</th>
                        <th>Tỷ lệ sử dụng</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu mẫu cho bảng báo cáo sử dụng phòng -->
                    <tr>
                        <td>A101</td>
                        <td>Phòng học A101</td>
                        <td>50</td>
                        <td>34</td>
                        <td>68h</td>
                        <td>85%</td>
                    </tr>
                    <tr>
                        <td>B203</td>
                        <td>Phòng học B203</td>
                        <td>40</td>
                        <td>28</td>
                        <td>56h</td>
                        <td>72%</td>
                    </tr>
                    <tr>
                        <td>C305</td>
                        <td>Phòng học C305</td>
                        <td>30</td>
                        <td>24</td>
                        <td>48h</td>
                        <td>65%</td>
                    </tr>
                    <tr>
                        <td>D407</td>
                        <td>Phòng học D407</td>
                        <td>25</td>
                        <td>32</td>
                        <td>64h</td>
                        <td>90%</td>
                    </tr>
                    <tr>
                        <td>E509</td>
                        <td>Phòng học E509</td>
                        <td>60</td>
                        <td>20</td>
                        <td>40h</td>
                        <td>45%</td>
                    </tr>
                </tbody>
            </table>
        <?php elseif ($reportType == 'users'): ?>
            <h5>Chi tiết báo cáo hoạt động người dùng</h5>
            <table class="table table-striped table-hover" id="usersTable">
                <thead>
                    <tr>
                        <th>Loại người dùng</th>
                        <th>Số lượng</th>
                        <th>Đặt phòng</th>
                        <th>Đăng nhập</th>
                        <th>Thời gian trung bình (phút)</th>
                        <th>Hoạt động khác</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu mẫu cho bảng báo cáo hoạt động người dùng -->
                    <tr>
                        <td>Giảng viên</td>
                        <td>25</td>
                        <td>120</td>
                        <td>150</td>
                        <td>45</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>Sinh viên</td>
                        <td>150</td>
                        <td>50</td>
                        <td>300</td>
                        <td>30</td>
                        <td>80</td>
                    </tr>
                    <tr>
                        <td>Admin</td>
                        <td>5</td>
                        <td>30</td>
                        <td>100</td>
                        <td>60</td>
                        <td>200</td>
                    </tr>
                </tbody>
            </table>
        <?php elseif ($reportType == 'maintenance'): ?>
            <h5>Chi tiết báo cáo bảo trì</h5>
            <table class="table table-striped table-hover" id="maintenanceTable">
                <thead>
                    <tr>
                        <th>Trạng thái</th>
                        <th>Số lượng</th>
                        <th>Thời gian xử lý TB (giờ)</th>
                        <th>Độ ưu tiên cao</th>
                        <th>Độ ưu tiên trung bình</th>
                        <th>Độ ưu tiên thấp</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu mẫu cho bảng báo cáo bảo trì -->
                    <tr>
                        <td>Đang chờ</td>
                        <td>8</td>
                        <td>N/A</td>
                        <td>3</td>
                        <td>4</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Đang xử lý</td>
                        <td>12</td>
                        <td>24</td>
                        <td>6</td>
                        <td>5</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Đã xử lý</td>
                        <td>30</td>
                        <td>48</td>
                        <td>10</td>
                        <td>15</td>
                        <td>5</td>
                    </tr>
                    <tr>
                        <td>Từ chối</td>
                        <td>5</td>
                        <td>12</td>
                        <td>0</td>
                        <td>2</td>
                        <td>3</td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- DataTables và Chart.js -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    // Khởi tạo các bảng DataTable tùy thuộc vào loại báo cáo
    if (document.getElementById('bookingsTable')) {
        $('#bookingsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
            }
        });
    }
    
    if (document.getElementById('roomsTable')) {
        $('#roomsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
            }
        });
    }
    
    if (document.getElementById('usersTable')) {
        $('#usersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
            }
        });
    }
    
    if (document.getElementById('maintenanceTable')) {
        $('#maintenanceTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
            }
        });
    }
    
    // Dữ liệu mẫu cho biểu đồ
    const reportData = {
        labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
        datasets: [
            {
                label: 'Đã duyệt',
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                data: [10, 15, 3, 4, 2, 2, 5]
            },
            {
                label: 'Đang chờ',
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                data: [1, 2, 0, 1, 0, 1, 1]
            },
            {
                label: 'Đã từ chối',
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                data: [1, 2, 0, 0, 0, 0, 1]
            }
        ]
    };
    
    // Vẽ biểu đồ
    const reportType = "<?= $reportType ?>";
    const ctx = document.getElementById('reportChart').getContext('2d');
    let chartConfig = {
        type: 'bar',
        data: reportData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: getChartTitle(reportType)
                },
                legend: {
                    position: 'top',
                }
            }
        }
    };
    
    // Điều chỉnh loại biểu đồ tùy theo loại báo cáo
    if (reportType === 'rooms') {
        chartConfig.type = 'bar';
        chartConfig.options.indexAxis = 'y';
    } 
    else if (reportType === 'users') {
        chartConfig.type = 'pie';
    }
    else if (reportType === 'maintenance') {
        chartConfig.type = 'doughnut';
    }
    
    const myChart = new Chart(ctx, chartConfig);
    
    // Hàm trả về tiêu đề biểu đồ dựa trên loại báo cáo
    function getChartTitle(type) {
        switch(type) {
            case 'bookings':
                return 'Thống kê đặt phòng';
            case 'rooms':
                return 'Tỷ lệ sử dụng phòng';
            case 'users':
                return 'Hoạt động người dùng';
            case 'maintenance':
                return 'Thống kê yêu cầu bảo trì';
            default:
                return 'Thống kê';
        }
    }
});
</script>

<?php include(dirname(__DIR__) . '/layouts/footer.php'); ?>