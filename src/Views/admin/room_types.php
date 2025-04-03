<?php
// Đảm bảo chỉ cho admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Lấy dữ liệu loại phòng
$roomTypes = $data['roomTypes'] ?? [];
$typeCount = $data['typeCount'] ?? [];

// Include header layout
include(dirname(__DIR__) . '/layouts/header.php');
?>

<!-- Nội dung trang quản lý loại phòng -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-tags me-2"></i> Quản Lý Loại Phòng</h5>
        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addRoomTypeModal">
            <i class="fas fa-plus me-1"></i> Thêm loại phòng
        </button>
    </div>
    <div class="card-body">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_GET['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_GET['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="roomTypesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên loại phòng</th>
                        <th>Mô tả</th>
                        <th>Số phòng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roomTypes as $type): ?>
                    <tr>
                        <td><?= $type['id'] ?></td>
                        <td><?= htmlspecialchars($type['name']) ?></td>
                        <td><?= htmlspecialchars($type['description'] ?? '') ?></td>
                        <td><span class="badge bg-info"><?= $typeCount[$type['id']] ?? 0 ?></span></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-btn" 
                                    data-id="<?= $type['id'] ?>" 
                                    data-name="<?= htmlspecialchars($type['name']) ?>" 
                                    data-description="<?= htmlspecialchars($type['description'] ?? '') ?>"
                                    data-bs-toggle="modal" data-bs-target="#editRoomTypeModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                    data-id="<?= $type['id'] ?>"
                                    data-name="<?= htmlspecialchars($type['name']) ?>"
                                    data-bs-toggle="modal" data-bs-target="#deleteRoomTypeModal">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal thêm loại phòng -->
<div class="modal fade" id="addRoomTypeModal" tabindex="-1" aria-labelledby="addRoomTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addRoomTypeModalLabel">Thêm loại phòng mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pdu_pms_project/public/admin/add_room_type" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addRoomTypeName" class="form-label">Tên loại phòng <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addRoomTypeName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="addRoomTypeDescription" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="addRoomTypeDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal sửa loại phòng -->
<div class="modal fade" id="editRoomTypeModal" tabindex="-1" aria-labelledby="editRoomTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editRoomTypeModalLabel">Sửa loại phòng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/pdu_pms_project/public/admin/edit_room_type" method="post">
                <div class="modal-body">
                    <input type="hidden" id="editRoomTypeId" name="id">
                    <div class="mb-3">
                        <label for="editRoomTypeName" class="form-label">Tên loại phòng <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editRoomTypeName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRoomTypeDescription" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="editRoomTypeDescription" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal xóa loại phòng -->
<div class="modal fade" id="deleteRoomTypeModal" tabindex="-1" aria-labelledby="deleteRoomTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteRoomTypeModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa loại phòng "<span id="deleteRoomTypeName"></span>"?</p>
                <p class="text-danger"><strong>Lưu ý:</strong> Nếu có phòng thuộc loại này, bạn sẽ không thể xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="#" id="deleteRoomTypeBtn" class="btn btn-danger">Xóa</a>
            </div>
        </div>
    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Khởi tạo DataTable
    $('#roomTypesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
        }
    });
    
    // Xử lý modal sửa loại phòng
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');
        
        $('#editRoomTypeId').val(id);
        $('#editRoomTypeName').val(name);
        $('#editRoomTypeDescription').val(description);
    });
    
    // Xử lý modal xóa loại phòng
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('#deleteRoomTypeName').text(name);
        $('#deleteRoomTypeBtn').attr('href', '/pdu_pms_project/public/admin/delete_room_type?id=' + id);
    });
});
</script>

<?php include(dirname(__DIR__) . '/layouts/footer.php'); ?> 