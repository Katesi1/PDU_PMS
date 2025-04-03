<?php
$pageTitle = "Đăng nhập";
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
    
    /* Container chứa nội dung đăng nhập */
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

<!-- Sử dụng container riêng biệt cho trang đăng nhập -->
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="auth-card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Đăng nhập hệ thống PDU PMS</h4>
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
                        
                        <form action="/pdu_pms_project/public/login/authenticate" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                                <label class="form-check-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="login" class="btn btn-primary">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Chưa có tài khoản? <a href="/pdu_pms_project/public/register">Đăng ký</a></p>
                        <p class="mt-2 mb-0"><a href="/pdu_pms_project/public/forgot-password">Quên mật khẩu?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
