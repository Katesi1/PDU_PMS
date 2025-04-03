<?php
// Đảm bảo chỉ cho admin truy cập
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

include __DIR__ . '/../layouts/admin_layout.php';

require_once __DIR__ . '/../../Helpers/BreadcrumbHelper.php';
?>

<div class="page-title d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold">Thêm người dùng mới</h1>
        <p class="text-muted mb-0">Tạo tài khoản mới cho người dùng trong hệ thống</p>
    </div>
    <div>
        <a href="/pdu_pms_project/public/admin/manage_users" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-user-plus me-2"></i> Thông tin người dùng</h6>
    </div>
    <div class="card-body">
        <form method="POST" class="p-3">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Vai trò</label>
                <select name="role" class="form-select">
                    <option value="admin">Admin</option>
                    <option value="teacher">Giáo viên</option>
                    <option value="student">Sinh viên</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mã lớp (nếu là sinh viên)</label>
                <input type="text" name="class_code" class="form-control">
            </div>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="/pdu_pms_project/public/admin/manage_users" class="btn btn-secondary">Hủy bỏ</a>
                <button type="submit" name="add_user" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Lưu người dùng
                </button>
            </div>
        </form>
    </div>
</div>

</div> <!-- Close admin-content div from admin_sidebar.php -->

<?php include(dirname(__DIR__) . '/layouts/footer.php'); ?>