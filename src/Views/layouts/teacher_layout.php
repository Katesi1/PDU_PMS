<?php
// Đảm bảo chỉ cho teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: /pdu_pms_project/public/login');
    exit;
}

// Include header layout
include(dirname(__DIR__) . '/layouts/header.php');
// Include teacher sidebar
include(dirname(__DIR__) . '/layouts/teacher_sidebar.php');

// The content of each teacher page will be placed here
?> 

<!-- Common JavaScript libraries for teacher pages -->
<!-- Make sure jQuery is loaded first if not already in header -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> 