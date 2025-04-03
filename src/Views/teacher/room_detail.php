<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/../layouts/teacher_navbar.php'; ?>

<div class="room-detail-container">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title"><?= htmlspecialchars($room['name']) ?></h1>
            <p class="page-subtitle">Thông tin chi tiết và lịch sử dụng phòng</p>
        </div>
        <div>
            <a href="/pdu_pms_project/public/teacher/search_rooms" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại tìm kiếm
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Room Info -->
        <div class="col-xl-8">
            <!-- Room Details Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0"><i class="fas fa-info-circle me-2"></i>Thông tin phòng</h5>
                    <?php
                    $statusClass = 'success';
                    $statusText = 'Khả dụng';
                    $statusIcon = 'check-circle';
                    
                    if ($room['status'] === 'Đang bảo trì') {
                        $statusClass = 'warning';
                        $statusText = 'Đang bảo trì';
                        $statusIcon = 'tools';
                    } elseif ($room['status'] === 'Không khả dụng' || $room['status'] === 'đã đặt') {
                        $statusClass = 'danger';
                        $statusText = 'Không khả dụng';
                        $statusIcon = 'times-circle';
                    }
                    ?>
                    <span class="badge bg-<?= $statusClass ?>-subtle text-<?= $statusClass ?> px-3 py-2 rounded-pill">
                        <i class="fas fa-<?= $statusIcon ?> me-1"></i>
                        <?= $statusText ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Room Info -->
                        <div class="col-md-8">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-uppercase text-muted small fw-bold">Tên phòng</h6>
                                    <p class="fs-5 fw-semibold"><?= htmlspecialchars($room['name']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-uppercase text-muted small fw-bold">Loại phòng</h6>
                                    <p><?= htmlspecialchars($room['room_type_name']) ?></p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-uppercase text-muted small fw-bold">Vị trí</h6>
                                    <p>
                                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                        <?= htmlspecialchars($room['location']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-uppercase text-muted small fw-bold">Sức chứa</h6>
                                    <p>
                                        <i class="fas fa-users me-2 text-primary"></i>
                                        <?= intval($room['capacity']) ?> người
                                    </p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted small fw-bold">Mô tả</h6>
                                <p><?= !empty($room['description']) ? htmlspecialchars($room['description']) : '<em class="text-muted">Không có mô tả</em>' ?></p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-md-4">
                            <div class="d-grid gap-3">
                                <a href="/pdu_pms_project/public/teacher/book_room?room_id=<?= $room['id'] ?>" class="btn btn-primary py-3">
                                    <i class="fas fa-calendar-plus me-2"></i>Đặt phòng này
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0"><i class="fas fa-desktop me-2"></i>Thiết bị trong phòng</h5>
                    <span class="badge bg-primary rounded-pill"><?= count($room['equipment'] ?? []) ?> thiết bị</span>
                </div>
                <div class="card-body p-0">
                    <?php if (isset($room['equipment']) && !empty($room['equipment'])): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Tên thiết bị</th>
                                        <th>Mô tả</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end pe-3">Bảo trì gần nhất</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($room['equipment'] as $equipment): ?>
                                        <?php
                                        $equipStatusClass = 'success';
                                        $equipStatusIcon = 'check-circle';
                                        if ($equipment['status'] !== 'hoạt động') {
                                            $equipStatusClass = 'warning';
                                            $equipStatusIcon = 'exclamation-triangle';
                                        }
                                        ?>
                                        <tr>
                                            <td class="ps-3">
                                                <div class="d-flex align-items-center">
                                                    <?php
                                                    $icon = 'desktop';
                                                    $equipName = strtolower($equipment['name']);
                                                    if (strpos($equipName, 'máy chiếu') !== false || strpos($equipName, 'projector') !== false) {
                                                        $icon = 'film';
                                                    } elseif (strpos($equipName, 'bàn') !== false || strpos($equipName, 'ghế') !== false || strpos($equipName, 'table') !== false) {
                                                        $icon = 'chair';
                                                    } elseif (strpos($equipName, 'điều hòa') !== false || strpos($equipName, 'air') !== false) {
                                                        $icon = 'fan';
                                                    } elseif (strpos($equipName, 'đèn') !== false || strpos($equipName, 'light') !== false) {
                                                        $icon = 'lightbulb';
                                                    }
                                                    ?>
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 34px; height: 34px;">
                                                        <i class="fas fa-<?= $icon ?> text-primary"></i>
                                                    </div>
                                                    <div class="fw-semibold"><?= htmlspecialchars($equipment['name']) ?></div>
                                                </div>
                                            </td>
                                            <td><?= !empty($equipment['description']) ? htmlspecialchars($equipment['description']) : '<em class="text-muted">Không có mô tả</em>' ?></td>
                                            <td>
                                                <span class="badge bg-<?= $equipStatusClass ?>-subtle text-<?= $equipStatusClass ?> px-3 py-2 rounded-pill">
                                                    <i class="fas fa-<?= $equipStatusIcon ?> me-1"></i>
                                                    <?= htmlspecialchars($equipment['status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <?= $equipment['last_maintenance_date'] ? date('d/m/Y', strtotime($equipment['last_maintenance_date'])) : '<em class="text-muted">Chưa bảo trì</em>' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5>Không có thiết bị</h5>
                            <p class="text-muted">Phòng này không có thiết bị hoặc chưa cập nhật thông tin thiết bị</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-xl-4">
            <!-- Available Time Slots Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0"><i class="fas fa-clock me-2"></i>Khung giờ trống</h5>
                    <span class="badge bg-primary rounded-pill"><?= count($availableSlots) ?> khung giờ</span>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($availableSlots)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach (array_slice($availableSlots, 0, 10) as $slot): ?>
                                <a href="/pdu_pms_project/public/teacher/book_room?room_id=<?= $room['id'] ?>&start_time=<?= urlencode($slot['start']) ?>&end_time=<?= urlencode($slot['end']) ?>" 
                                   class="list-group-item list-group-item-action py-3 border-start-0 border-end-0">
                                    <div class="d-flex">
                                        <div class="me-3 text-center" style="min-width: 60px;">
                                            <?php
                                            $slotDate = new DateTime($slot['start']);
                                            $dayOfWeek = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
                                            ?>
                                            <div class="bg-light rounded-3 py-1">
                                                <div class="small"><?= $dayOfWeek[$slotDate->format('w')] ?></div>
                                                <div class="fw-bold"><?= $slotDate->format('d/m') ?></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 fw-semibold"><?= date('H:i', strtotime($slot['start'])) ?> - <?= date('H:i', strtotime($slot['end'])) ?></h6>
                                                <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1">
                                                    <i class="fas fa-check-circle me-1"></i> Trống
                                                </span>
                                            </div>
                                            <div class="small text-muted mt-1">
                                                <i class="far fa-clock me-1"></i>
                                                Thời lượng: <?= round((strtotime($slot['end']) - strtotime($slot['start'])) / 3600, 1) ?> giờ
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($availableSlots) > 10): ?>
                            <div class="text-center py-3 border-top">
                                <a href="/pdu_pms_project/public/teacher/suggest_rooms?room_id=<?= $room['id'] ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-calendar-alt me-1"></i>Xem thêm khung giờ trống
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="far fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5>Không có khung giờ trống</h5>
                            <p class="text-muted">Phòng này không có khung giờ trống trong 7 ngày tới</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Room Usage Guidelines Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0"><i class="fas fa-info-circle me-2"></i>Hướng dẫn sử dụng</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="me-3 rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <span class="fw-bold">1</span>
                            </div>
                            <div>Đặt phòng trước khi sử dụng</div>
                        </div>
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="me-3 rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <span class="fw-bold">2</span>
                            </div>
                            <div>Kiểm tra thiết bị trước khi bắt đầu giảng dạy</div>
                        </div>
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="me-3 rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <span class="fw-bold">3</span>
                            </div>
                            <div>Báo cáo ngay khi phát hiện thiết bị hỏng hóc</div>
                        </div>
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="me-3 rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <span class="fw-bold">4</span>
                            </div>
                            <div>Tắt thiết bị và điều hòa khi rời khỏi phòng</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?> 