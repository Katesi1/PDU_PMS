<?php include __DIR__ . '/../layouts/admin_layout.php'; ?>
<?php require_once __DIR__ . '/../../Helpers/BreadcrumbHelper.php'; ?>

<div class="container-fluid mt-4 px-4">
    <!-- Page Title and Breadcrumb -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-edit mr-2"></i> Chỉnh sửa phòng</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="/pdu_pms_project/public/admin/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/pdu_pms_project/public/admin/manage_rooms">Danh sách phòng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa phòng</li>
                </ol>
            </nav>
        </div>
        <a href="/pdu_pms_project/public/admin/manage_rooms" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Quay lại
        </a>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Thông tin phòng #<?php echo $data['room']['id']; ?></h6>
                </div>
                <div class="card-body">
                    <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i> <?php echo $data['error']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="user">
                        <input type="hidden" name="id" value="<?php echo $data['room']['id']; ?>">
                        
                        <div class="form-group">
                            <label class="form-label font-weight-bold"><i class="fas fa-door-open mr-1"></i> Tên phòng</label>
                            <input type="text" name="name" value="<?php echo $data['room']['name']; ?>" 
                                class="form-control form-control-user" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label font-weight-bold"><i class="fas fa-users mr-1"></i> Sức chứa</label>
                            <input type="number" name="capacity" value="<?php echo $data['room']['capacity']; ?>" 
                                class="form-control form-control-user" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label font-weight-bold"><i class="fas fa-layer-group mr-1"></i> Loại phòng</label>
                            <select name="room_type_id" class="form-control form-control-user">
                                <option value="">-- Chọn loại phòng --</option>
                                <?php if (isset($data['roomTypes']) && is_array($data['roomTypes'])): ?>
                                    <?php foreach ($data['roomTypes'] as $roomType): ?>
                                        <option value="<?php echo $roomType['id']; ?>" <?php echo (isset($data['room']['room_type_id']) && $data['room']['room_type_id'] == $roomType['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($roomType['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label font-weight-bold"><i class="fas fa-info-circle mr-1"></i> Trạng thái</label>
                            <select name="status" class="form-control form-control-user">
                                <option value="trống" <?php echo $data['room']['status'] === 'trống' ? 'selected' : ''; ?>>
                                    <i class="fas fa-check-circle"></i> Trống
                                </option>
                                <option value="đã đặt" <?php echo $data['room']['status'] === 'đã đặt' ? 'selected' : ''; ?>>
                                    <i class="fas fa-calendar-check"></i> Đã đặt
                                </option>
                                <option value="bảo trì" <?php echo $data['room']['status'] === 'bảo trì' ? 'selected' : ''; ?>>
                                    <i class="fas fa-tools"></i> Bảo trì
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <button type="submit" name="edit_room" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-save mr-1"></i> Lưu thay đổi
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <a href="/pdu_pms_project/public/admin/manage_rooms" class="btn btn-secondary btn-user btn-block">
                                    <i class="fas fa-times mr-1"></i> Hủy
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Room Details Preview -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-info">
                    <h6 class="m-0 font-weight-bold text-white">Xem trước thông tin</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-door-open fa-5x text-primary mb-3"></i>
                        <h4 id="preview-name"><?php echo $data['room']['name']; ?></h4>
                    </div>
                    
                    <div class="mb-4">
                        <div class="row align-items-center py-2 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-hashtag mr-1"></i> ID Phòng:
                            </div>
                            <div class="col-7 font-weight-bold">
                                <?php echo $data['room']['id']; ?>
                            </div>
                        </div>
                        
                        <div class="row align-items-center py-2 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-layer-group mr-1"></i> Loại phòng:
                            </div>
                            <div class="col-7 font-weight-bold" id="preview-roomtype">
                                <?php 
                                $roomTypeName = "Không xác định";
                                if (isset($data['room']['room_type_id']) && isset($data['roomTypes'])) {
                                    foreach ($data['roomTypes'] as $roomType) {
                                        if ($roomType['id'] == $data['room']['room_type_id']) {
                                            $roomTypeName = $roomType['name'];
                                            break;
                                        }
                                    }
                                }
                                echo $roomTypeName;
                                ?>
                            </div>
                        </div>
                        
                        <div class="row align-items-center py-2 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-users mr-1"></i> Sức chứa:
                            </div>
                            <div class="col-7 font-weight-bold" id="preview-capacity">
                                <?php echo $data['room']['capacity']; ?> người
                            </div>
                        </div>
                        
                        <div class="row align-items-center py-2 border-bottom">
                            <div class="col-5 text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Trạng thái:
                            </div>
                            <div class="col-7">
                                <span id="preview-status" class="badge badge-<?php 
                                    echo $data['room']['status'] === 'trống' ? 'success' : 
                                         ($data['room']['status'] === 'đã đặt' ? 'warning' : 'danger'); ?>">
                                    <?php echo ucfirst($data['room']['status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle mr-2"></i> Thông tin sẽ cập nhật sau khi lưu thay đổi.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="name"]');
    const capacityInput = document.querySelector('input[name="capacity"]');
    const statusSelect = document.querySelector('select[name="status"]');
    const roomTypeSelect = document.querySelector('select[name="room_type_id"]');
    
    const previewName = document.getElementById('preview-name');
    const previewCapacity = document.getElementById('preview-capacity');
    const previewStatus = document.getElementById('preview-status');
    const previewRoomType = document.getElementById('preview-roomtype');
    
    // Update preview when inputs change
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value;
    });
    
    capacityInput.addEventListener('input', function() {
        previewCapacity.textContent = this.value + ' người';
    });
    
    statusSelect.addEventListener('change', function() {
        previewStatus.textContent = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        
        // Update badge color
        previewStatus.className = 'badge badge-' + 
            (this.value === 'trống' ? 'success' : 
             (this.value === 'đã đặt' ? 'warning' : 'danger'));
    });
    
    roomTypeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        previewRoomType.textContent = selectedOption.textContent !== '-- Chọn loại phòng --' ? 
            selectedOption.textContent : 'Không xác định';
    });
});
</script>