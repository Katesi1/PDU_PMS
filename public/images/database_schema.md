```mermaid
erDiagram
    users {
        int id PK
        string username
        string email
        string password
        string full_name
        enum role
        string class_code
        datetime created_at
        datetime updated_at
    }

    rooms {
        int id PK
        string room_number
        string building
        string floor
        int capacity
        int room_type_id FK
        string description
        enum status
        datetime created_at
        datetime updated_at
    }

    room_types {
        int id PK
        string name
        string description
        datetime created_at
        datetime updated_at
    }

    equipment {
        int id PK
        string name
        string description
        int room_id FK
        enum status
        datetime created_at
        datetime updated_at
    }

    timetables {
        int id PK
        string class_code
        string subject_code
        int room_id FK
        int teacher_id FK
        date start_date
        date end_date
        enum day_of_week
        time start_time
        time end_time
        string note
        datetime created_at
        datetime updated_at
    }

    bookings {
        int id PK
        int user_id FK
        int room_id FK
        datetime start_time
        datetime end_time
        string purpose
        enum status
        string note
        int approval_user_id FK
        datetime approval_time
        datetime created_at
        datetime updated_at
    }

    maintenance_requests {
        int id PK
        int room_id FK
        int user_id FK
        string issue_description
        enum status
        string resolution_note
        int resolved_by_user_id FK
        datetime resolved_at
        datetime created_at
        datetime updated_at
    }

    schedules {
        int id PK
        int timetable_id FK
        int room_id FK
        date date
        time start_time
        time end_time
        string note
        datetime created_at
        datetime updated_at
    }

    users ||--o{ bookings : "tạo"
    users ||--o{ maintenance_requests : "báo cáo"
    users ||--o{ timetables : "dạy"

    rooms ||--o{ bookings : "được đặt bởi"
    rooms ||--o{ timetables : "được lên lịch trong"
    rooms ||--o{ equipment : "chứa"
    rooms ||--o{ maintenance_requests : "có"
    rooms ||--o{ schedules : "được sử dụng theo"

    room_types ||--o{ rooms : "phân loại"

    timetables ||--o{ schedules : "tạo ra"
}
```
