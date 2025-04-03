<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/teacher_navbar.php'; ?>

<div class="search-rooms-container">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Tìm kiếm phòng</h1>
            <p class="page-subtitle">Tìm và đề xuất đặt phòng theo thời gian và nhu cầu sử dụng</p>
        </div>
    </div>

    <!-- Search Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="m-0"><i class="fas fa-search me-2"></i>Bộ lọc tìm kiếm</h5>
        </div>
        <div class="card-body">
            <form action="" method="GET" id="searchForm">
                <div class="row g-3">
                    <!-- Basic Filters -->
                    <div class="col-md-6 col-lg-3">
                        <label for="room_name" class="form-label">Tên phòng</label>
                        <input type="text" class="form-control" id="room_name" name="room_name" placeholder="Nhập tên phòng..." value="<?= isset($_GET['room_name']) ? htmlspecialchars($_GET['room_name']) : '' ?>">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label for="room_type" class="form-label">Loại phòng</label>
                        <select class="form-select" id="room_type" name="room_type">
                            <option value="">Tất cả loại phòng</option>
                            <?php foreach ($roomTypes as $type): ?>
                                <option value="<?= $type['id'] ?>" <?= (isset($_GET['room_type']) && $_GET['room_type'] == $type['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($type['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label for="min_capacity" class="form-label">Sức chứa tối thiểu</label>
                        <input type="number" class="form-control" id="min_capacity" name="min_capacity" min="1" placeholder="Số người" value="<?= isset($_GET['min_capacity']) ? intval($_GET['min_capacity']) : '' ?>">
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <label for="location" class="form-label">Vị trí</label>
                        <select class="form-select" id="location" name="location">
                            <option value="">Tất cả vị trí</option>
                            <?php foreach ($locations as $loc): ?>
                                <option value="<?= $loc ?>" <?= (isset($_GET['location']) && $_GET['location'] == $loc) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($loc) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Show Available Times Toggle -->
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggle_time_filter" 
                                <?= (isset($_GET['date']) || isset($_GET['start_time']) || isset($_GET['end_time'])) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="toggle_time_filter">Tìm phòng theo thời gian khả dụng</label>
                        </div>
                    </div>

                    <!-- Advanced Time Filters (Initially Hidden) -->
                    <div class="col-12 time-filters" style="display: <?= (isset($_GET['date']) || isset($_GET['start_time']) || isset($_GET['end_time'])) ? 'block' : 'none' ?>;">
                        <div class="card border-light bg-light">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="date" class="form-label">Ngày</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="start_time" class="form-label">Thời gian bắt đầu</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?= isset($_GET['start_time']) ? htmlspecialchars($_GET['start_time']) : '07:00' ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_time" class="form-label">Thời gian kết thúc</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?= isset($_GET['end_time']) ? htmlspecialchars($_GET['end_time']) : '08:30' ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Thiết bị cần có</label>
                                        <div class="row g-2">
                                            <?php foreach ($equipment as $item): ?>
                                                <div class="col-md-4 col-lg-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="equipment[]" value="<?= $item['id'] ?>" id="equip_<?= $item['id'] ?>"
                                                            <?= (isset($_GET['equipment']) && in_array($item['id'], $_GET['equipment'])) ? 'checked' : '' ?>>
                                                        <label class="form-check-label" for="equip_<?= $item['id'] ?>">
                                                            <?= htmlspecialchars($item['name']) ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Buttons -->
                    <div class="col-12 d-flex justify-content-between">
                        <a href="/pdu_pms_project/public/teacher/search_rooms" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-2"></i>Đặt lại bộ lọc
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-search me-2"></i>Tìm kiếm
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="m-0"><i class="fas fa-th-list me-2"></i>Kết quả tìm kiếm</h5>
            <?php if (!empty($rooms)): ?>
                <span class="badge bg-primary rounded-pill"><?= count($rooms) ?> phòng</span>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($rooms)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Tên phòng</th>
                                <th>Loại</th>
                                <th>Sức chứa</th>
                                <th>Vị trí</th>
                                <th>Trạng thái</th>
                                <th class="text-end pe-3">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rooms as $room): ?>
                                <?php
                                $statusClass = 'success';
                                $statusText = 'Khả dụng';
                                
                                if ($room['status'] === 'Đang bảo trì') {
                                    $statusClass = 'warning';
                                    $statusText = 'Đang bảo trì';
                                } elseif ($room['status'] === 'Không khả dụng' || $room['status'] === 'đã đặt') {
                                    $statusClass = 'danger';
                                    $statusText = 'Không khả dụng';
                                }
                                ?>
                                <tr>
                                    <td class="ps-3 fw-semibold"><?= htmlspecialchars($room['name']) ?></td>
                                    <td><?= htmlspecialchars($room['room_type_name']) ?></td>
                                    <td>
                                        <i class="fas fa-users text-muted me-1"></i>
                                        <?= intval($room['capacity']) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <?= htmlspecialchars($room['location']) ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $statusClass ?>-subtle text-<?= $statusClass ?> px-3 py-2 rounded-pill">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="/pdu_pms_project/public/teacher/room_detail?id=<?= $room['id'] ?>" class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-info-circle me-1"></i>Chi tiết
                                        </a>
                                        <?php if ($statusClass === 'success'): ?>
                                            <a href="/pdu_pms_project/public/teacher/book_room?room_id=<?= $room['id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-calendar-plus me-1"></i>Đặt phòng
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5>Không tìm thấy phòng nào</h5>
                    <p class="text-muted">Không có kết quả phù hợp với các tiêu chí tìm kiếm của bạn</p>
                    <a href="/pdu_pms_project/public/teacher/search_rooms" class="btn btn-outline-primary mt-2">
                        <i class="fas fa-redo me-2"></i>Đặt lại bộ lọc
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JavaScript for Toggle Time Filters -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleTimeFilter = document.getElementById('toggle_time_filter');
    const timeFilters = document.querySelector('.time-filters');
    
    toggleTimeFilter.addEventListener('change', function() {
        if (this.checked) {
            timeFilters.style.display = 'block';
        } else {
            timeFilters.style.display = 'none';
            // Reset time-related fields
            document.getElementById('date').disabled = true;
            document.getElementById('start_time').disabled = true;
            document.getElementById('end_time').disabled = true;
            document.querySelectorAll('input[name="equipment[]"]').forEach(item => {
                item.disabled = true;
            });
        }
    });
    
    // Ensure form submission includes time fields only when toggle is checked
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        if (!toggleTimeFilter.checked) {
            // Disable time-related fields so they won't be included in the query string
            document.getElementById('date').disabled = true;
            document.getElementById('start_time').disabled = true;
            document.getElementById('end_time').disabled = true;
            document.querySelectorAll('input[name="equipment[]"]').forEach(item => {
                item.disabled = true;
            });
        } else {
            // Enable fields for submission
            document.getElementById('date').disabled = false;
            document.getElementById('start_time').disabled = false;
            document.getElementById('end_time').disabled = false;
            document.querySelectorAll('input[name="equipment[]"]').forEach(item => {
                item.disabled = false;
            });
        }
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?> 