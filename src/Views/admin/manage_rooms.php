<?php
// Đảm bảo người dùng đã đăng nhập với vai trò admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Include header layout
include(dirname(__DIR__) . '/layouts/header.php');
?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-door-open me-2"></i> Quản lý phòng</h5>
    </div>
    <div class="card-body">
        <div class="mb-3 text-end">
            <a href="/pdu_pms_project/public/admin/add_room" class="btn btn-success">
                <i class="fas fa-plus me-1"></i> Thêm phòng
            </a>
            <a href="/pdu_pms_project/public/admin/manage_room_types" class="btn btn-info">
                <i class="fas fa-layer-group me-1"></i> Quản lý loại phòng
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="roomsTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên phòng</th>
                        <th>Loại phòng</th>
                        <th>Sức chứa</th>
                        <th>Vị trí</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['rooms'] as $room): ?>
                    <tr>
                        <td><?= $room['id'] ?></td>
                        <td><?= htmlspecialchars($room['name']) ?></td>
                        <td><?= htmlspecialchars($room['room_type_name']) ?></td>
                        <td><?= $room['capacity'] ?> người</td>
                        <td><?= htmlspecialchars($room['location']) ?></td>
                        <td>
                            <span class="badge bg-<?= $room['status'] == 'trống' ? 'success' : ($room['status'] == 'đang sử dụng' ? 'warning' : 'danger') ?>">
                                <?= htmlspecialchars($room['status']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="/pdu_pms_project/public/admin/edit_room/<?= $room['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/pdu_pms_project/public/admin/room_detail/<?= $room['id'] ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="confirmDelete(<?= $room['id'] ?>, '<?= htmlspecialchars($room['name']) ?>')" class="btn btn-sm btn-danger">
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

<!-- Script xác nhận xóa -->
<script>
function confirmDelete(id, name) {
    if (confirm('Bạn có chắc chắn muốn xóa phòng "' + name + '"?')) {
        window.location.href = '/pdu_pms_project/public/admin/delete_room/' + id;
    }
}
</script>

<?php include(dirname(__DIR__) . '/layouts/footer.php'); ?>