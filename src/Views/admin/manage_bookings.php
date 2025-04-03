<?php
// Đảm bảo chỉ cho admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Include header layout
include(dirname(__DIR__) . '/layouts/header.php');
?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Quản lý đặt phòng</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <form action="/pdu_pms_project/public/admin/manage_bookings" method="get" class="row g-3">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $filters['start_date'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $filters['end_date'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả</option>
                        <option value="pending" <?= isset($filters['status']) && $filters['status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                        <option value="approved" <?= isset($filters['status']) && $filters['status'] === 'approved' ? 'selected' : '' ?>>Đã duyệt</option>
                        <option value="rejected" <?= isset($filters['status']) && $filters['status'] === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i> Lọc
                    </button>
                    <a href="/pdu_pms_project/public/admin/manage_bookings" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i> Đặt lại
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="bookingsTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Người đặt</th>
                        <th>Phòng</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= $booking['id'] ?></td>
                        <td><?= htmlspecialchars($booking['user_name']) ?></td>
                        <td><?= htmlspecialchars($booking['room_name']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($booking['start_time'])) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($booking['end_time'])) ?></td>
                        <td>
                            <?php if ($booking['status'] == 'pending'): ?>
                                <span class="badge bg-warning">Chờ duyệt</span>
                            <?php elseif ($booking['status'] == 'approved'): ?>
                                <span class="badge bg-success">Đã duyệt</span>
                            <?php elseif ($booking['status'] == 'rejected'): ?>
                                <span class="badge bg-danger">Từ chối</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="/pdu_pms_project/public/admin/view_booking/<?= $booking['id'] ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($booking['status'] == 'pending'): ?>
                                <a href="/pdu_pms_project/public/admin/approve_booking/<?= $booking['id'] ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="/pdu_pms_project/public/admin/reject_booking/<?= $booking['id'] ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                                <?php endif; ?>
                                <a href="/pdu_pms_project/public/admin/delete_booking/<?= $booking['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa đặt phòng này?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(dirname(__DIR__) . '/layouts/footer.php'); ?>