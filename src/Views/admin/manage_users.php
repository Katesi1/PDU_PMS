<?php
// Đảm bảo người dùng đã đăng nhập với vai trò admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Include header layout
include(dirname(__DIR__) . '/layouts/header.php');
// Include admin sidebar
include(dirname(__DIR__) . '/layouts/admin_sidebar.php');
?>

<div class="page-title d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold">Quản lý người dùng</h1>
        <p class="text-muted mb-0">Quản lý tài khoản và quyền truy cập của người dùng</p>
    </div>
    <div>
        <a href="/pdu_pms_project/public/admin/add_user" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Thêm người dùng
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-users me-2"></i> Danh sách người dùng</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="usersDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="usersDropdown">
                <li><a class="dropdown-item" href="#"><i class="fas fa-file-export me-1"></i> Xuất CSV</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-print me-1"></i> In danh sách</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-1"></i> Làm mới</a></li>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="usersTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Tên người dùng</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['users'] as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $user['role'] == 'admin' ? 'danger' : 
                                        ($user['role'] == 'teacher' ? 'primary' : 'success'); 
                                ?>">
                                    <?php echo htmlspecialchars($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="/pdu_pms_project/public/admin/edit_user?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/pdu_pms_project/public/admin/delete_user?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div> <!-- Close admin-content div from admin_sidebar.php -->

<?php include(dirname(__DIR__) . '/layouts/footer.php'); ?>