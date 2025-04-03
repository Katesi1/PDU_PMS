<?php

namespace Models;

use Config\Database;

class RoomModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Lấy tổng số phòng học
    public function getTotalRooms()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM rooms");
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // Lấy danh sách các phòng được sử dụng nhiều nhất
    public function getMostUsedRooms($limit = 5)
    {
        $limit = (int)$limit; // Ép kiểu để đảm bảo an toàn

        // Trả về tên các cột phù hợp với view
        $stmt = $this->db->prepare(
            "SELECT r.id, r.name as room_number, r.capacity, 
         '' as type, COUNT(b.id) AS booking_count 
         FROM rooms r
         LEFT JOIN bookings b ON r.id = b.room_id
         GROUP BY r.id
         ORDER BY booking_count DESC
         LIMIT $limit"
        );

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllRooms()
    {
        $stmt = $this->db->prepare("SELECT * FROM rooms");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRoomById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Thêm phương thức để lấy danh sách phòng trống trong khoảng thời gian
    public function getAvailableRoomsByTimeRange($start_time, $end_time, $participants)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM rooms 
             WHERE status = 'trống' AND capacity >= ?"
        );
        $stmt->execute([$participants]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addRoom($name, $capacity, $location = null, $notes = null)
    {
        $stmt = $this->db->prepare("INSERT INTO rooms (name, capacity, status, location, notes) VALUES (?, ?, 'trống', ?, ?)");
        return $stmt->execute([$name, $capacity, $location, $notes]);
    }

    public function updateRoom($id, $name, $capacity, $status, $location = null, $notes = null)
    {
        $stmt = $this->db->prepare("UPDATE rooms SET name = ?, capacity = ?, status = ?, location = ?, notes = ? WHERE id = ?");
        return $stmt->execute([$name, $capacity, $status, $location, $notes, $id]);
    }

    public function deleteRoom($id)
    {
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Thêm phương thức để lấy phòng theo loại
    public function getRoomsByType($typeId)
    {
        try {
            // Vì hiện tại không có cột room_type_id trong bảng rooms
            // Tạm thời trả về danh sách tất cả các phòng
            $stmt = $this->db->prepare("
                SELECT * FROM rooms 
                ORDER BY name ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting rooms by type: " . $e->getMessage());
            return [];
        }
    }

    // Lấy danh sách loại phòng
    public function getRoomTypes()
    {
        $stmt = $this->db->prepare("SELECT * FROM room_types ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Phương thức tìm kiếm phòng theo các tiêu chí
    public function searchRooms($params = [])
    {
        $sql = "SELECT r.* FROM rooms r WHERE 1=1";
        $binds = [];
        
        if (!empty($params['name'])) {
            $sql .= " AND r.name LIKE ?";
            $binds[] = '%' . $params['name'] . '%';
        }
        
        if (!empty($params['min_capacity'])) {
            $sql .= " AND r.capacity >= ?";
            $binds[] = $params['min_capacity'];
        }
        
        if (!empty($params['status'])) {
            $sql .= " AND r.status = ?";
            $binds[] = $params['status'];
        }
        
        if (!empty($params['location'])) {
            $sql .= " AND r.location LIKE ?";
            $binds[] = '%' . $params['location'] . '%';
        }
        
        $sql .= " ORDER BY r.name ASC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($binds);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error searching rooms: " . $e->getMessage());
            return [];
        }
    }

    // Lấy thông tin chi tiết của một phòng
    public function getDetailedRoom($id)
    {
        $sql = "SELECT r.* FROM rooms r WHERE r.id = ?";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $room = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($room) {
                // Lấy danh sách thiết bị trong phòng
                $sql = "SELECT e.id, e.name, e.description, e.status, e.purchase_date, e.last_maintenance_date
                        FROM equipment e
                        WHERE e.room_id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id]);
                $room['equipment'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            
            return $room;
        } catch (\PDOException $e) {
            error_log("Error getting detailed room: " . $e->getMessage());
            return null;
        }
    }

    // Lấy danh sách các lớp học sắp diễn ra trong phòng
    public function getUpcomingClassesForRoom($roomId)
    {
        $sql = "SELECT b.id, b.start_time, b.end_time, b.status, b.class_code, 
                       u1.full_name as teacher_name, u2.full_name as student_name
                FROM bookings b
                LEFT JOIN users u1 ON b.teacher_id = u1.id
                LEFT JOIN users u2 ON b.student_id = u2.id
                WHERE b.room_id = ? AND b.end_time > NOW()
                ORDER BY b.start_time ASC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$roomId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting upcoming classes: " . $e->getMessage());
            return [];
        }
    }

    // Đề xuất khung giờ trống tiếp theo cho phòng
    public function suggestNextAvailableTime($roomId)
    {
        $dayStart = '08:00:00';
        $dayEnd = '18:00:00';
        $slotDuration = 2; // 2 tiếng cho mỗi slot
        
        // Lấy các booking hiện tại của phòng trong 7 ngày tới
        $sql = "SELECT start_time, end_time 
                FROM bookings 
                WHERE room_id = ? 
                AND start_time BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)
                ORDER BY start_time ASC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$roomId]);
            $existingBookings = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $availableSlots = [];
            $currentDate = new \DateTime();
            
            // Kiểm tra 7 ngày tới
            for ($i = 0; $i < 7; $i++) {
                $dateString = $currentDate->format('Y-m-d');
                $startTime = new \DateTime($dateString . ' ' . $dayStart);
                $endTime = new \DateTime($dateString . ' ' . $dayEnd);
                
                // Tạo các slot trong ngày
                $slotStart = clone $startTime;
                while ($slotStart < $endTime) {
                    $slotEnd = clone $slotStart;
                    $slotEnd->modify('+' . $slotDuration . ' hours');
                    
                    if ($slotEnd > $endTime) {
                        $slotEnd = clone $endTime;
                    }
                    
                    // Kiểm tra xem slot này có khả dụng không
                    $available = true;
                    foreach ($existingBookings as $booking) {
                        $bookingStart = new \DateTime($booking['start_time']);
                        $bookingEnd = new \DateTime($booking['end_time']);
                        
                        // Nếu có sự chồng chéo, slot không khả dụng
                        if (($slotStart < $bookingEnd) && ($slotEnd > $bookingStart)) {
                            $available = false;
                            break;
                        }
                    }
                    
                    // Chỉ thêm các slot trong tương lai
                    $now = new \DateTime();
                    if ($available && $slotStart > $now) {
                        $availableSlots[] = [
                            'start' => $slotStart->format('Y-m-d H:i:s'),
                            'end' => $slotEnd->format('Y-m-d H:i:s')
                        ];
                    }
                    
                    $slotStart = clone $slotEnd;
                }
                
                $currentDate->modify('+1 day');
            }
            
            return $availableSlots;
        } catch (\PDOException $e) {
            error_log("Error suggesting available times: " . $e->getMessage());
            return [];
        }
    }

    // Lấy các phòng trống theo thời gian và loại phòng
    public function getAvailableRoomsByTimeAndType($startTime, $endTime, $roomTypeId = null, $minCapacity = 0)
    {
        $sql = "SELECT r.*
                FROM rooms r
                WHERE r.status = 'trống'";
        
        $binds = [];
        
        if ($minCapacity > 0) {
            $sql .= " AND r.capacity >= ?";
            $binds[] = $minCapacity;
        }
        
        $sql .= " AND r.id NOT IN (
                    SELECT b.room_id
                    FROM bookings b
                    WHERE ((b.start_time <= ? AND b.end_time > ?)
                       OR (b.start_time < ? AND b.end_time >= ?)
                       OR (b.start_time >= ? AND b.end_time <= ?))
                    AND b.status IN ('đã duyệt', 'chờ duyệt')
                )";
        
        $binds[] = $endTime;
        $binds[] = $startTime;
        $binds[] = $endTime;
        $binds[] = $startTime;
        $binds[] = $startTime;
        $binds[] = $endTime;
        
        $sql .= " ORDER BY r.capacity ASC";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($binds);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting available rooms: " . $e->getMessage());
            return [];
        }
    }

    // Đếm số lượng phòng theo loại phòng
    public function countRoomsByType()
    {
        try {
            // Lấy tất cả loại phòng
            $sql = "SELECT id, name, description FROM room_types ORDER BY name ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $roomTypes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Thêm trường room_count với giá trị mặc định là 0
            foreach ($roomTypes as &$type) {
                $type['room_count'] = 0;
            }
            
            // Kiểm tra xem bảng rooms có cột room_type_id không
            $checkColumnSql = "SHOW COLUMNS FROM rooms LIKE 'room_type_id'";
            $stmt = $this->db->prepare($checkColumnSql);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                // Nếu có cột room_type_id, lấy số lượng phòng cho mỗi loại
                $countSql = "SELECT room_type_id, COUNT(*) as count FROM rooms GROUP BY room_type_id";
                $stmt = $this->db->prepare($countSql);
                $stmt->execute();
                $counts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                
                // Cập nhật số lượng phòng cho từng loại
                foreach ($counts as $count) {
                    foreach ($roomTypes as &$type) {
                        if ($type['id'] == $count['room_type_id']) {
                            $type['room_count'] = $count['count'];
                            break;
                        }
                    }
                }
            }
            
            return $roomTypes;
        } catch (\PDOException $e) {
            error_log("Error counting rooms by type: " . $e->getMessage());
            return [];
        }
    }

    public function getRoomEquipments($room_id)
    {
        $stmt = $this->db->prepare("
            SELECT re.*, e.name as equipment_name, e.description as equipment_description 
            FROM room_equipments re
            JOIN equipments e ON re.equipment_id = e.id
            WHERE re.room_id = ?
            ORDER BY e.name ASC
        ");
        $stmt->execute([$room_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Thêm loại phòng mới
    public function addRoomType($name, $description = '')
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO room_types (name, description) VALUES (?, ?)");
            $success = $stmt->execute([$name, $description]);
            
            if ($success) {
                return $this->db->lastInsertId(); // Trả về ID của loại phòng mới được thêm vào
            }
            return false;
        } catch (\PDOException $e) {
            error_log("Error adding room type: " . $e->getMessage());
            return false;
        }
    }
    
    // Cập nhật loại phòng
    public function updateRoomType($id, $name, $description = '')
    {
        try {
            $stmt = $this->db->prepare("UPDATE room_types SET name = ?, description = ? WHERE id = ?");
            return $stmt->execute([$name, $description, $id]);
        } catch (\PDOException $e) {
            error_log("Error updating room type: " . $e->getMessage());
            return false;
        }
    }
    
    // Xóa loại phòng
    public function deleteRoomType($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM room_types WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Error deleting room type: " . $e->getMessage());
            return false;
        }
    }
}
