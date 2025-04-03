<?php
namespace Controllers;

use Models\BookingModel;
use Models\RoomModel;

class TeacherController {
    private $bookingModel;
    private $roomModel;

    public function __construct() {
        $this->bookingModel = new BookingModel();
        $this->roomModel = new RoomModel();
    }

    public function index() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }
        $bookings = $this->bookingModel->getBookingsByTeacher($_SESSION['user_id']);
        return ['bookings' => $bookings];
    }

    public function bookRoom()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = $_POST['room_id'] ?? null;
            $class_code = $_POST['class_code'] ?? '';
            $start_time = $_POST['start_time'] ?? '';
            $end_time = $_POST['end_time'] ?? '';

            $teacher_id = $_SESSION['user_id'] ?? null;

            if (!$teacher_id) {
                return [
                    'error' => 'Bạn cần đăng nhập để đặt phòng',
                    'rooms' => $this->roomModel->getAllRooms(),
                    'available_rooms' => []
                ];
            }

            if ($room_id && $class_code && $start_time && $end_time) {
                // Chuyển đổi và kiểm tra định dạng thời gian
                $start_timestamp = strtotime($start_time);
                $end_timestamp = strtotime($end_time);
                
                if (!$start_timestamp || !$end_timestamp) {
                    return [
                        'error' => 'Định dạng thời gian không hợp lệ',
                        'rooms' => $this->roomModel->getAllRooms(),
                        'available_rooms' => []
                    ];
                }
                
                // Kiểm tra thời gian kết thúc phải sau thời gian bắt đầu
                if ($end_timestamp <= $start_timestamp) {
                    return [
                        'error' => 'Thời gian kết thúc phải sau thời gian bắt đầu',
                        'rooms' => $this->roomModel->getAllRooms(),
                        'available_rooms' => []
                    ];
                }
                
                $formatted_start = date('Y-m-d H:i:s', $start_timestamp);
                $formatted_end = date('Y-m-d H:i:s', $end_timestamp);
                
                // Kiểm tra xung đột lịch đặt phòng
                if ($this->bookingModel->checkBookingConflict($room_id, $formatted_start, $formatted_end)) {
                    return [
                        'error' => 'Phòng đã được đặt trong khoảng thời gian này',
                        'rooms' => $this->roomModel->getAllRooms(),
                        'available_rooms' => []
                    ];
                }

                $bookingData = [
                    'room_id' => $room_id,
                    'teacher_id' => $teacher_id,
                    'student_id' => null,
                    'class_code' => $class_code,
                    'start_time' => $formatted_start,
                    'end_time' => $formatted_end,
                    'status' => 'được duyệt'  // Teacher bookings are automatically approved
                ];

                if ($this->bookingModel->addBooking($bookingData)) {
                    return [
                        'success' => 'Đặt phòng thành công',
                        'rooms' => $this->roomModel->getAllRooms(),
                        'available_rooms' => []
                    ];
                } else {
                    return [
                        'error' => 'Đặt phòng thất bại, vui lòng thử lại',
                        'rooms' => $this->roomModel->getAllRooms(),
                        'available_rooms' => []
                    ];
                }
            } else {
                return [
                    'error' => 'Vui lòng điền đầy đủ thông tin',
                    'rooms' => $this->roomModel->getAllRooms(),
                    'available_rooms' => []
                ];
            }
        }

        // Lấy danh sách phòng khả dụng (trống) nếu có start_time và end_time
        $start_time = $_POST['start_time'] ?? null;
        $end_time = $_POST['end_time'] ?? null;
        $available_rooms = [];
        if ($start_time && $end_time) {
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $end_time = date('Y-m-d H:i:s', strtotime($end_time));
            $rooms = $this->roomModel->getAllRooms();
            foreach ($rooms as $room) {
                if (!$this->bookingModel->checkBookingConflict($room['id'], $start_time, $end_time)) {
                    $available_rooms[] = $room['id'];
                }
            }
        }

        return [
            'rooms' => $this->roomModel->getAllRooms(),
            'available_rooms' => $available_rooms
        ];
    }

    // Phương thức tìm kiếm phòng
    public function searchRooms($params = [])
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }
        
        $roomModel = new \Models\RoomModel();
        $searchParams = [];
        
        // Xử lý các tham số tìm kiếm
        if (!empty($params['name'])) {
            $searchParams['name'] = trim($params['name']);
        }
        
        if (!empty($params['room_type_id'])) {
            $searchParams['room_type_id'] = $params['room_type_id'];
        }
        
        if (!empty($params['min_capacity'])) {
            $searchParams['min_capacity'] = (int)$params['min_capacity'];
        }
        
        // Giáo viên chỉ tìm phòng trống để đặt
        $searchParams['status'] = 'trống';
        
        if (!empty($params['location'])) {
            $searchParams['location'] = trim($params['location']);
        }
        
        // Thực hiện tìm kiếm
        $rooms = $roomModel->searchRooms($searchParams);
        
        return [
            'rooms' => $rooms,
            'roomTypes' => $roomModel->getRoomTypes(),
            'searchParams' => $searchParams
        ];
    }

    // Phương thức xem chi tiết phòng
    public function roomDetail($params = [])
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }
        
        $roomModel = new \Models\RoomModel();
        $id = $params['id'] ?? 0;
        
        if (!$id) {
            header('Location: /pdu_pms_project/public/teacher/search_rooms?error=ID phòng không hợp lệ');
            exit;
        }
        
        $room = $roomModel->getDetailedRoom($id);
        if (!$room) {
            header('Location: /pdu_pms_project/public/teacher/search_rooms?error=Không tìm thấy phòng');
            exit;
        }
        
        // Lấy thông tin về các khung giờ trống của phòng
        $availableSlots = $roomModel->suggestNextAvailableTime($id);
        
        return [
            'room' => $room,
            'availableSlots' => $availableSlots
        ];
    }

    // Phương thức đề xuất phòng trống theo thời gian và loại
    public function suggestAvailableRooms($params = [])
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }
        
        $roomModel = new \Models\RoomModel();
        $start_time = $params['start_time'] ?? '';
        $end_time = $params['end_time'] ?? '';
        $room_type_id = $params['room_type_id'] ?? null;
        $min_capacity = $params['min_capacity'] ?? 0;
        
        $rooms = [];
        $roomTypes = $roomModel->getRoomTypes();
        
        if ($start_time && $end_time) {
            // Định dạng thời gian
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $end_time = date('Y-m-d H:i:s', strtotime($end_time));
            
            // Lấy danh sách phòng trống theo thời gian và loại
            $rooms = $roomModel->getAvailableRoomsByTimeAndType($start_time, $end_time, $room_type_id, $min_capacity);
        }
        
        return [
            'rooms' => $rooms,
            'roomTypes' => $roomTypes,
            'searchParams' => [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'room_type_id' => $room_type_id,
                'min_capacity' => $min_capacity
            ]
        ];
    }
}
