<?php include __DIR__ . '/../layouts/admin_layout.php'; ?>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Quản lý đặt phòng</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <form action="/pdu_pms_project/public/admin/manage_bookings" method="get" class="row g-3">
                <div class="col-md-2">
                    <label for="start_date" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $data['filters']['start_date'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <label for="end_date" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $data['filters']['end_date'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="user_id" class="form-label">Người đặt</label>
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
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả</option>
                        <option value="pending" <?= isset($data['filters']['status']) && $data['filters']['status'] === 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                        <option value="approved" <?= isset($data['filters']['status']) && $data['filters']['status'] === 'approved' ? 'selected' : '' ?>>Đã duyệt</option>
                        <option value="rejected" <?= isset($data['filters']['status']) && $data['filters']['status'] === 'rejected' ? 'selected' : '' ?>>Từ chối</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary me-2">
                        <i class="fas fa-filter me-1"></i> Lọc
                    </button>
                    <a href="/pdu_pms_project/public/admin/manage_bookings" class="btn btn-light border">
                        <i class="fas fa-redo me-1"></i> Đặt lại
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
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
                                    $fullname = $booking['user_fullname'] ?? $booking['user_name'] ?? '';
                                    $nameParts = explode(' ', $fullname);
                                    if (count($nameParts) > 0) {
                                        $lastName = end($nameParts);
                                        $initials = mb_substr($lastName, 0, 1, 'UTF-8');
                                    }
                                    $bgColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
                                    $colorIndex = isset($booking['user_id']) ? $booking['user_id'] % count($bgColors) : 0;
                                    $bgColor = $bgColors[$colorIndex];
                                    ?>
                                    <div class="avatar-sm me-2" style="background-color: <?= $bgColor ?>;"><?= $initials ?></div>
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($booking['user_fullname'] ?? $booking['user_name'] ?? '') ?></div>
                                        <small class="text-muted">ID: <?= $booking['user_id'] ?? '' ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($booking['room_name'] ?? '') ?></td>
                            <td><?= isset($booking['start_time']) ? date('d/m/Y H:i', strtotime($booking['start_time'])) : '' ?></td>
                            <td><?= isset($booking['end_time']) ? date('d/m/Y H:i', strtotime($booking['end_time'])) : '' ?></td>
                            <td>
                                <?php if (($booking['status'] ?? '') == 'pending'): ?>
                                    <span class="badge bg-secondary">Chờ duyệt</span>
                                <?php elseif (($booking['status'] ?? '') == 'approved'): ?>
                                    <span class="badge bg-secondary">Đã duyệt</span>
                                <?php elseif (($booking['status'] ?? '') == 'rejected'): ?>
                                    <span class="badge bg-secondary">Từ chối</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Không xác định</span>
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

<!-- Script xử lý thao tác và khởi tạo DataTable -->
<script>
    $(document).ready(function() {
        // Khởi tạo DataTable
        const table = $('#bookingsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
            },
            order: [[0, 'desc']],
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Tất cả"]]
        });
        
        // Xử lý xóa đặt phòng
        $(document).on('click', '.delete-booking', function() {
            const bookingId = $(this).data('id');
            const roomName = $(this).data('room');
            
            if (confirm('Bạn có chắc chắn muốn xóa đặt phòng cho phòng "' + roomName + '"?\nHành động này không thể hoàn tác.')) {
                // Tạo form ẩn để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/pdu_pms_project/public/admin/delete_booking/' + bookingId;
                
                // Thêm CSRF token nếu cần
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = 'csrf_token';
                csrfToken.value = '<?= $_SESSION['csrf_token'] ?? '' ?>';
                form.appendChild(csrfToken);
                
                // Thêm method field để xác định đây là DELETE request
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                // Thêm form vào body và submit
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        });
        
        // Xử lý hiển thị chi tiết đặt phòng
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
                statusHtml = '<span class="badge bg-secondary">Chờ duyệt</span>';
            } else if (status === 'approved') {
                statusHtml = '<span class="badge bg-secondary">Đã duyệt</span>';
            } else if (status === 'rejected') {
                statusHtml = '<span class="badge bg-secondary">Từ chối</span>';
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
            const bookingId = $(this).data('id');
            const roomName = $(this).data('room');
            
            if (confirm('Bạn có chắc chắn muốn xóa đặt phòng cho phòng "' + roomName + '"?\nHành động này không thể hoàn tác.')) {
                // Tạo form ẩn để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/pdu_pms_project/public/admin/delete_booking/' + bookingId;
                
                // Thêm CSRF token nếu cần
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = 'csrf_token';
                csrfToken.value = '<?= $_SESSION['csrf_token'] ?? '' ?>';
                form.appendChild(csrfToken);
                
                // Thêm method field để xác định đây là DELETE request
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                // Thêm form vào body và submit
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        });
        
        // Khởi tạo tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<?php // Removed footer include as it's handled in admin_layout ?>