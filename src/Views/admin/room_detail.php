<?php include __DIR__ . '/../layouts/admin_layout.php'; ?>
<?php require_once __DIR__ . '/../../Helpers/BreadcrumbHelper.php'; ?>

<div class="container-fluid mt-4 px-4">
    <!-- Page Title and Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-door-open mr-2"></i> Chi tiết phòng</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="/pdu_pms_project/public/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/pdu_pms_project/public/admin/manage_rooms">Danh sách phòng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chi tiết phòng</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="/pdu_pms_project/public/admin/edit_room/<?= $data['room']['id'] ?>" class="btn btn-warning shadow-sm mr-2">
                <i class="fas fa-edit fa-sm text-white-50 mr-1"></i> Chỉnh sửa
            </a>
            <a href="/pdu_pms_project/public/admin/manage_rooms" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Room Information -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Thông tin phòng #<?php echo $data['room']['id']; ?></h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-door-open fa-6x text-primary mb-3"></i>
                        <h4><?php echo htmlspecialchars($data['room']['name']); ?></h4>
                    </div>
                    
                    <div class="mb-4">
                        <div class="row align-items-center py-2 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-hashtag mr-1"></i> ID Phòng:
                            </div>
                            <div class="col-7 font-weight-bold">
                                <?php echo $data['room']['id']; ?>
                            </div>
                        </div>
                        
                        <div class="row align-items-center py-3 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-layer-group mr-1"></i> Loại phòng:
                            </div>
                            <div class="col-7">
                                <?php 
                                $roomTypeName = "Không xác định";
                                $roomTypeId = $data['room']['room_type_id'] ?? null;
                                
                                if ($roomTypeId && isset($data['roomType'])) {
                                    $roomTypeName = htmlspecialchars($data['roomType']['name']);
                                }
                                ?>
                                <span class="badge badge-info">
                                    <?php echo $roomTypeName; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="row align-items-center py-3 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-users mr-1"></i> Sức chứa:
                            </div>
                            <div class="col-7 font-weight-bold">
                                <?php echo $data['room']['capacity']; ?> người
                            </div>
                        </div>
                        
                        <div class="row align-items-center py-3 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Trạng thái:
                            </div>
                            <div class="col-7">
                                <span class="badge badge-<?php 
                                    echo $data['room']['status'] === 'trống' ? 'success' : 
                                         ($data['room']['status'] === 'đã đặt' ? 'warning' : 'danger'); ?>">
                                    <?php echo ucfirst($data['room']['status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="/pdu_pms_project/public/admin/edit_room/<?= $data['room']['id'] ?>" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i> Chỉnh sửa phòng
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRoomModal">
                            <i class="fas fa-trash mr-1"></i> Xóa phòng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Room Usage Statistics -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info">
                    <h6 class="m-0 font-weight-bold text-white">Thống kê sử dụng</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tổng lượt đặt
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $data['bookingStats']['total'] ?? 0; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Tỷ lệ sử dụng
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $data['bookingStats']['usage_rate'] ?? '0%'; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Usage Chart -->
                    <div class="chart-area mt-4">
                        <canvas id="roomUsageChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Bookings -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-gradient-primary text-white">
            <h6 class="m-0 font-weight-bold">Lịch đặt sắp tới</h6>
        </div>
        <div class="card-body">
            <?php if (isset($data['upcomingBookings']) && !empty($data['upcomingBookings'])): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                                <th>Mã lớp</th>
                                <th>Người đặt</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['upcomingBookings'] as $booking): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y H:i', strtotime($booking['start_time'])); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($booking['end_time'])); ?></td>
                                    <td><?php echo htmlspecialchars($booking['class_code']); ?></td>
                                    <td>
                                        <?php
                                        if (!empty($booking['teacher_name'])) {
                                            echo '<i class="fas fa-chalkboard-teacher mr-1"></i> ' . htmlspecialchars($booking['teacher_name']);
                                        } elseif (!empty($booking['student_name'])) {
                                            echo '<i class="fas fa-user-graduate mr-1"></i> ' . htmlspecialchars($booking['student_name']);
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php
                                            echo $booking['status'] === 'được duyệt' ? 'success' :
                                                ($booking['status'] === 'chờ duyệt' ? 'warning' : 'danger');
                                        ?>">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/pdu_pms_project/public/admin/edit_booking/<?php echo $booking['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Không có lịch đặt nào sắp tới cho phòng này.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Room Modal -->
<div class="modal fade" id="deleteRoomModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteRoomModalLabel">Xác nhận xóa phòng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa phòng <strong><?php echo htmlspecialchars($data['room']['name']); ?></strong>?
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Lưu ý: Hành động này không thể hoàn tác!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Hủy
                </button>
                <a href="/pdu_pms_project/public/admin/delete_room/<?php echo $data['room']['id']; ?>" class="btn btn-danger">
                    <i class="fas fa-trash-alt mr-1"></i> Xóa
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Room usage chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('roomUsageChart');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
            datasets: [{
                label: 'Số giờ sử dụng trong tuần',
                data: <?php echo json_encode($data['usageData'] ?? [2, 4, 1, 5, 3, 0, 0]); ?>,
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(78, 115, 223, 0.8)'
                ],
                borderColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(78, 115, 223, 1)',
                    'rgba(78, 115, 223, 1)',
                    'rgba(78, 115, 223, 1)',
                    'rgba(78, 115, 223, 1)',
                    'rgba(78, 115, 223, 1)',
                    'rgba(78, 115, 223, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script> 