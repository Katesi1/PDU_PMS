# Biểu Đồ Kiến Trúc Hệ Thống PDU_PMS

Tài liệu này mô tả các biểu đồ kiến trúc của hệ thống PDU_PMS (Hệ Thống Quản Lý Phòng Đào Tạo).

## Biểu Đồ Hoạt Động (Activity Diagram)

File: `activity_diagram.md`

Biểu đồ hoạt động mô tả các luồng công việc chính trong hệ thống PDU_PMS, bao gồm:

- Quy trình đăng nhập và xác thực người dùng
- Luồng công việc dựa trên vai trò (Admin, Giáo viên, Sinh viên)
- Quy trình quản lý phòng học, thời khóa biểu và đặt phòng
- Quy trình phê duyệt và xử lý yêu cầu đặt phòng

## Biểu Đồ Luồng Dữ Liệu (Data Flow Diagram)

File: `data_flow_diagram.md`

Biểu đồ luồng dữ liệu mô tả cách thông tin di chuyển giữa các thành phần của hệ thống:

- Tương tác giữa người dùng và các controller
- Luồng dữ liệu giữa các controller và model
- Xử lý thông tin từ cơ sở dữ liệu và hiển thị cho người dùng

## Biểu Đồ Kiến Trúc MVC (MVC Architecture Diagram)

File: `mvc_architecture.md`

Biểu đồ kiến trúc MVC mô tả cấu trúc phát triển của ứng dụng PDU_PMS:

- Tương tác giữa người dùng và hệ thống
- Mối quan hệ giữa các thành phần Model, View, và Controller
- Cấu trúc tệp và thư mục của ứng dụng
- Cách hệ thống xử lý yêu cầu và trả về kết quả

## Biểu Đồ Cơ Sở Dữ Liệu (Database Schema)

File: `database_schema.md`

Biểu đồ cơ sở dữ liệu mô tả cấu trúc dữ liệu của hệ thống:

- Các bảng trong cơ sở dữ liệu
- Thuộc tính và kiểu dữ liệu của mỗi bảng
- Mối quan hệ giữa các bảng
- Khóa chính và khóa ngoại

## Cách Sử Dụng Biểu Đồ

Các biểu đồ này được viết bằng cú pháp Mermaid và có thể được hiển thị bằng các công cụ hỗ trợ Mermaid như:

- GitHub (hỗ trợ trực tiếp hiển thị Mermaid)
- VSCode với extension Mermaid
- Trang web [Mermaid Live Editor](https://mermaid.live/)
- Các trình duyệt web với plugin Mermaid

## Cập Nhật Biểu Đồ

Khi hệ thống thay đổi, hãy cập nhật các biểu đồ này để đảm bảo tài liệu luôn phản ánh chính xác kiến trúc hiện tại của hệ thống.
