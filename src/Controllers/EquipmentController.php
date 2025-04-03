<?php

namespace Controllers;

use Models\EquipmentModel;
use Models\RoomModel;
use Models\MaintenanceRequestModel;

class EquipmentController
{
    private $equipmentModel;
    private $roomModel;
    private $maintenanceRequestModel;

    public function __construct()
    {
        $this->equipmentModel = new EquipmentModel();
        $this->roomModel = new RoomModel();
        $this->maintenanceRequestModel = new MaintenanceRequestModel();
    }

    // Hiển thị trang quản lý thiết bị
    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        return [
            'equipments' => $this->equipmentModel->getAllEquipments(),
            'maintenance_needed' => $this->equipmentModel->getEquipmentsNeedingMaintenance()
        ];
    }

    // Hiển thị trang thêm thiết bị mới
    public function addEquipment($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';
            $maintenance_period = $data['maintenance_period'] ?? 90;

            if ($name) {
                $success = $this->equipmentModel->addEquipment($name, $description, $maintenance_period);
                if ($success) {
                    header('Location: /pdu_pms_project/public/admin/equipments?message=Thiết bị đã được thêm thành công');
                    exit;
                } else {
                    return ['error' => 'Không thể thêm thiết bị, vui lòng thử lại.'];
                }
            } else {
                return ['error' => 'Vui lòng nhập tên thiết bị.'];
            }
        }

        return [];
    }

    // Hiển thị trang sửa thiết bị
    public function editEquipment($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        $id = $data['id'] ?? null;
        if (!$id) {
            header('Location: /pdu_pms_project/public/admin/equipments?error=ID thiết bị không hợp lệ');
            exit;
        }

        $equipment = $this->equipmentModel->getEquipmentById($id);
        if (!$equipment) {
            header('Location: /pdu_pms_project/public/admin/equipments?error=Không tìm thấy thiết bị');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';
            $maintenance_period = $data['maintenance_period'] ?? 90;

            if ($name) {
                $success = $this->equipmentModel->updateEquipment($id, $name, $description, $maintenance_period);
                if ($success) {
                    header('Location: /pdu_pms_project/public/admin/equipments?message=Thiết bị đã được cập nhật thành công');
                    exit;
                } else {
                    return [
                        'error' => 'Không thể cập nhật thiết bị, vui lòng thử lại.',
                        'equipment' => $equipment
                    ];
                }
            } else {
                return [
                    'error' => 'Vui lòng nhập tên thiết bị.',
                    'equipment' => $equipment
                ];
            }
        }

        return ['equipment' => $equipment];
    }

    // Xóa thiết bị
    public function deleteEquipment($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        $id = $data['id'] ?? null;
        if (!$id) {
            header('Location: /pdu_pms_project/public/admin/equipments?error=ID thiết bị không hợp lệ');
            exit;
        }

        $success = $this->equipmentModel->deleteEquipment($id);
        if ($success) {
            header('Location: /pdu_pms_project/public/admin/equipments?message=Thiết bị đã được xóa thành công');
        } else {
            header('Location: /pdu_pms_project/public/admin/equipments?error=Không thể xóa thiết bị');
        }
        exit;
    }

    // Hiển thị trang quản lý thiết bị trong phòng
    public function manageRoomEquipments($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        $room_id = $data['room_id'] ?? null;
        if (!$room_id) {
            header('Location: /pdu_pms_project/public/admin/manage_rooms?error=ID phòng không hợp lệ');
            exit;
        }

        $room = $this->roomModel->getDetailedRoom($room_id);
        if (!$room) {
            header('Location: /pdu_pms_project/public/admin/manage_rooms?error=Không tìm thấy phòng');
            exit;
        }

        return [
            'room' => $room,
            'equipments' => $this->equipmentModel->getAllEquipments()
        ];
    }

    // Thêm thiết bị vào phòng
    public function addEquipmentToRoom($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $room_id = $data['room_id'] ?? null;
            $equipment_id = $data['equipment_id'] ?? null;
            $quantity = $data['quantity'] ?? 1;
            $notes = $data['notes'] ?? '';

            if (!$room_id || !$equipment_id || $quantity < 1) {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Thông tin thiết bị không hợp lệ');
                exit;
            }

            $success = $this->equipmentModel->addEquipmentToRoom($room_id, $equipment_id, $quantity, $notes);
            if ($success) {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&message=Thiết bị đã được thêm vào phòng thành công');
            } else {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Không thể thêm thiết bị vào phòng');
            }
            exit;
        }

        header('Location: /pdu_pms_project/public/admin/manage_rooms');
        exit;
    }

    // Cập nhật thiết bị trong phòng
    public function updateRoomEquipment($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $data['id'] ?? null;
            $room_id = $data['room_id'] ?? null;
            $quantity = $data['quantity'] ?? 1;
            $status = $data['status'] ?? 'hoạt động';
            $notes = $data['notes'] ?? '';

            if (!$id || !$room_id || $quantity < 0) {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Thông tin thiết bị không hợp lệ');
                exit;
            }

            $success = $this->equipmentModel->updateRoomEquipment($id, $quantity, $status, $notes);
            if ($success) {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&message=Thiết bị đã được cập nhật thành công');
            } else {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Không thể cập nhật thiết bị');
            }
            exit;
        }

        header('Location: /pdu_pms_project/public/admin/manage_rooms');
        exit;
    }

    // Xóa thiết bị khỏi phòng
    public function removeEquipmentFromRoom($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        $id = $data['id'] ?? null;
        $room_id = $data['room_id'] ?? null;

        if (!$id || !$room_id) {
            header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Thông tin thiết bị không hợp lệ');
            exit;
        }

        $success = $this->equipmentModel->removeEquipmentFromRoom($id);
        if ($success) {
            header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&message=Thiết bị đã được xóa khỏi phòng thành công');
        } else {
            header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Không thể xóa thiết bị khỏi phòng');
        }
        exit;
    }

    // Cập nhật thông tin bảo trì thiết bị
    public function updateMaintenance($data)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /pdu_pms_project/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $data['id'] ?? null;
            $room_id = $data['room_id'] ?? null;
            $last_maintenance = $data['last_maintenance'] ?? date('Y-m-d');
            $status = $data['status'] ?? 'hoạt động';

            if (!$id || !$room_id) {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Thông tin thiết bị không hợp lệ');
                exit;
            }

            $success = $this->equipmentModel->updateEquipmentMaintenance($id, $last_maintenance, $status);
            if ($success) {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&message=Thông tin bảo trì đã được cập nhật thành công');
            } else {
                header('Location: /pdu_pms_project/public/admin/room_equipments?room_id=' . $room_id . '&error=Không thể cập nhật thông tin bảo trì');
            }
            exit;
        }

        header('Location: /pdu_pms_project/public/admin/manage_rooms');
        exit;
    }
} 