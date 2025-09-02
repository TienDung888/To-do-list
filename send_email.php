<?php
session_start();
require_once 'config.php';
require "vendor/autoload.php";
$database='user_db';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['name'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
    exit();
}

// 2. Lấy email từ database
$name = $_SESSION['name'];
$stmt = $conn->prepare("SELECT email FROM users WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy email người dùng!']);
    exit();
}

$to_email = $user['email'];

// 3. Nhận dữ liệu CSV từ JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$csvContent = $data['csvContent'];
$filename = $data['filename'];

// 4. Gửi email bằng PHPMailer
$mail = new PHPMailer(true);

try {
    // Cấu hình SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'khieuhuutiendung@gmail.com';
    $mail->Password = 'yfxdyydzvyccnzaq'; // Đảm bảo mật khẩu ứng dụng còn hợp lệ
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';

    // Thiết lập người gửi/nhận
    $mail->setFrom('khieuhuutiendung@gmail.com', 'Productivity App');
    $mail->addAddress($to_email, $name);

    // Nội dung email
    $mail->isHTML(true);
    $mail->Subject = 'Danh sách công việc của bạn';
    $mail->Body = "
        <h3>Xin chào $name!</h3>
        <p>Đây là file CSV chứa danh sách công việc bạn vừa xuất từ ứng dụng.</p>
    ";

    // Đính kèm file CSV
    $mail->addStringAttachment($csvContent, $filename, 'base64', 'text/csv');

    // Gửi email
    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Đã gửi email thành công!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Lỗi: {$mail->ErrorInfo}"]);
}
?>