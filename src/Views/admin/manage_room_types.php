<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/admin_navbar.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Quản lý loại phòng</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($_GET['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên loại phòng</th>
                                    <th>Mô tả</th>
                                    <th>Số phòng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roomTypes)): ?>
                                    <?php foreach ($roomTypes as $roomType): ?>
                                        <tr>
                                            <td><?= $roomType['id'] ?></td>
                                            <td><?= htmlspecialchars($roomType['name']) ?></td>
                                            <td><?= htmlspecialchars($roomType['description'] ?? 'Không có mô tả') ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= $roomType['room_count'] ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="/pdu_pms_project/public/admin/edit_room_type/<?= $roomType['id'] ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <?php if ($roomType['room_count'] == 0): ?>
                                                    <a href="#" onclick="confirmDelete(<?= $roomType['id'] ?>, '<?= htmlspecialchars($roomType['name']) ?>')" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-danger" disabled title="Không thể xóa loại phòng đang được sử dụng">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Không có loại phòng nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Thêm loại phòng mới</h5>
                </div>
                <div class="card-body">
                    <form action="/pdu_pms_project/public/admin/add_room_type" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên loại phòng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Thêm loại phòng
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin</h5>
                </div>
                <div class="card-body">
                    <p>
                        Loại phòng giúp phân loại các phòng thực hành theo mục đích sử dụng, trang thiết bị và đặc điểm riêng.
                    </p>
                    <p>
                        <strong>Lưu ý:</strong>
                    </p>
                    <ul>
                        <li>Không thể xóa loại phòng đang được sử dụng</li>
                        <li>Sửa tên loại phòng sẽ ảnh hưởng đến tất cả các phòng thuộc loại đó</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    if (confirm('Bạn có chắc chắn muốn xóa loại phòng "' + name + '" không?')) {
        window.location.href = '/pdu_pms_project/public/admin/delete_room_type/' + id;
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?> 