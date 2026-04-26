# Hệ thống Quản lý Tình nguyện viên và Sự kiện Cộng đồng

## Tổng quan
Hệ thống chuyển đổi mô hình quản lý thủ công sang nền tảng Web App tập trung, giúp tự động hóa quy trình từ lúc lên ý tưởng sự kiện đến khi cấp chứng nhận.

## Tính năng chính
- **Quản trị Sự kiện (Event Governance)**: Duyệt đa tầng, cảnh báo xung đột thời gian/địa điểm.
- **Quản lý Tài chính (Financial Management)**: Dự trù, duyệt ngân sách và quyết toán với minh chứng hóa đơn.
- **Điểm danh thông minh (Smart Attendance)**: QR Code động kết hợp GPS Fencing.
- **Hồ sơ năng lực số (E-Portfolio)**: Tự động tổng hợp thành tích, xuất chứng nhận PDF.

## Yêu cầu Hệ thống
- PHP >= 8.1
- Composer
- MySQL 8.0

## Cài đặt (Khi có Composer)
1. Clone dự án.
2. Chạy `composer install`.
3. Copy file `.env.example` thành `.env` và cấu hình Database.
4. Chạy `php artisan key:generate`.
5. Chạy `php artisan migrate`.
6. Chạy `npm install && npm run dev`.

## Cấu trúc thư mục (Skeleton)
Dự án này hiện tại là cấu trúc khung sườn (Skeleton) được tạo thủ công, chưa bao gồm thư mục `vendor`.
