<?php
$pageTitle = "Đặt Phòng Học";
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/pdu_pms_project/public/student/dashboard">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/pdu_pms_project/public/student/search_rooms">Tìm kiếm phòng</a></li>
                    <?php if (isset($data['room'])): ?>
                    <li class="breadcrumb-item"><a href="/pdu_pms_project/public/student/room_detail/<?php echo $data['room']['id']; ?>">Chi tiết phòng</a></li>
                    <?php endif; ?>
                    <li class="breadcrumb-item active" aria-current="page">Đặt phòng học</li>
                </ol>
            </nav>
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

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Thông tin đặt phòng</h5>
                </div>
                <div class="card-body">
                    <form action="/pdu_pms_project/public/student/submit_booking" method="post" id="bookingForm">
                        <!-- Phòng đã chọn -->
                        <?php if (isset($data['room'])): ?>
                            <input type="hidden" name="room_id" value="<?php echo $data['room']['id']; ?>">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Phòng đã chọn</label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                                <i class="fas fa-door-open fa-lg text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($data['room']['name']); ?></h6>
                                                <p class="text-muted mb-0">
                                                    <small>
                                                        <i class="fas fa-map-marker-alt me-1"></i><?php echo htmlspecialchars($data['room']['location']); ?> |
                                                        <i class="fas fa-users me-1"></i><?php echo htmlspecialchars($data['room']['capacity']); ?> người |
                                                        <i class="fas fa-tag me-1"></i><?php echo htmlspecialchars($data['room']['room_type_name']); ?>
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mb-4">
                                <label for="room_id" class="form-label fw-bold">Chọn phòng</label>
                                <select class="form-select" id="room_id" name="room_id" required>
                                    <option value="" selected disabled>-- Chọn phòng học --</option>
                                    <?php if (isset($data['available_rooms'])): ?>
                                        <?php foreach($data['available_rooms'] as $room): ?>
                                            <option value="<?php echo $room['id']; ?>" 
                                                data-capacity="<?php echo $room['capacity']; ?>"
                                                data-type="<?php echo $room['room_type_name']; ?>"
                                                data-location="<?php echo $room['location']; ?>">
                                                <?php echo htmlspecialchars($room['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div id="roomDetails" class="mt-2 d-none">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <p class="mb-0 small">
                                                <i class="fas fa-map-marker-alt me-1"></i><span id="roomLocation"></span> |
                                                <i class="fas fa-users me-1"></i><span id="roomCapacity"></span> người |
                                                <i class="fas fa-tag me-1"></i><span id="roomType"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Thông tin thời gian -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label fw-bold">Thời gian bắt đầu</label>
                                <input type="datetime-local" class="form-control" id="start_time" name="start_time" required
                                    <?php if (isset($_GET['start'])): ?>
                                    value="<?php echo date('Y-m-d\TH:i', strtotime($_GET['start'])); ?>"
                                    <?php else: ?>
                                    min="<?php echo date('Y-m-d\TH:i'); ?>"
                                    <?php endif; ?>>
                                <div class="invalid-feedback">Vui lòng chọn thời gian bắt đầu</div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_time" class="form-label fw-bold">Thời gian kết thúc</label>
                                <input type="datetime-local" class="form-control" id="end_time" name="end_time" required
                                    <?php if (isset($_GET['end'])): ?>
                                    value="<?php echo date('Y-m-d\TH:i', strtotime($_GET['end'])); ?>"
                                    <?php endif; ?>>
                                <div class="invalid-feedback">Vui lòng chọn thời gian kết thúc sau thời gian bắt đầu</div>
                            </div>
                        </div>

                        <!-- Thông tin lớp học -->
                        <div class="mb-4">
                            <label for="class_code" class="form-label fw-bold">Mã lớp học</label>
                            <input type="text" class="form-control" id="class_code" name="class_code" placeholder="Ví dụ: CS101, MATH202..." required>
                            <div class="form-text">Nhập mã lớp học hoặc mã hoạt động</div>
                        </div>

                        <!-- Mục đích sử dụng -->
                        <div class="mb-4">
                            <label for="purpose" class="form-label fw-bold">Mục đích sử dụng</label>
                            <select class="form-select" id="purpose" name="purpose" required>
                                <option value="" selected disabled>-- Chọn mục đích sử dụng --</option>
                                <option value="học nhóm">Học nhóm</option>
                                <option value="thuyết trình">Thuyết trình</option>
                                <option value="ôn thi">Ôn thi</option>
                                <option value="seminar">Seminar</option>
                                <option value="hội họp">Hội họp</option>
                                <option value="khác">Khác</option>
                            </select>
                        </div>

                        <div id="otherPurposeContainer" class="mb-4 d-none">
                            <label for="other_purpose" class="form-label">Mục đích khác</label>
                            <input type="text" class="form-control" id="other_purpose" name="other_purpose" placeholder="Vui lòng nêu rõ mục đích sử dụng...">
                        </div>

                        <!-- Số người tham gia -->
                        <div class="mb-4">
                            <label for="participants" class="form-label fw-bold">Số lượng người tham gia (dự kiến)</label>
                            <input type="number" class="form-control" id="participants" name="participants" min="1" required>
                            <div class="form-text" id="capacity-warning"></div>
                        </div>

                        <!-- Ghi chú -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">Ghi chú bổ sung</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Ghi chú thêm về nhu cầu đặc biệt hoặc thông tin khác..."></textarea>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                Tôi đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">quy định sử dụng phòng học</a>
                            </label>
                            <div class="invalid-feedback">
                                Bạn phải đồng ý với quy định trước khi đặt phòng
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-check me-2"></i>Gửi yêu cầu đặt phòng
                            </button>
                            <a href="/pdu_pms_project/public/student/search_rooms" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại tìm kiếm
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Lịch sử dụng phòng -->
            <?php if (isset($data['room']) && isset($data['room_schedule'])): ?>
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Lịch sử dụng phòng</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($data['room_schedule'])): ?>
                        <div class="p-4 text-center">
                            <i class="far fa-calendar-check fa-3x text-muted mb-3"></i>
                            <p>Không có lịch sử dụng nào được đặt trong thời gian sắp tới</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($data['room_schedule'] as $schedule): ?>
                                <div class="list-group-item px-3 py-3 d-flex">
                                    <div class="me-3 text-center" style="min-width: 50px;">
                                        <div class="bg-light rounded px-2 py-1">
                                            <div class="small"><?php echo date('d/m', strtotime($schedule['start_time'])); ?></div>
                                        </div>
                                        <div class="small mt-1"><?php echo date('H:i', strtotime($schedule['start_time'])); ?></div>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold"><?php echo htmlspecialchars($schedule['class_code']); ?></p>
                                        <p class="mb-0 small text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            <?php echo date('H:i', strtotime($schedule['start_time'])); ?> - 
                                            <?php echo date('H:i', strtotime($schedule['end_time'])); ?>
                                        </p>
                                        <p class="mb-0 small text-muted">
                                            <i class="far fa-user me-1"></i>
                                            <?php 
                                            if (!empty($schedule['teacher_name'])):
                                                echo 'GV: ' . htmlspecialchars($schedule['teacher_name']);
                                            elseif (!empty($schedule['student_name'])):
                                                echo 'SV: ' . htmlspecialchars($schedule['student_name']);
                                            else:
                                                echo 'Không có thông tin';
                                            endif;
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Hướng dẫn đặt phòng -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Hướng dẫn đặt phòng</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px;">
                                <span class="text-white fw-bold small">1</span>
                            </div>
                            <div>Chọn phòng học phù hợp với nhu cầu sử dụng</div>
                        </div>
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px;">
                                <span class="text-white fw-bold small">2</span>
                            </div>
                            <div>Nhập đầy đủ thông tin mã lớp và mục đích sử dụng</div>
                        </div>
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px;">
                                <span class="text-white fw-bold small">3</span>
                            </div>
                            <div>Chọn thời gian bắt đầu và kết thúc phù hợp</div>
                        </div>
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px;">
                                <span class="text-white fw-bold small">4</span>
                            </div>
                            <div>Đọc và đồng ý với quy định sử dụng phòng học</div>
                        </div>
                        <div class="list-group-item px-0 border-0 d-flex">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 24px; height: 24px;">
                                <span class="text-white fw-bold small">5</span>
                            </div>
                            <div>Gửi yêu cầu và chờ phê duyệt từ quản trị viên</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Giới hạn đặt phòng -->
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Lưu ý quan trọng</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Chỉ được đặt phòng tối đa 3 giờ mỗi lần
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Đặt phòng trước ít nhất 24 giờ
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Hủy đặt phòng trước ít nhất 2 giờ
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Mỗi sinh viên chỉ được đặt tối đa 3 phòng mỗi tuần
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Sử dụng đúng mục đích và số người đã đăng ký
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Quy định sử dụng phòng -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Quy định sử dụng phòng học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="fw-bold">1. Quy định chung</h6>
                    <ul>
                        <li>Chỉ sử dụng phòng học sau khi được phê duyệt đặt phòng</li>
                        <li>Chỉ sử dụng phòng đúng thời gian đã đăng ký</li>
                        <li>Đảm bảo sử dụng phòng đúng mục đích và số lượng người đã đăng ký</li>
                        <li>Không được tự ý chuyển nhượng phòng đã đặt cho người khác</li>
                    </ul>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">2. Bảo quản tài sản</h6>
                    <ul>
                        <li>Không tự ý di chuyển bàn ghế, thiết bị trong phòng học</li>
                        <li>Không làm hư hỏng, vẽ, viết lên tường, bàn ghế và các thiết bị trong phòng</li>
                        <li>Báo cáo ngay khi phát hiện hư hỏng hoặc mất mát tài sản</li>
                        <li>Chịu trách nhiệm bồi thường nếu làm hư hỏng, mất mát tài sản</li>
                    </ul>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">3. Vệ sinh phòng học</h6>
                    <ul>
                        <li>Không mang đồ ăn, thức uống vào phòng học (trừ nước đóng chai)</li>
                        <li>Giữ gìn vệ sinh, không xả rác trong phòng học</li>
                        <li>Dọn dẹp sạch sẽ trước khi rời khỏi phòng</li>
                    </ul>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">4. An toàn và an ninh</h6>
                    <ul>
                        <li>Tắt điện, thiết bị khi rời khỏi phòng</li>
                        <li>Đóng cửa sổ, cửa ra vào khi rời khỏi phòng</li>
                        <li>Không mang theo vật dễ cháy nổ, nguy hiểm vào phòng học</li>
                        <li>Tuân thủ nội quy phòng học và hướng dẫn của cán bộ quản lý</li>
                    </ul>
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold">5. Hủy đặt phòng</h6>
                    <ul>
                        <li>Hủy đặt phòng ít nhất 2 giờ trước thời gian bắt đầu sử dụng</li>
                        <li>Thông báo cho quản trị viên nếu không thể sử dụng phòng như đã đăng ký</li>
                        <li>Nếu không hủy đặt phòng mà không sử dụng 3 lần, tài khoản sẽ bị khóa quyền đặt phòng</li>
                    </ul>
                </div>
                
                <div>
                    <p class="fw-bold text-danger">Vi phạm quy định có thể dẫn đến việc bị hạn chế hoặc mất quyền đặt phòng trong tương lai.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="agreeTerms" data-bs-dismiss="modal">Tôi đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý khi chọn phòng
    const roomSelect = document.getElementById('room_id');
    if (roomSelect) {
        roomSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const roomDetails = document.getElementById('roomDetails');
            
            if (this.value) {
                document.getElementById('roomLocation').textContent = selectedOption.dataset.location;
                document.getElementById('roomCapacity').textContent = selectedOption.dataset.capacity;
                document.getElementById('roomType').textContent = selectedOption.dataset.type;
                roomDetails.classList.remove('d-none');
            } else {
                roomDetails.classList.add('d-none');
            }
        });
    }
    
    // Xử lý khi chọn mục đích sử dụng
    const purposeSelect = document.getElementById('purpose');
    const otherPurposeContainer = document.getElementById('otherPurposeContainer');
    const otherPurposeInput = document.getElementById('other_purpose');
    
    purposeSelect.addEventListener('change', function() {
        if (this.value === 'khác') {
            otherPurposeContainer.classList.remove('d-none');
            otherPurposeInput.setAttribute('required', 'required');
        } else {
            otherPurposeContainer.classList.add('d-none');
            otherPurposeInput.removeAttribute('required');
        }
    });
    
    // Kiểm tra thời gian
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    startTimeInput.addEventListener('change', function() {
        const startTime = new Date(this.value);
        const now = new Date();
        
        // Đặt giá trị tối thiểu cho thời gian kết thúc
        if (startTime > now) {
            // Thêm 30 phút vào thời gian bắt đầu cho thời gian kết thúc tối thiểu
            const minEndTime = new Date(startTime.getTime() + 30 * 60000);
            endTimeInput.min = minEndTime.toISOString().slice(0, 16);
            
            // Nếu thời gian kết thúc hiện tại nhỏ hơn thời gian bắt đầu, cập nhật nó
            if (endTimeInput.value && new Date(endTimeInput.value) <= startTime) {
                const newEndTime = new Date(startTime.getTime() + 60 * 60000); // 1 giờ sau thời gian bắt đầu
                endTimeInput.value = newEndTime.toISOString().slice(0, 16);
            }
        }
    });
    
    endTimeInput.addEventListener('change', function() {
        const startTime = new Date(startTimeInput.value);
        const endTime = new Date(this.value);
        
        // Kiểm tra nếu thời gian kết thúc trước thời gian bắt đầu
        if (endTime <= startTime) {
            this.setCustomValidity('Thời gian kết thúc phải sau thời gian bắt đầu');
        } else {
            this.setCustomValidity('');
            
            // Kiểm tra nếu thời gian đặt phòng vượt quá 3 giờ
            const hoursDiff = (endTime - startTime) / (1000 * 60 * 60);
            if (hoursDiff > 3) {
                alert('Thời gian đặt phòng không được vượt quá 3 giờ. Vui lòng điều chỉnh lại thời gian.');
                // Đặt thời gian kết thúc là 3 giờ sau thời gian bắt đầu
                const newEndTime = new Date(startTime.getTime() + 3 * 60 * 60 * 1000);
                this.value = newEndTime.toISOString().slice(0, 16);
            }
        }
    });
    
    // Kiểm tra số người tham gia
    const participantsInput = document.getElementById('participants');
    const capacityWarning = document.getElementById('capacity-warning');
    
    participantsInput.addEventListener('change', function() {
        let maxCapacity;
        
        if (roomSelect) {
            // Nếu đang ở trang chọn phòng
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            if (selectedOption && selectedOption.dataset.capacity) {
                maxCapacity = parseInt(selectedOption.dataset.capacity);
            }
        } else if (document.querySelector('input[name="room_id"]')) {
            // Nếu đã có phòng được chọn từ trang trước
            <?php if (isset($data['room']) && isset($data['room']['capacity'])): ?>
            maxCapacity = <?php echo intval($data['room']['capacity']); ?>;
            <?php endif; ?>
        }
        
        if (maxCapacity && parseInt(this.value) > maxCapacity) {
            capacityWarning.textContent = `Cảnh báo: Số người vượt quá sức chứa tối đa (${maxCapacity} người) của phòng.`;
            capacityWarning.classList.add('text-danger');
        } else if (maxCapacity && parseInt(this.value) > maxCapacity * 0.8) {
            capacityWarning.textContent = `Lưu ý: Số người gần đạt sức chứa tối đa (${maxCapacity} người) của phòng.`;
            capacityWarning.classList.add('text-warning');
            capacityWarning.classList.remove('text-danger');
        } else {
            capacityWarning.textContent = '';
            capacityWarning.classList.remove('text-warning', 'text-danger');
        }
    });
    
    // Xử lý khi đồng ý điều khoản từ modal
    document.getElementById('agreeTerms').addEventListener('click', function() {
        document.getElementById('terms').checked = true;
    });
    
    // Kiểm tra form trước khi submit
    document.getElementById('bookingForm').addEventListener('submit', function(event) {
        const startTime = new Date(startTimeInput.value);
        const endTime = new Date(endTimeInput.value);
        const now = new Date();
        
        // Kiểm tra nếu thời gian bắt đầu quá sớm (ít nhất 24 giờ)
        const minBookingTime = new Date(now.getTime() + 24 * 60 * 60 * 1000);
        if (startTime < minBookingTime) {
            alert('Yêu cầu đặt phòng phải được thực hiện trước ít nhất 24 giờ. Vui lòng chọn thời gian khác.');
            event.preventDefault();
            return;
        }
        
        // Kiểm tra thời lượng đặt phòng
        const hoursDiff = (endTime - startTime) / (1000 * 60 * 60);
        if (hoursDiff > 3) {
            alert('Thời gian đặt phòng không được vượt quá 3 giờ. Vui lòng điều chỉnh lại thời gian.');
            event.preventDefault();
            return;
        }
        
        // Kiểm tra nếu chưa đồng ý với điều khoản
        if (!document.getElementById('terms').checked) {
            alert('Vui lòng đồng ý với quy định sử dụng phòng học trước khi gửi yêu cầu.');
            event.preventDefault();
            return;
        }
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>