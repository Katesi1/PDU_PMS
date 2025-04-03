<?php
$pageTitle = "Lịch Đặt Phòng Của Tôi";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="h3 mb-2 text-gray-800">Lịch Đặt Phòng Của Tôi</h1>
                    <p class="mb-4">Quản lý tất cả các lịch đặt phòng của bạn</p>
                </div>
                <div class="d-flex">
                    <a href="/pdu_pms_project/public/student/search_rooms" class="btn btn-primary me-2">
                        <i class="fas fa-plus-circle me-1"></i> Đặt phòng mới
                    </a>
                    <button class="btn btn-outline-primary" id="filterToggle">
                        <i class="fas fa-filter me-1"></i> Bộ lọc
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Bộ lọc -->
    <div class="row mb-4" id="filterContainer" style="display: none;">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="/pdu_pms_project/public/student/my_bookings" method="get" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Tất cả trạng thái</option>
                                <option value="chờ duyệt" <?php echo isset($_GET['status']) && $_GET['status'] === 'chờ duyệt' ? 'selected' : ''; ?>>Chờ duyệt</option>
                                <option value="đã duyệt" <?php echo isset($_GET['status']) && $_GET['status'] === 'đã duyệt' ? 'selected' : ''; ?>>Đã duyệt</option>
                                <option value="từ chối" <?php echo isset($_GET['status']) && $_GET['status'] === 'từ chối' ? 'selected' : ''; ?>>Từ chối</option>
                                <option value="đã hủy" <?php echo isset($_GET['status']) && $_GET['status'] === 'đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
                                <option value="hoàn thành" <?php echo isset($_GET['status']) && $_GET['status'] === 'hoàn thành' ? 'selected' : ''; ?>>Hoàn thành</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date_from" class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="date_to" class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="room_type" class="form-label">Loại phòng</label>
                            <select class="form-select" id="room_type" name="room_type">
                                <option value="">Tất cả loại phòng</option>
                                <?php if (isset($data['room_types'])): ?>
                                    <?php foreach ($data['room_types'] as $type): ?>
                                        <option value="<?php echo $type['id']; ?>" <?php echo isset($_GET['room_type']) && $_GET['room_type'] == $type['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($type['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="reset" class="btn btn-outline-secondary me-2">Đặt lại</button>
                            <button type="submit" class="btn btn-primary">Áp dụng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab điều hướng -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?php echo !isset($_GET['tab']) || $_GET['tab'] === 'upcoming' ? 'active' : ''; ?>" href="/pdu_pms_project/public/student/my_bookings?tab=upcoming">
                        Sắp tới 
                        <?php if (isset($data['upcoming_count']) && $data['upcoming_count'] > 0): ?>
                            <span class="badge bg-primary rounded-pill ms-1"><?php echo $data['upcoming_count']; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['tab']) && $_GET['tab'] === 'pending' ? 'active' : ''; ?>" href="/pdu_pms_project/public/student/my_bookings?tab=pending">
                        Chờ duyệt
                        <?php if (isset($data['pending_count']) && $data['pending_count'] > 0): ?>
                            <span class="badge bg-warning rounded-pill ms-1"><?php echo $data['pending_count']; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['tab']) && $_GET['tab'] === 'past' ? 'active' : ''; ?>" href="/pdu_pms_project/public/student/my_bookings?tab=past">
                        Đã qua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['tab']) && $_GET['tab'] === 'cancelled' ? 'active' : ''; ?>" href="/pdu_pms_project/public/student/my_bookings?tab=cancelled">
                        Đã hủy
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isset($_GET['tab']) && $_GET['tab'] === 'all' ? 'active' : ''; ?>" href="/pdu_pms_project/public/student/my_bookings?tab=all">
                        Tất cả
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Danh sách lịch đặt phòng -->
    <div class="row">
        <div class="col-12">
            <?php if (empty($data['bookings'])): ?>
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <img src="/pdu_pms_project/public/assets/img/empty-bookings.svg" alt="Không có lịch đặt phòng" class="mb-3" style="max-width: 200px;">
                        <h5>Không có lịch đặt phòng nào</h5>
                        <p class="text-muted">Bạn chưa có lịch đặt phòng nào trong mục này</p>
                        <a href="/pdu_pms_project/public/student/search_rooms" class="btn btn-primary mt-2">
                            <i class="fas fa-plus-circle me-1"></i> Đặt phòng ngay
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="min-width: 100px;">Mã đặt</th>
                                        <th style="min-width: 120px;">Phòng</th>
                                        <th style="min-width: 120px;">Thời gian</th>
                                        <th style="min-width: 120px;">Mã lớp</th>
                                        <th style="min-width: 120px;">Trạng thái</th>
                                        <th style="min-width: 120px;">Ngày đặt</th>
                                        <th class="text-center" style="min-width: 120px;">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['bookings'] as $booking): ?>
                                        <tr>
                                            <td>
                                                <span class="fw-bold">#<?php echo $booking['id']; ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                                        <i class="fas fa-door-open text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($booking['room_name']); ?></div>
                                                        <div class="small text-muted"><?php echo htmlspecialchars($booking['room_type_name']); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <?php 
                                                    $startDate = date('d/m/Y', strtotime($booking['start_time']));
                                                    $endDate = date('d/m/Y', strtotime($booking['end_time']));
                                                    
                                                    if ($startDate === $endDate) {
                                                        echo $startDate;
                                                    } else {
                                                        echo $startDate . ' - ' . $endDate;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="small text-muted">
                                                    <?php echo date('H:i', strtotime($booking['start_time'])); ?> - 
                                                    <?php echo date('H:i', strtotime($booking['end_time'])); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($booking['class_code']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = 'secondary';
                                                $statusIcon = 'clock';
                                                
                                                switch ($booking['status']) {
                                                    case 'chờ duyệt':
                                                        $statusClass = 'warning';
                                                        $statusIcon = 'hourglass-half';
                                                        break;
                                                    case 'đã duyệt':
                                                        $statusClass = 'success';
                                                        $statusIcon = 'check-circle';
                                                        break;
                                                    case 'từ chối':
                                                        $statusClass = 'danger';
                                                        $statusIcon = 'times-circle';
                                                        break;
                                                    case 'đã hủy':
                                                        $statusClass = 'secondary';
                                                        $statusIcon = 'ban';
                                                        break;
                                                    case 'hoàn thành':
                                                        $statusClass = 'info';
                                                        $statusIcon = 'check-double';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge bg-<?php echo $statusClass; ?>-subtle text-<?php echo $statusClass; ?> px-2 py-1 rounded">
                                                    <i class="fas fa-<?php echo $statusIcon; ?> me-1"></i>
                                                    <?php echo htmlspecialchars($booking['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div><?php echo date('d/m/Y', strtotime($booking['created_at'])); ?></div>
                                                <div class="small text-muted"><?php echo date('H:i', strtotime($booking['created_at'])); ?></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="/pdu_pms_project/public/student/booking_detail/<?php echo $booking['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <?php if ($booking['status'] === 'chờ duyệt'): ?>
                                                    <a href="/pdu_pms_project/public/student/edit_booking/<?php echo $booking['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($booking['status'] === 'chờ duyệt' || $booking['status'] === 'đã duyệt'): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger cancel-booking" data-bs-toggle="modal" data-bs-target="#cancelModal" data-id="<?php echo $booking['id']; ?>">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Phân trang -->
                <?php if (isset($data['pagination']) && $data['pagination']['total_pages'] > 1): ?>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        Hiển thị <?php echo $data['pagination']['offset'] + 1; ?> đến 
                        <?php echo min($data['pagination']['offset'] + $data['pagination']['limit'], $data['pagination']['total_records']); ?> 
                        trong tổng số <?php echo $data['pagination']['total_records']; ?> lịch đặt phòng
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <?php if ($data['pagination']['current_page'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="/pdu_pms_project/public/student/my_bookings?page=<?php echo $data['pagination']['current_page'] - 1; ?><?php echo isset($_GET['tab']) ? '&tab=' . $_GET['tab'] : ''; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $data['pagination']['current_page'] - 2); $i <= min($data['pagination']['total_pages'], $data['pagination']['current_page'] + 2); $i++): ?>
                            <li class="page-item <?php echo $i === $data['pagination']['current_page'] ? 'active' : ''; ?>">
                                <a class="page-link" href="/pdu_pms_project/public/student/my_bookings?page=<?php echo $i; ?><?php echo isset($_GET['tab']) ? '&tab=' . $_GET['tab'] : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                            <?php endfor; ?>
                            
                            <?php if ($data['pagination']['current_page'] < $data['pagination']['total_pages']): ?>
                            <li class="page-item">
                                <a class="page-link" href="/pdu_pms_project/public/student/my_bookings?page=<?php echo $data['pagination']['current_page'] + 1; ?><?php echo isset($_GET['tab']) ? '&tab=' . $_GET['tab'] : ''; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal hủy đặt phòng -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Xác nhận hủy đặt phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy lịch đặt phòng này?</p>
                <p class="mb-0 text-danger">Lưu ý: Việc hủy đặt phòng nhiều lần có thể ảnh hưởng đến khả năng đặt phòng trong tương lai.</p>
            </div>
            <div class="modal-footer">
                <form action="/pdu_pms_project/public/student/cancel_booking" method="post">
                    <input type="hidden" name="booking_id" id="cancelBookingId">
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label">Lý do hủy</label>
                        <textarea class="form-control" name="cancel_reason" id="cancel_reason" rows="3" required></textarea>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý hiển thị/ẩn bộ lọc
    const filterToggle = document.getElementById('filterToggle');
    const filterContainer = document.getElementById('filterContainer');
    
    filterToggle.addEventListener('click', function() {
        if (filterContainer.style.display === 'none') {
            filterContainer.style.display = 'block';
        } else {
            filterContainer.style.display = 'none';
        }
    });
    
    // Hiển thị bộ lọc nếu có tham số lọc trong URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status') || urlParams.has('date_from') || urlParams.has('date_to') || urlParams.has('room_type')) {
        filterContainer.style.display = 'block';
    }
    
    // Xử lý khi click vào nút hủy đặt phòng
    const cancelButtons = document.querySelectorAll('.cancel-booking');
    const cancelBookingId = document.getElementById('cancelBookingId');
    
    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-id');
            cancelBookingId.value = bookingId;
        });
    });
    
    // Kiểm tra form hủy đặt phòng
    const cancelForm = document.querySelector('#cancelModal form');
    const cancelReason = document.getElementById('cancel_reason');
    
    if (cancelForm) {
        cancelForm.addEventListener('submit', function(event) {
            if (!cancelReason.value.trim()) {
                event.preventDefault();
                alert('Vui lòng nhập lý do hủy đặt phòng');
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 