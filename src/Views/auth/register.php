<?php
$pageTitle = "Đăng ký";
include __DIR__ . '/../layouts/header.php';
?>

<style>
    body {
        padding-top: 0;
        margin-top: 0;
    }
    
    /* Reset padding và margin */
    .container-fluid, .row, .col, .card {
        margin-top: 0;
        padding-top: 0;
    }
    
    /* Container chứa nội dung đăng ký */
    .auth-container {
        margin-top: 200px; /* Khoảng cách từ đỉnh trang */
        padding-bottom: 40px;
    }
    
    /* Card styling */
    .auth-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        overflow: hidden;
        background-color: #fff;
    }
    
    .auth-card .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .auth-card .card-body {
        padding: 2rem;
    }
    
    .auth-card .card-footer {
        padding: 1.5rem;
        background-color: rgba(0, 0, 0, 0.02);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    /* Form elements */
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        padding: 0.75rem;
        border-radius: 0.375rem;
    }
    
    .form-check {
        margin-top: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .btn-primary {
        padding: 0.75rem;
        font-weight: 500;
    }
    
    /* Responsive fixes */
    @media (max-width: 768px) {
        .auth-container {
            margin-top: 150px;
        }
        
        .auth-card .card-body {
            padding: 1.5rem;
        }
    }
</style>

<!-- Sử dụng container riêng biệt cho trang đăng ký -->
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="auth-card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Đăng ký tài khoản mới</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                    echo $_SESSION['error']; 
                                    unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                    echo $_SESSION['success']; 
                                    unset($_SESSION['success']);
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="/pdu_pms_project/public/register/process" method="post" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập tên đăng nhập.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập địa chỉ email hợp lệ.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="full_name" class="form-label">Họ và tên đầy đủ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập họ và tên đầy đủ.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập mật khẩu.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <div class="invalid-feedback">
                                        Mật khẩu xác nhận không khớp.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="" selected disabled>Chọn vai trò</option>
                                        <option value="teacher">Giảng viên</option>
                                        <option value="student">Sinh viên</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn vai trò.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 d-none" id="class_code_container">
                                    <label for="class_code" class="form-label">Mã lớp học <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="class_code" name="class_code">
                                    <div class="invalid-feedback">
                                        Vui lòng nhập mã lớp học.
                                    </div>
                                    <small class="text-muted">Chỉ dành cho sinh viên</small>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">Tôi đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">điều khoản sử dụng</a> <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">
                                    Bạn phải đồng ý với điều khoản sử dụng.
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" name="register">Đăng ký</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Đã có tài khoản? <a href="/pdu_pms_project/public/login">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Điều khoản sử dụng -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Điều khoản sử dụng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Quy định chung</h6>
                <p>Hệ thống PDU PMS được phát triển và quản lý bởi Phòng Đào tạo. Việc sử dụng hệ thống này đồng nghĩa với việc bạn đồng ý tuân thủ các điều khoản và điều kiện sử dụng.</p>
                
                <h6>2. Quyền và trách nhiệm người dùng</h6>
                <p>- Cung cấp thông tin chính xác và đầy đủ khi đăng ký tài khoản<br>
                - Bảo mật thông tin tài khoản và mật khẩu của mình<br>
                - Chịu trách nhiệm cho mọi hoạt động diễn ra dưới tài khoản của mình<br>
                - Sử dụng hệ thống đúng mục đích và tuân thủ quy định của nhà trường</p>
                
                <h6>3. Bảo mật thông tin</h6>
                <p>Thông tin cá nhân của bạn sẽ được bảo mật và chỉ được sử dụng cho mục đích quản lý hệ thống PDU PMS. Chúng tôi cam kết không chia sẻ thông tin của bạn cho bên thứ ba nếu không được sự đồng ý.</p>
                
                <h6>4. Điều khoản đặt phòng</h6>
                <p>- Việc đặt phòng cần được thực hiện đúng quy trình và phải được phê duyệt<br>
                - Người dùng cần tuân thủ lịch đặt phòng đã được duyệt<br>
                - Trường hợp hủy đặt phòng cần thông báo trước ít nhất 24 giờ</p>
                
                <h6>5. Quy định sử dụng phòng và thiết bị</h6>
                <p>- Sử dụng phòng học và thiết bị đúng mục đích<br>
                - Giữ gìn, bảo quản tài sản trong phòng học<br>
                - Báo cáo kịp thời các sự cố về phòng học và thiết bị</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Form validation
    (function() {
        'use strict'
        
        // Fetch all forms we want to apply validation to
        var forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    // Check if passwords match
                    var password = document.getElementById('password')
                    var confirmPassword = document.getElementById('confirm_password')
                    
                    if (password.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity('Mật khẩu xác nhận không khớp')
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        confirmPassword.setCustomValidity('')
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
    
    // Show/hide class code field based on role selection
    document.getElementById('role').addEventListener('change', function() {
        var classCodeContainer = document.getElementById('class_code_container')
        var classCodeInput = document.getElementById('class_code')
        
        if (this.value === 'student') {
            classCodeContainer.classList.remove('d-none')
            classCodeInput.setAttribute('required', 'required')
        } else {
            classCodeContainer.classList.add('d-none')
            classCodeInput.removeAttribute('required')
        }
    })
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
