<?php
// Đảm bảo người dùng đã đăng nhập với vai trò admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

include __DIR__ . '/../layouts/admin_layout.php';
require_once __DIR__ . '/../../Helpers/BreadcrumbHelper.php'; ?>

<div class="container-fluid mt-4">
    <!-- Page Title -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-magic me-2"></i>Xếp lịch tự động</h1>
            <p class="text-muted">Tự động xếp phòng học cho các lớp dựa trên các tiêu chí phù hợp</p>
        </div>
        <div>
            <a href="/pdu_pms_project/public/admin/manage_timetable" class="btn btn-primary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> Quay lại
            </a>
            <button id="autoScheduleAllBtn" class="btn btn-success shadow-sm ms-2">
                <i class="fas fa-bolt fa-sm text-white-50 me-1"></i> Xếp tự động toàn bộ
            </button>
        </div>
    </div>

    <!-- Thông báo -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($_GET['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Content Row - Stats -->
    <div class="row mb-4">
        <!-- Total Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số lớp học</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($data['timetables'] ?? []) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unscheduled Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chưa xếp phòng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($data['timetables'] ?? [], function($timetable) { 
                                    return empty($timetable['room_id']); 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scheduled Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Đã xếp phòng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($data['timetables'] ?? [], function($timetable) { 
                                    return !empty($timetable['room_id']); 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Rooms Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Phòng khả dụng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['available_rooms'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-door-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-gradient-light">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle me-2"></i>Hướng dẫn sử dụng</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <p>Chức năng xếp lịch tự động giúp bạn tự động tìm và phân bổ phòng học dựa trên các tiêu chí như:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-clock text-primary me-2"></i>Thời gian</h6>
                                    <p class="card-text">Đảm bảo phòng không bị trùng lịch trong cùng một khung giờ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-layer-group text-success me-2"></i>Loại phòng</h6>
                                    <p class="card-text">Chọn phòng có trang thiết bị phù hợp với môn học</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-users text-warning me-2"></i>Sức chứa</h6>
                                    <p class="card-text">Đảm bảo phòng đủ chỗ ngồi cho tất cả sinh viên trong lớp</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-sort-amount-up-alt text-info me-2"></i>Ưu tiên</h6>
                                    <p class="card-text">Các lớp quan trọng được ưu tiên xếp phòng trước</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-left-warning bg-light h-100">
                        <div class="card-body">
                            <h5 class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Lưu ý quan trọng</h5>
                            <ul class="mb-0">
                                <li>Có thể xếp phòng cho từng lớp riêng lẻ hoặc tất cả lớp cùng lúc</li>
                                <li>Hệ thống sẽ tự phát hiện và tránh các xung đột về thời gian</li>
                                <li>Nếu không tìm thấy phòng phù hợp, hãy kiểm tra lại các tiêu chí</li>
                                <li>Sau khi xếp tự động, vẫn có thể điều chỉnh thủ công nếu cần</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-list me-2"></i>Danh sách thời khóa biểu cần xếp phòng</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-export me-1"></i> Xuất danh sách</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-print me-1"></i> In danh sách</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-1"></i> Làm mới</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="autoScheduleTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Giảng viên</th>
                            <th>Mã lớp</th>
                            <th>Môn học</th>
                            <th>Thời gian bắt đầu</th>
                            <th>Thời gian kết thúc</th>
                            <th>Phòng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['timetables']) && is_array($data['timetables']) && count($data['timetables']) > 0): ?>
                            <?php foreach ($data['timetables'] as $timetable): ?>
                                <tr class="<?= empty($timetable['room_id']) ? 'table-warning' : '' ?>">
                                    <td><?php echo $timetable['id'] ?? ''; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle me-2">
                                                <?php 
                                                $teacherName = $timetable['teacher_name'] ?? 'N/A';
                                                $initials = '';
                                                $parts = explode(' ', $teacherName);
                                                if (count($parts) >= 2) {
                                                    $initials = substr($parts[0], 0, 1) . substr($parts[count($parts)-1], 0, 1);
                                                } else {
                                                    $initials = substr($teacherName, 0, 2);
                                                }
                                                echo strtoupper($initials);
                                                ?>
                                            </div>
                                            <?php echo htmlspecialchars($timetable['teacher_name'] ?? 'N/A'); ?>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($timetable['class_code'] ?? ''); ?></span></td>
                                    <td><strong><?php echo htmlspecialchars($timetable['subject'] ?? ''); ?></strong></td>
                                    <td><i class="far fa-calendar-alt me-1 text-muted"></i> <?php echo isset($timetable['start_time']) ? date('d/m/Y H:i', strtotime($timetable['start_time'])) : ''; ?></td>
                                    <td><i class="far fa-clock me-1 text-muted"></i> <?php echo isset($timetable['end_time']) ? date('d/m/Y H:i', strtotime($timetable['end_time'])) : ''; ?></td>
                                    <td>
                                        <?php if (isset($timetable['room_id']) && $timetable['room_id']): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-door-open me-1"></i>
                                                <?php
                                                $room = (new \Models\RoomModel())->getRoomById($timetable['room_id']);
                                                echo htmlspecialchars($room['name'] ?? 'Không xác định');
                                                ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                Chưa xếp phòng
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="/pdu_pms_project/public/admin/auto_schedule" class="d-inline">
                                            <input type="hidden" name="timetable_id" value="<?php echo $timetable['id'] ?? ''; ?>">
                                            <button type="submit" class="btn btn-sm btn-primary" <?= !empty($timetable['room_id']) ? 'disabled' : '' ?>>
                                                <i class="fas fa-magic me-1"></i> Xếp phòng
                                            </button>
                                        </form>
                                        
                                        <?php if (!empty($timetable['room_id'])): ?>
                                        <a href="/pdu_pms_project/public/admin/edit_timetable/<?php echo $timetable['id'] ?? ''; ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i> Chỉnh sửa
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu thời khóa biểu nào cần xếp phòng</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Card styles */
    .card.border-left-primary {
        border-left: .25rem solid #4e73df!important;
    }
    
    .card.border-left-success {
        border-left: .25rem solid #1cc88a!important;
    }
    
    .card.border-left-warning {
        border-left: .25rem solid #f6c23e!important;
    }
    
    .card.border-left-info {
        border-left: .25rem solid #36b9cc!important;
    }
    
    /* Avatar */
    .avatar-sm {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }
</style>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#autoScheduleTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
            },
            order: [[0, 'desc']]
        });
        
        // Bulk auto schedule button
        $('#autoScheduleAllBtn').click(function() {
            if (confirm('Bạn có chắc chắn muốn xếp tự động cho tất cả lớp học chưa có phòng? Quá trình này có thể mất vài phút.')) {
                window.location.href = '/pdu_pms_project/public/admin/auto_schedule_all';
            }
        });
    });
</script>