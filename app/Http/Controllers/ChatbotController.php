<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        
        $reply = $this->getReply($message);

        // Simulate a slight delay to make it feel like someone is typing
        usleep(500000); // 0.5s

        return response()->json([
            'reply' => $reply
        ]);
    }

    private function getReply($message)
    {
        // Simple keyword matching for a Volunteer Platform FAQ
        
        if (str_contains($message, 'chào') || str_contains($message, 'hello') || str_contains($message, 'hi')) {
            return "Xin chào! Mình là trợ lý ảo của VWA. Mình có thể giúp gì cho bạn hôm nay?";
        }

        if (str_contains($message, 'sos') || str_contains($message, 'khẩn cấp') || str_contains($message, 'cấp cứu')) {
            return "Trường hợp KHẨN CẤP: Vui lòng sử dụng nút SOS màu đỏ ở menu để gửi cảnh báo ngay lập tức đến Ban tổ chức kèm vị trí hiện tại của bạn. Hoặc gọi số: 115 (Cấp cứu), 113 (Cảnh sát).";
        }

        if (str_contains($message, 'điểm danh') || str_contains($message, 'check in') || str_contains($message, 'checkin')) {
            return "Để điểm danh, bạn hãy vào mục 'Điểm danh' ở thanh menu bên trái, chọn 'Mở Camera' và quét mã QR do Ban tổ chức cung cấp nhé.";
        }

        if (str_contains($message, 'đăng ký') || str_contains($message, 'tham gia')) {
            return "Bạn có thể xem các sự kiện đang mở đăng ký tại trang 'Sự kiện'. Bấm vào sự kiện bạn quan tâm và nhấn nút 'Đăng ký ngay'.";
        }

        if (str_contains($message, 'chứng nhận') || str_contains($message, 'certificate')) {
            return "Chứng nhận sẽ được cấp sau khi bạn hoàn thành nhiệm vụ và được Ban tổ chức đánh giá. Bạn có thể xem chứng nhận tại trang 'Hồ sơ cá nhân'.";
        }

        if (str_contains($message, 'quên mật khẩu') || str_contains($message, 'mật khẩu')) {
            return "Để lấy lại mật khẩu, bạn vui lòng sử dụng chức năng 'Quên mật khẩu' ở trang Đăng nhập, hệ thống sẽ gửi liên kết khôi phục qua email của bạn.";
        }
        
        if (str_contains($message, 'hủy') && str_contains($message, 'sự kiện')) {
            return "Bạn có thể hủy đăng ký sự kiện trong vòng 3 giờ kể từ lúc đăng ký hoặc trước khi sự kiện bắt đầu. Hãy vào mục 'Sự kiện của tôi' và chọn 'Hủy đăng ký'.";
        }

        if (str_contains($message, 'liên hệ') || str_contains($message, 'hỗ trợ')) {
            return "Bạn có thể liên hệ trực tiếp với Ban quản trị qua email: support@vwa.vn hoặc số điện thoại 0123.456.789 trong giờ hành chính.";
        }

        // Default response
        return "Xin lỗi, mình chưa hiểu ý bạn. Mình vẫn đang học hỏi mỗi ngày. Bạn có thể diễn đạt lại hoặc liên hệ với Ban quản trị qua email support@vwa.vn nhé!";
    }
}
