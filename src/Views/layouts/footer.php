<!-- Footer được tích hợp vào header.php -->
<!-- File này được giữ lại để tương thích với các tham chiếu hiện có -->
<!-- Không cần nội dung ở đây vì đã được chuyển vào header.php -->

<?php if (isset($_SESSION['user_id']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'teacher')): ?>
            </div> <!-- Close container-fluid -->
        </div> <!-- Close page-content -->
    </main> <!-- Close main-content -->
</div> <!-- Close admin-layout -->

<!-- Sidebar Toggle Script for Admin -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileToggle = document.getElementById('mobileToggle');
        const overlay = document.getElementById('overlay');
        
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.classList.toggle('sidebar-open');
            });
        }
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Change icon if needed
                const icon = sidebarToggle.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.className = 'fas fa-chevron-right';
                } else {
                    icon.className = 'fas fa-bars';
                }
            });
        }
        
        // Mobile overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            });
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                overlay.classList.remove('active');
                document.body.classList.remove('sidebar-open');
                sidebar.classList.remove('active');
            }
        });
        
        // Initialize DataTables if any tables with .datatable class exist
        if (typeof $.fn.DataTable !== 'undefined' && $('.datatable').length > 0) {
            $('.datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
                },
                responsive: true
            });
        }
    });
</script>

<?php else: ?>
    <!-- Footer for public pages -->
    </div> <!-- Close main-content div -->
    <footer class="py-4 bg-dark text-white mt-auto" style="position: relative; z-index: 20;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">PDU PMS</h5>
                    <p class="mb-0">Hệ thống Quản lý Phòng Đào tạo - Giải pháp hiện đại cho quản lý tài nguyên giáo dục.</p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="mb-3">Liên kết</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="/pdu_pms_project/public/" class="text-white text-decoration-none">Trang chủ</a></li>
                        <li class="mb-2"><a href="/pdu_pms_project/public/page/guide" class="text-white text-decoration-none">Hướng dẫn</a></li>
                        <li class="mb-2"><a href="/pdu_pms_project/public/page/about" class="text-white text-decoration-none">Giới thiệu</a></li>
                        <li><a href="/pdu_pms_project/public/page/contact" class="text-white text-decoration-none">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h6 class="mb-3">Hỗ trợ</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Trung tâm trợ giúp</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Điều khoản sử dụng</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Liên hệ</h6>
                    <p class="mb-1"><i class="fas fa-envelope me-2"></i> contact@pdupms.edu.vn</p>
                    <p class="mb-1"><i class="fas fa-phone me-2"></i> (024) 7300 1955</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-white">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">© <?= date('Y') ?> PDU PMS. Bản quyền thuộc về Phòng Đào tạo.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Phát triển bởi <a href="#" class="text-white">Team PDU</a></p>
                </div>
            </div>
        </div>
    </footer>
</div> <!-- Close public-layout -->
<?php endif; ?>

<style>
    /* Fix đè nội dung cho footer */
    footer {
        position: relative;
        z-index: 20 !important;
    }
    
    footer a:hover {
        opacity: 0.8;
    }
    
    /* Đảm bảo khoảng cách phù hợp giữa content và footer */
    body:not(.admin-layout) .container:last-child {
        margin-bottom: 0;
    }
    
    /* Đảm bảo footer không bị đè */
    .public-layout {
        min-height: auto; /* Thay đổi min-height để loại bỏ khoảng trắng */
        display: flex;
        flex-direction: column;
    }
    
    .public-layout footer {
        margin-top: auto;
    }
    
    /* Loại bỏ khoảng trắng 1 trang từ DOCTYPE */
    html {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    /* Reset margin và padding trong container */
    .container {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    /* Fixes đặc biệt cho trang chủ */
    body, html {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Chuyên biệt cho home.php */
    section:first-of-type {
        margin-top: 0 !important;
    }
    
    .public-header + * {
        margin-top: 0 !important;
    }
</style>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js for admin pages -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Custom JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips if Bootstrap is loaded
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Initialize popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        }
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                if(alert && bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    });
</script>
</body>
</html>