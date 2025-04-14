<?php include __DIR__ . '/../layouts/admin_layout.php'; ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Quản lý đặt phòng</h5>
        <div>
            <a href="/pdu_pms_project/public/admin/add_booking" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Thêm đặt phòng
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <form action="/pdu_pms_project/public/admin/manage_bookings" method="get" class="row g-3">
                <div class="col-md-2">
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $data['filters']['start_date'] ?? '' ?>" placeholder="Từ ngày">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $data['filters']['end_date'] ?? '' ?>" placeholder="Đến ngày">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="">Tất cả người dùng</option>
                        <?php if (isset($data['users']) && is_array($data['users'])): ?>
                            <?php foreach ($data['users'] as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= (isset($data['filters']['user_id']) && $data['filters']['user_id'] == $user['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user['fullname'] ?? $user['username']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" <?= isset($data['filters']['status']) && $data['filters']['status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                        <option value="approved" <?= isset($data['filters']['status']) && $data['filters']['status'] === 'approved' ? 'selected' : '' ?>>Đã duyệt</option>
                        <option value="rejected" <?= isset($data['filters']['status']) && $data['filters']['status'] === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i> Lọc
                    </button>
                    <a href="/pdu_pms_project/public/admin/manage_bookings" class="btn btn-light border">
                        <i class="fas fa-redo me-1"></i>
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <select class="form-select form-select-sm d-inline-block w-auto" id="length-change">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div>
                    <input type="search" class="form-control form-control-sm d-inline-block w-auto" placeholder="Nhập tìm kiếm..." id="table-search">
                </div>
            </div>
            <table class="table table-striped table-hover" id="bookingsTable">
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
                    <?php if (isset($data['bookings']) && is_array($data['bookings'])): ?>
                        <?php foreach ($data['bookings'] as $booking): ?>
                        <tr>
                            <td><?= $booking['id'] ?? '' ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php
                                    $initials = '';
                                    $fullname = '';
                                    
                                    // Ưu tiên hiển thị tên giáo viên, nếu không có thì hiển thị tên sinh viên
                                    if (!empty($booking['teacher_name'])) {
                                        $fullname = $booking['teacher_name'];
                                        $role = 'Giáo viên';
                                    } elseif (!empty($booking['student_name'])) {
                                        $fullname = $booking['student_name'];
                                        $role = 'Sinh viên';
                                    }
                                    
                                    $nameParts = explode(' ', $fullname);
                                    if (count($nameParts) > 0) {
                                        $lastName = end($nameParts);
                                        $initials = mb_substr($lastName, 0, 1, 'UTF-8');
                                    }
                                    
                                    $bgColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
                                    $colorIndex = isset($booking['id']) ? $booking['id'] % count($bgColors) : 0;
                                    $bgColor = $bgColors[$colorIndex];
                                    ?>
                                    <div class="avatar-sm me-2" style="background-color: <?= $bgColor ?>;"><?= $initials ?></div>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($fullname) ?></div>
                                        <small class="text-muted"><?= $role ?? 'Người dùng' ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($booking['room_name'] ?? '') ?></td>
                            <td><?= isset($booking['start_time']) ? date('d/m/Y H:i', strtotime($booking['start_time'])) : '' ?></td>
                            <td><?= isset($booking['end_time']) ? date('d/m/Y H:i', strtotime($booking['end_time'])) : '' ?></td>
                            <td>
                                <?php if (strtolower($booking['status'] ?? '') == 'pending'): ?>
                                    <span class="badge bg-warning">Chờ duyệt</span>
                                <?php elseif (strtolower($booking['status'] ?? '') == 'approved'): ?>
                                    <span class="badge bg-success">Đã duyệt</span>
                                <?php elseif (strtolower($booking['status'] ?? '') == 'rejected'): ?>
                                    <span class="badge bg-danger">Từ chối</span>
                                <?php elseif (strtolower($booking['status'] ?? '') == 'cancelled'): ?>
                                    <span class="badge bg-secondary">Đã hủy</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= htmlspecialchars($booking['status'] ?? 'Không xác định') ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light border view-booking-details" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#bookingDetailsModal"
                                        data-id="<?= $booking['id'] ?? '' ?>"
                                        data-user="<?= htmlspecialchars($booking['user_fullname'] ?? $booking['user_name'] ?? '') ?>"
                                        data-room="<?= htmlspecialchars($booking['room_name'] ?? '') ?>"
                                        data-start="<?= isset($booking['start_time']) ? date('d/m/Y H:i', strtotime($booking['start_time'])) : '' ?>"
                                        data-end="<?= isset($booking['end_time']) ? date('d/m/Y H:i', strtotime($booking['end_time'])) : '' ?>"
                                        data-status="<?= $booking['status'] ?? '' ?>"
                                        data-purpose="<?= htmlspecialchars($booking['purpose'] ?? '') ?>"
                                        data-created="<?= isset($booking['created_at']) ? date('d/m/Y H:i', strtotime($booking['created_at'])) : '' ?>"
                                        title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php if (($booking['status'] ?? '') == 'pending'): ?>
                                    <a href="/pdu_pms_project/public/admin/approve_booking/<?= $booking['id'] ?? '' ?>" class="btn btn-sm btn-light border" data-bs-toggle="tooltip" title="Duyệt đặt phòng">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="/pdu_pms_project/public/admin/reject_booking/<?= $booking['id'] ?? '' ?>" class="btn btn-sm btn-light border" data-bs-toggle="tooltip" title="Từ chối đặt phòng">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-sm btn-light border delete-booking" 
                                        data-id="<?= $booking['id'] ?? '' ?>" 
                                        data-room="<?= htmlspecialchars($booking['room_name'] ?? '') ?>"
                                        data-bs-toggle="tooltip" title="Xóa đặt phòng">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có đặt phòng nào được tìm thấy</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Booking Details Modal -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingDetailsModalLabel">Chi tiết đặt phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Thông tin chung</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%">ID đặt phòng:</th>
                                <td id="modal-booking-id"></td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td id="modal-booking-status"></td>
                            </tr>
                            <tr>
                                <th>Thời gian tạo:</th>
                                <td id="modal-booking-created"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Thông tin người đặt</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%">Họ và tên:</th>
                                <td id="modal-booking-user"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Thông tin đặt phòng</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 20%">Phòng:</th>
                                <td id="modal-booking-room"></td>
                            </tr>
                            <tr>
                                <th>Thời gian bắt đầu:</th>
                                <td id="modal-booking-start"></td>
                            </tr>
                            <tr>
                                <th>Thời gian kết thúc:</th>
                                <td id="modal-booking-end"></td>
                            </tr>
                            <tr>
                                <th>Mục đích sử dụng:</th>
                                <td id="modal-booking-purpose"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <a href="#" id="modal-edit-link" class="btn btn-primary">Chỉnh sửa</a>
                <a href="#" id="modal-delete-link" class="btn btn-danger">Xóa đặt phòng</a>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}
</style>

<!-- Add DataTables library for better table management -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var bookingsTable = $('#bookingsTable').DataTable({
            responsive: true,
            searching: true,
            lengthChange: true,
            pageLength: 10,
            language: {
                lengthMenu: "",
                search: "",
                zeroRecords: "Không tìm thấy dữ liệu phù hợp",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                infoEmpty: "Hiển thị 0 đến 0 của 0 mục",
                infoFiltered: "(lọc từ _MAX_ mục)",
                paginate: {
                    first: "Đầu",
                    last: "Cuối",
                    next: "Tiếp",
                    previous: "Trước"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>rtip'
        });
        
        // Make length selector nicer
        $('.dataTables_length select').addClass('form-select-sm');
        
        // Remove the text "Hiển thị [entries]" 
        $('.dataTables_length label').contents().filter(function() {
            return this.nodeType === 3; // Text node
        }).remove();
        
        // Connect custom search box with DataTables search
        $('#table-search').on('keyup', function() {
            bookingsTable.search(this.value).draw();
        });
        
        // Connect custom length menu with DataTables
        $('#length-change').on('change', function() {
            bookingsTable.page.len($(this).val()).draw();
        });

        // View booking details
        $(document).on('click', '.view-booking-details', function() {
            const id = $(this).data('id');
            const user = $(this).data('user');
            const room = $(this).data('room');
            const start = $(this).data('start');
            const end = $(this).data('end');
            const status = $(this).data('status');
            const purpose = $(this).data('purpose');
            const created = $(this).data('created');
            
            // Cập nhật nội dung modal
            $('#modal-booking-id').text(id);
            $('#modal-booking-user').text(user);
            $('#modal-booking-room').text(room);
            $('#modal-booking-start').text(start);
            $('#modal-booking-end').text(end);
            $('#modal-booking-purpose').text(purpose || 'Không có thông tin');
            $('#modal-booking-created').text(created || 'Không có thông tin');
            
            // Hiển thị trạng thái với màu phù hợp
            let statusHtml = '';
            if (status === 'pending') {
                statusHtml = '<span class="badge bg-warning">Chờ duyệt</span>';
            } else if (status === 'approved') {
                statusHtml = '<span class="badge bg-success">Đã duyệt</span>';
            } else if (status === 'rejected') {
                statusHtml = '<span class="badge bg-danger">Từ chối</span>';
            } else {
                statusHtml = '<span class="badge bg-secondary">Không xác định</span>';
            }
            $('#modal-booking-status').html(statusHtml);
            
            // Cập nhật các link trong modal
            $('#modal-edit-link').attr('href', '/pdu_pms_project/public/admin/edit_booking/' + id);
            $('#modal-delete-link').attr('href', 'javascript:void(0)').data('id', id).data('room', room);
        });
        
        // Xử lý xóa từ trong modal
        $(document).on('click', '#modal-delete-link', function() {
            if (confirm('Bạn có chắc chắn muốn xóa đặt phòng này?')) {
                const id = $(this).data('id');
                window.location.href = '/pdu_pms_project/public/admin/delete_booking/' + id;
            }
        });
        
        // Handle deletion button outside modal
        $(document).on('click', '.delete-booking', function() {
            if (confirm('Bạn có chắc chắn muốn xóa đặt phòng cho phòng ' + $(this).data('room') + '?')) {
                const id = $(this).data('id');
                window.location.href = '/pdu_pms_project/public/admin/delete_booking/' + id;
            }
        });

        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?php // Removed footer include as it's handled in admin_layout ?>