<?php
// Đảm bảo người dùng đã đăng nhập với vai trò admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

include __DIR__ . '/../layouts/admin_layout.php'; ?>

<div class="container-fluid mt-4">
    <!-- Page Title -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-layer-group me-2"></i> Quản lý loại phòng</h1>
            <p class="text-muted">Quản lý các loại phòng học và cấu hình đặc điểm cho từng loại</p>
        </div>
        <a href="/pdu_pms_project/public/admin/manage_rooms" class="btn btn-primary shadow-sm">
            <i class="fas fa-door-open fa-sm text-white-50 me-1"></i> Quản lý phòng
        </a>
    </div>

    <!-- Content Row - Stats -->
    <div class="row mb-4">
        <!-- Total Room Types Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số loại phòng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($roomTypes ?? []) ?></div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon bg-primary-light">
                                <i class="fas fa-layer-group fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Rooms Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng số phòng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= array_sum(array_column($roomTypes ?? [], 'room_count')) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon bg-success-light">
                                <i class="fas fa-door-open fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty Room Types Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 stat-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Loại phòng chưa có phòng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($roomTypes ?? [], function($type) { 
                                    return ($type['room_count'] ?? 0) == 0; 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon bg-warning-light">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Room Types Table Card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 table-card">
                <div class="card-header py-3 bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-list me-2"></i>Danh sách loại phòng</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-export me-1"></i> Xuất danh sách</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-print me-1"></i> In danh sách</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-1"></i> Làm mới</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show animated--grow-in" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_GET['message']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show animated--grow-in" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_GET['error']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="roomTypesTable" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="25%">Tên loại phòng</th>
                                    <th width="40%">Mô tả</th>
                                    <th width="15%">Số phòng</th>
                                    <th width="15%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roomTypes)): ?>
                                    <?php foreach ($roomTypes as $roomType): ?>
                                        <tr>
                                            <td><?= $roomType['id'] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="room-type-icon me-2 <?= (isset($roomType['room_count']) && $roomType['room_count'] > 0) ? 'bg-info' : 'bg-warning' ?>">
                                                        <i class="fas fa-layer-group"></i>
                                                    </div>
                                                    <strong><?= htmlspecialchars($roomType['name']) ?></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-inline-block" style="max-width: 300px;" title="<?= htmlspecialchars($roomType['description'] ?? 'Không có mô tả') ?>">
                                                    <?= htmlspecialchars($roomType['description'] ?? 'Không có mô tả') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= (isset($roomType['room_count']) && $roomType['room_count'] > 0) ? 'info' : 'warning' ?> badge-counter">
                                                    <?= $roomType['room_count'] ?? 0 ?> phòng
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="/pdu_pms_project/public/admin/edit_room_type/<?= $roomType['id'] ?>" class="btn btn-sm btn-warning btn-action" data-toggle="tooltip" title="Sửa loại phòng">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if (!isset($roomType['room_count']) || $roomType['room_count'] == 0): ?>
                                                        <a href="javascript:void(0)" onclick="confirmDelete(<?= $roomType['id'] ?>, '<?= htmlspecialchars($roomType['name']) ?>')" class="btn btn-sm btn-danger btn-action" data-toggle="tooltip" title="Xóa loại phòng">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-danger btn-action disabled" data-toggle="tooltip" title="Không thể xóa loại phòng đang được sử dụng">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
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

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 form-card">
                <div class="card-header py-3 bg-gradient-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-plus-circle me-2"></i>Thêm loại phòng mới</h6>
                </div>
                <div class="card-body">
                    <form action="/pdu_pms_project/public/admin/add_room_type" method="post" id="addRoomTypeForm">
                        <input type="hidden" name="add_room_type" value="1">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên loại phòng <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên loại phòng" required>
                            </div>
                            <div class="invalid-feedback" id="name-error">Vui lòng nhập tên loại phòng</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Mô tả đặc điểm của loại phòng"></textarea>
                            </div>
                            <div class="form-text text-muted mt-2"><i class="fas fa-info-circle me-1"></i> Mô tả chi tiết về đặc điểm, trang thiết bị của loại phòng</div>
                        </div>
                        
                        <div class="mb-3" id="formFeedback">
                            <?php if (isset($_GET['error_form'])): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_GET['error_form']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-submit">
                                <i class="fas fa-plus-circle me-1"></i> Thêm loại phòng
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4 info-card">
                <div class="card-header py-3 bg-gradient-info text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle me-2"></i>Thông tin</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="text-info mb-3"><i class="fas fa-lightbulb me-2"></i>Mục đích</h5>
                        <div class="info-box">
                            <p>
                                Loại phòng giúp phân loại các phòng học theo mục đích sử dụng, trang thiết bị và đặc điểm riêng.
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="text-warning mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Lưu ý quan trọng</h5>
                        <div class="note-box">
                            <div class="note-icon">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="note-content">
                                <ul class="note-list mb-0">
                                    <li><i class="fas fa-times-circle text-danger me-2"></i>Không thể xóa loại phòng đang được sử dụng</li>
                                    <li><i class="fas fa-edit text-warning me-2"></i>Sửa tên loại phòng sẽ ảnh hưởng đến tất cả các phòng thuộc loại đó</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Mỗi loại phòng nên có đặc điểm riêng biệt để dễ dàng phân loại</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-trash me-2"></i>Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa loại phòng <strong id="roomTypeName"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="#" id="deleteLink" class="btn btn-danger">Xóa loại phòng</a>
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
    
    /* Stat Card Enhancements */
    .stat-card {
        overflow: hidden;
        border-radius: 0.75rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .stat-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
    }
    
    .bg-primary-light {
        background-color: rgba(78, 115, 223, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(28, 200, 138, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(246, 194, 62, 0.1);
    }
    
    /* Room Type Icon */
    .room-type-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    tr:hover .room-type-icon {
        transform: scale(1.1);
    }
    
    /* Table Card */
    .table-card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .table-card .card-header {
        border-bottom: none;
    }
    
    .badge-counter {
        padding: 0.35em 0.65em;
        font-weight: 500;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.2s ease;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .btn-action:hover:not(.disabled) {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    /* Form Card */
    .form-card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .form-card .card-header {
        border-bottom: none;
    }
    
    .input-group-text {
        background-color: #f8f9fc;
        border-right: none;
    }
    
    .form-control {
        border-left: none;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: #bac8f3;
    }
    
    .form-control:focus {
        border-color: #bac8f3;
        box-shadow: none;
    }
    
    .btn-submit {
        padding: 0.75rem 1.25rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        box-shadow: 0 0.25rem 0.5rem rgba(28, 200, 138, 0.2);
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(28, 200, 138, 0.3);
    }
    
    /* Info Card */
    .info-card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .info-card .card-header {
        border-bottom: none;
    }
    
    .info-box {
        background-color: rgba(54, 185, 204, 0.1);
        border-radius: 0.5rem;
        padding: 1rem;
        border-left: 3px solid #36b9cc;
    }
    
    .note-box {
        display: flex;
        background-color: #fff7e1;
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
        border-left: 3px solid #f6c23e;
    }
    
    .note-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 2.5rem;
        height: 2.5rem;
        background-color: #f6c23e;
        color: white;
        border-radius: 50%;
        margin-right: 1rem;
        box-shadow: 0 0.25rem 0.5rem rgba(246, 194, 62, 0.2);
    }
    
    .note-content {
        flex: 1;
    }
    
    .note-list {
        list-style: none;
        padding-left: 0;
    }
    
    .note-list li {
        padding: 0.5rem 0;
        border-bottom: 1px dashed rgba(246, 194, 62, 0.3);
        display: flex;
        align-items: center;
    }
    
    .note-list li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    /* Animated elements */
    .animated--grow-in {
        animation-name: growIn;
        animation-duration: 0.3s;
        animation-timing-function: transform cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .animated--fade-in {
        animation-name: fadeIn;
        animation-duration: 0.2s;
        animation-timing-function: opacity cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    @keyframes growIn {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }
    
    /* Gradient headers */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%) !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%) !important;
    }
    
    /* Fix for any lingering modal backdrop */
    .modal-backdrop {
        z-index: 1040 !important;
    }
    
    .modal {
        z-index: 1050 !important;
    }
    
    /* Fix for the form always being accessible */
    .form-card {
        position: relative;
        z-index: 1060 !important; /* Higher than modal and backdrop */
    }
</style>

<script>
    $(document).ready(function() {
        // Clean up any lingering modal backdrops
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
        $('body').css('padding-right', '');
        
        // Initialize DataTable
        $('#roomTypesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
            },
            pageLength: 10,
            order: [[0, 'asc']],
            responsive: true,
            dom: '<"top"lf>rt<"bottom"ip>'
        });
        
        // Initialize tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        // Simpler form validation
        $('#addRoomTypeForm').on('submit', function(e) {
            // Reset any previous validation state
            $('#name').removeClass('is-invalid');
            
            // Basic validation for the name field
            if ($('#name').val().trim() === '') {
                $('#name').addClass('is-invalid');
                e.preventDefault();
                return false;
            }
            
            // If validation passes, allow the form to submit normally
            return true;
        });
        
        // Clear validation errors on input
        $('#name').on('input', function() {
            $(this).removeClass('is-invalid');
        });
        
        // Ensure modal cleanup when closed
        $('#deleteModal').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('overflow', '');
            $('body').css('padding-right', '');
        });
    });
    
    // Delete confirmation
    function confirmDelete(id, name) {
        // Clean up any existing modals first
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('overflow', '');
        
        $('#roomTypeName').text(name);
        $('#deleteLink').attr('href', '/pdu_pms_project/public/admin/delete_room_type/' + id);
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
    
    // Additional fix for any click on the body that might encounter a modal backdrop
    $(document).on('click', '.modal-backdrop', function() {
        $(this).remove();
        $('body').removeClass('modal-open').css('overflow', '');
        $('body').css('padding-right', '');
    });
</script> 